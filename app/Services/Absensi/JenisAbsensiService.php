<?php

namespace App\Services\Absensi;

use App\Models\Absensi\JenisAbsensi;
use Illuminate\Support\Collection;

final class JenisAbsensiService
{
    public function getListData(): Collection
    {
        return JenisAbsensi::all();
    }

    public function create(array $data) : JenisAbsensi
    {
        $data['jenis_absen_id'] = $this->generateId();
        return JenisAbsensi::create($data);
    }

    public function getDetailData(string $id): ?JenisAbsensi
    {
        return JenisAbsensi::find($id);
    }

    public function findById(string $id): ?JenisAbsensi
    {
        return JenisAbsensi::find($id);
    }

    public function update(JenisAbsensi $model, array $data): JenisAbsensi
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return JenisAbsensi::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = JenisAbsensi::orderBy('jenis_absen_id', 'desc')->first();

        if (!$last) {
            return 'JAI-001';
        }
        $lastNumber = intval(substr($last->jenis_absen_id, 4));

        $newNumber = $lastNumber + 1;

        return 'JAI-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
