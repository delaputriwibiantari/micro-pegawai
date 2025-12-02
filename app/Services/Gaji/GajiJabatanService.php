<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiJabatan;
use App\Models\Gaji\KomponenGaji;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

final class GajiJabatanService
{
    public function getListData(Request $request): Collection
    {
        return GajiJabatan::query()
            ->leftJoin('komponen_gaji', 'gaji_jabatan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->select([
                'gaji_jabatan.*',
                'komponen_gaji.komponen_id',
                'komponen_gaji.nama_komponen',
            ])
            ->when($request->query('komponen_id'), function ($query, $id_unit) {
                $query->where('gaji_jabatan.komponen_id', $id_unit);
            })
            ->get();
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
        return GajiJabatan::query()
            ->leftJoin('komponen_gaji', 'gaji_jabatan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->select([
                'gaji_jabatan.*',
                'komponen_gaji.komponen_id',
                'komponen_gaji.nama_komponen',
            ])
            ->where('gaji_jabatan.id', $id)
            ->first();
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
            ->select([
                'gaji_jabatan.*',
                'komponen_gaji.komponen_id',
                'komponen_gaji.nama_komponen',
            ])
            ->when($request->query('komponen_id'), function ($query, $id) {
                $query->where('gaji_jabatan.komponen_id', $id);
            })
            ->get();
    }
}
