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

    public function create(array $data): GajiUmum
    {
        return GajiUmum::create($data);
    }

    public function getDetailData(string $id): ?GajiUmum
    {
        return GajiUmum::query()->where('master_unit.id_unit', $id)->first();
    }

    public function findById(string $id): ?GajiUmum
    {
        return GajiUmum::find($id);
    }

    public function update(GajiUmum $unit, array $data): GajiUmum
    {
        $unit->update($data);

        return $unit;
    }
}
