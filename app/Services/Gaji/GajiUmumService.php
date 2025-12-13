<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiUmum;
use Illuminate\Support\Collection;

final class GajiUmumService
{
    public function getListData(): Collection
    {
        return GajiUmum::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return GajiUmum::orderBy($orderBy)->get();
    }

    public function create(array $data): GajiUmum
    {
         $data['umum_id'] = $this->generateId();
        return GajiUmum::create($data);
    }

    public function getDetailData(string $id): ?GajiUmum
    {
        return GajiUmum::query()->where('gaji_umum.id', $id)->first();
    }

    public function findById(string $id): ?GajiUmum
    {
        return GajiUmum::find($id);
    }

     public function update(GajiUmum $model, array $data): GajiUmum
    {
        $model->update($data);
        return $model;
    }

    private function generateId(): string
    {
        $last = GajiUmum::orderBy('umum_id', 'desc')->first();

        if (!$last) {
            return 'GMU-001';
        }
        $lastNumber = intval(substr($last->umum_id, 4));

        $newNumber = $lastNumber + 1;

        return 'GMU-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
