<?php

namespace App\Services\Gaji;

use App\Models\Gaji\KomponenGaji;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

final class KomponenGajiService
{
    public function getListData(Request $request): Collection
    {
        return KomponenGaji::query()
            ->leftJoin('gaji_umum', 'komponen_gaji.umum_id', '=', 'gaji_umum.umum_id')
            ->select([
                'komponen_gaji.*',
                'gaji_umum.umum_id',
                'gaji_umum.nominal',
            ])
            ->when($request->query('umum_id'), function ($query, $id_unit) {
                $query->where('komponen_gaji.umum_id', $id_unit);
            })
            ->get();
    }

    public function create(array $data): KomponenGaji
    {
        return KomponenGaji::create($data);
    }

    public function getDetailData(string $id): ?KomponenGaji
    {
        return KomponenGaji::query()
            ->leftJoin('gaji_umum', 'komponen_gaji.umum_id', '=', 'gaji_umum.umum_id')
            ->select([
                'komponen_gaji.*',
                'gaji_umum.umum_id',
                'gaji_umum.nominal',
            ])
            ->where('komponen_gaji.id', $id)
            ->first();
    }

    public function findById(string $id): ?KomponenGaji
    {
        return KomponenGaji::find($id);
    }

    public function update(KomponenGaji $jabatan, array $data): KomponenGaji
    {
        $jabatan->update($data);

        return $jabatan;
    }

    public function getApiData(Request $request): Collection
    {
        return KomponenGaji::query()
             ->leftJoin('gaji_umum', 'komponen_gaji.umum_id', '=', 'gaji_umum.umum_id')
            ->select([
                'komponen_gaji.*',
                'gaji_umum.umum_id',
                'gaji_umum.nominal',
            ])
            ->when($request->query('umum_id'), function ($query, $id_unit) {
                $query->where('komponen_gaji.umum_id', $id_unit);
            })
            ->get();
    }
}
