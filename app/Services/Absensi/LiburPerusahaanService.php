<?php

namespace App\Services\Absensi;

use App\Models\Absensi\LiburPerusahaan;
use Illuminate\Support\Collection;

final class LiburPerusahaanService
{
    public function getListData(): Collection
    {
        return LiburPerusahaan::all();
    }

    public function create(array $data) : LiburPerusahaan
    {
        $data['kalPT_id'] = $this->generateId();
        return LiburPerusahaan::create($data);
    }

    public function getDetailData(string $id): ?LiburPerusahaan
    {
        return LiburPerusahaan::find($id);
    }

    public function findById(string $id): ?LiburPerusahaan
    {
        return LiburPerusahaan::find($id);
    }

    public function update(LiburPerusahaan $model, array $data): LiburPerusahaan
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return LiburPerusahaan::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = LiburPerusahaan::orderBy('kalPT_id', 'desc')->first();

        if (!$last) {
            return 'KPT-00001';
        }
        $lastNumber = intval(substr($last->kalnas_id, 4));

        $newNumber = $lastNumber + 1;

        return 'KPT-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
