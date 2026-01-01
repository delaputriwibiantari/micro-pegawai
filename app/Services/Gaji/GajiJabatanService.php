<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiJabatan;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class GajiJabatanService
{
    public function getListData(Request $request): Collection
    {
        // ambil data gaji dari database gaji
        $data = GajiJabatan::query()
            ->leftJoin('komponen_gaji', 'gaji_jabatan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->select([
                'gaji_jabatan.*',
                'komponen_gaji.nama_komponen',
            ])
            ->get();

        // ambil master jabatan dari database SDM
        $masterJabatan = DB::connection('mysql')
            ->table('master_jabatan')
            ->pluck('jabatan', 'id_jabatan');

        // mapping manual
        foreach ($data as $row) {
            $row->jabatan = $masterJabatan[$row->id_jabatan] ?? null;
        }

        return $data;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return GajiJabatan::orderBy($orderBy)->get();
    }

    public function create(array $data): GajiJabatan
    {
        return GajiJabatan::create([
            'gaji_master_id'   => $this->generateId(),
            'komponen_id'      => $data['komponen_id'],
            'id_jabatan'       => $data['id_jabatan'],
            'override_nominal' => $data['override_nominal'] ?? null,
            'use_override'     => $data['use_override'] ?? 0,
        ]);
    }



    public function getDetailData(string $id): ?GajiJabatan
    {
        $data = GajiJabatan::query()
            ->leftJoin('komponen_gaji', 'gaji_jabatan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->select([
                'gaji_jabatan.*',
                'komponen_gaji.nama_komponen',
            ])
            ->where('gaji_jabatan.id', $id)
            ->first();

        if (!$data) return null;

        // ambil dari database SDM
        $data->jabatan = DB::connection('mysql')
            ->table('master_jabatan')
            ->where('id_jabatan', $data->id_jabatan)
            ->value('jabatan');

        return $data;
    }


    public function findById(string $id): ?GajiJabatan
    {
        return GajiJabatan::find($id);
    }

    public function update(GajiJabatan $jabatan, array $data): GajiJabatan
    {
        $overrideNominal = $data['override_nominal'] ?? null;

        // Normalisasi dari frontend
        if ($overrideNominal === '' || $overrideNominal === null) {
            $overrideNominal = null;
        } else {
            $overrideNominal = (float) str_replace(',', '', $overrideNominal);
        }

        $jabatan->update([
            'komponen_id'      => $data['komponen_id'],
            'id_jabatan'       => $data['id_jabatan'],
            'override_nominal' => $overrideNominal,
            'use_override'     => $data['use_override'] ?? ($overrideNominal !== null ? 1 : 0),
        ]);

        return $jabatan;
    }





    public function getApiData(Request $request): Collection
    {
        return GajiJabatan::query()
            ->leftJoin('komponen_gaji', 'gaji_jabatan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->leftJoin('master_jabatan', 'gaji_jabatan.id_jabatan', '=', 'master_jabatan.id_jabatan')
            ->select([
                'gaji_jabatan.*',
                'komponen_gaji.komponen_id',
                'komponen_gaji.nama_komponen',
                'master_jabatan.jabatan',
            ])
            ->when($request->query('komponen_id'), function ($query, $id, $id_jabatan) {
                $query->where('gaji_jabatan.komponen_id', $id);
                 $query->where('gaji_jabatan.id_jabatan', $id_jabatan);
            })
            ->get();
    }

    private function generateId(): string
    {
        $last = GajiJabatan::orderBy('gaji_master_id', 'desc')->first();

        if (!$last) {
            return 'GMJ-001';
        }
        $lastNumber = intval(substr($last->gaji_master_id, 4));

        $newNumber = $lastNumber + 1;

        return 'GMJ-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
