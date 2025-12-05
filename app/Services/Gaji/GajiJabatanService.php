<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiJabatan;
use App\Models\Gaji\KomponenGaji;
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
        return GajiJabatan::create($data);
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
        $jabatan->update($data);

        return $jabatan;
    }

    public function getApiData(Request $request): Collection
    {
        return KomponenGaji::query()
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
}
