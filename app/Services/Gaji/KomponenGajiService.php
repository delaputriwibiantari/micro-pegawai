<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiUmum;
use App\Models\Gaji\KomponenGaji;
use App\Models\Gaji\TarifPotongan;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class KomponenGajiService
{
    public function getListData(Request $request): Collection
    {
        return KomponenGaji::query()
            ->leftJoin('gaji_umum', function ($join) {
                $join->on('komponen_gaji.referensi_id', '=', 'gaji_umum.umum_id')
                     ->where('komponen_gaji.aturan_nominal', '=', 'gaji_umum');
            })
            ->leftJoin('tarif_potongan', function ($join) {
                $join->on('komponen_gaji.referensi_id', '=', 'tarif_potongan.potongan_id')
                     ->where('komponen_gaji.aturan_nominal', '=', 'tarif_potongan');
            })
            ->leftJoin('tarif_lembur', function ($join) {
                $join->on('komponen_gaji.referensi_id', '=', 'tarif_lembur.tarif_id')
                     ->where('komponen_gaji.aturan_nominal', '=', 'tarif_lembur');
            })
            ->select([
                'komponen_gaji.*',

                DB::raw("CASE
                    WHEN komponen_gaji.aturan_nominal = 'gaji_umum' THEN gaji_umum.umum_id
                    ELSE NULL
                END as gaji_umum_id"),
                DB::raw("CASE
                    WHEN komponen_gaji.aturan_nominal = 'gaji_umum' THEN gaji_umum.nominal
                    WHEN komponen_gaji.aturan_nominal = 'tarif_potongan' THEN tarif_potongan.tarif_per_kejadian
                    ELSE NULL
                END as nominal_referensi"),
                DB::raw("CASE
                    WHEN komponen_gaji.aturan_nominal = 'gaji_umum' THEN gaji_umum.nominal
                    WHEN komponen_gaji.aturan_nominal = 'tarif_lembur' THEN tarif_lembur.tarif_per_jam
                    ELSE NULL
                END as nominal_referensi_lembur"),

                'gaji_umum.nominal as nominal_gaji_umum',
                'tarif_potongan.nama_potongan',
                'tarif_potongan.tarif_per_kejadian as nominal_tarif',
                'tarif_lembur.tarif_per_jam as nominal_lembur'
            ])
            ->when($request->query('aturan_nominal'), function ($query, $aturan) {
                $query->where('komponen_gaji.aturan_nominal', $aturan);
            })
            ->when($request->query('is_umum'), function ($query, $isUmum) {
                $query->where('komponen_gaji.is_umum', $isUmum);
            })
            ->get();
    }

    public function create(array $data): KomponenGaji
    {
        $data['komponen_id'] = $this->generateId();

        if (isset($data['is_umum']) && $data['is_umum'] == true) {
            $data['aturan_nominal'] = 'gaji_umum';

            if (isset($data['umum_id']) && !empty($data['umum_id'])) {
                $data['referensi_id'] = $data['umum_id'];
            }
        }

        if (isset($data['aturan_nominal']) && $data['aturan_nominal'] !== 'manual') {
            if (!isset($data['referensi_id']) || empty($data['referensi_id'])) {

                if ($data['aturan_nominal'] === 'gaji_umum') {
                    $gajiUmum = GajiUmum::create([
                        'nominal' => $data['default_nominal'] ?? 0
                    ]);
                    $data['referensi_id'] = $gajiUmum->umum_id;
                    $data['is_umum'] = true;
                }
            }
        }

        return KomponenGaji::create($data);
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return KomponenGaji::orderBy($orderBy)->get();
    }

    public function getDetailData(string $id): ?KomponenGaji
    {

        $data = KomponenGaji::find($id);

        if (!$data) return null;

        if ($data->aturan_nominal === 'gaji_umum' && $data->referensi_id) {

            $gajiUmum = DB::connection('gaji')
                ->table('gaji_umum')
                ->where('umum_id', $data->referensi_id)
                ->first();

            if ($gajiUmum) {
                $data->gaji_umum_nominal = $gajiUmum->nominal;

                $data->gaji_umum_data = $gajiUmum;
            }
        } else if ($data->aturan_nominal === 'tarif_potongan' && $data->referensi_id) {

            $tarifPotongan = DB::connection('gaji')
                ->table('tarif_potongan')
                ->where('potongan_id', $data->referensi_id)
                ->first();

            if ($tarifPotongan) {
                $data->nama_potongan = $tarifPotongan->nama_potongan;
                $data->tarif_potongan_data = $tarifPotongan;
            }
        } else if ($data->aturan_nominal === 'tarif_lembur' && $data->referensi_id) {

            $tarifLembur = DB::connection('gaji')
                ->table('tarif_lembur')
                ->where('tarif_id', $data->referensi_id)
                ->first();

            if ($tarifLembur) {
                $data->jenis_lembur = $tarifLembur->jenis_lembur;
                $data->tarif_lembur_data = $tarifLembur;
            }
        }

        $data->is_umum = $data->is_umum == 1 || $data->is_umum === true || $data->is_umum === '1';


        if (!$data->aturan_nominal) {
            $data->aturan_nominal = $data->is_umum ? 'gaji_umum' : 'manual';
        }

        return $data;
    }

    public function findById(string $id): ?KomponenGaji
    {
        return KomponenGaji::find($id);
    }

    public function update(KomponenGaji $komponen, array $data): KomponenGaji
    {

        if (isset($data['is_umum']) && $data['is_umum'] == true) {
            $data['aturan_nominal'] = 'gaji_umum';


            if (!$komponen->referensi_id) {
                $gajiUmum = GajiUmum::create([
                    'nominal' => $data['default_nominal'] ?? $komponen->default_nominal ?? 0
                ]);
                $data['referensi_id'] = $gajiUmum->umum_id;
            }
        }


        if (isset($data['aturan_nominal'])) {
            switch ($data['aturan_nominal']) {
                case 'gaji_umum':
                    $data['is_umum'] = true;
                    break;
                case 'tarif_potongan':
                case 'tarif_lembur':
                case 'manual':
                    $data['is_umum'] = false;
                    break;
            }
        }

        $komponen->update($data);

        return $komponen;
    }

    public function getApiData(Request $request): Collection
    {
        return KomponenGaji::query()
            ->select([
                'komponen_gaji.*',

                DB::raw("CASE
                    WHEN aturan_nominal = 'gaji_umum' THEN 'Gaji Umum'
                    WHEN aturan_nominal = 'tarif_potongan' THEN 'Tarif Potongan'
                    WHEN aturan_nominal = 'tarif_lembur' THEN 'Tarif Lembur'
                    ELSE 'Manual'
                END as sumber_nominal")
            ])
            ->when($request->query('jenis'), function ($query, $jenis) {
                $query->where('komponen_gaji.jenis', $jenis);
            })
            ->when($request->query('is_umum'), function ($query, $isUmum) {
                $query->where('komponen_gaji.is_umum', $isUmum);
            })
            ->when($request->query('aturan_nominal'), function ($query, $aturan) {
                $query->where('komponen_gaji.aturan_nominal', $aturan);
            })
            ->orderBy('komponen_gaji.nama_komponen')
            ->get();
    }

    private function generateId(): string
    {
        $last = KomponenGaji::orderBy('komponen_id', 'desc')->first();

        if (!$last) {
            return 'GK-001';
        }
        $lastNumber = intval(substr($last->komponen_id, 4));

        $newNumber = $lastNumber + 1;

        return 'GK-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }


    public function migrateData(): array
    {
        $results = ['updated' => 0, 'skipped' => 0];

        if (!Schema::hasColumn('komponen_gaji', 'aturan_nominal')) {
            return ['error' => 'Kolom aturan_nominal belum ada di database'];
        }


        $updated1 = DB::table('komponen_gaji')
            ->where('is_umum', true)
            ->update([
                'aturan_nominal' => 'gaji_umum',
                'referensi_id' => DB::raw('umum_id')
            ]);
        $results['updated'] += $updated1;

        $updated2 = DB::table('komponen_gaji')
            ->where('is_umum', false)
            ->whereNull('aturan_nominal')
            ->update(['aturan_nominal' => 'manual']);
        $results['updated'] += $updated2;

        return $results;
    }
}
