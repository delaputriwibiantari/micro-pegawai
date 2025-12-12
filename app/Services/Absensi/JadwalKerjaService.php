<?php

namespace App\Services\Absensi;

use App\Models\Absensi\JadwalKerja;
use Illuminate\Support\Collection;

final class JadwalKerjaService
{
    public function getListData(): Collection
    {
        return JadwalKerja::all();
    }

    public function create(array $data) : JadwalKerja
    {
        $data['jadwal_id'] = $this->generateId();
        return JadwalKerja::create($data);
    }

    public function getDetailData(string $id): ?JadwalKerja
    {
        return JadwalKerja::find($id);
    }

    public function findById(string $id): ?JadwalKerja
    {
        return JadwalKerja::find($id);
    }

    public function update(JadwalKerja $model, array $data): JadwalKerja
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return JadwalKerja::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = JadwalKerja::orderBy('jadwal_id', 'desc')->first();

        if (!$last) {
            return 'JDW-001';
        }
        $lastNumber = intval(substr($last->jadwal_id, 4));

        $newNumber = $lastNumber + 1;

        return 'JDW-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
