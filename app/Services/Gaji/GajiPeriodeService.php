<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiPeriode;
use Illuminate\Support\Collection;

final class GajiPeriodeService {

    public function getListData(): Collection
    {
        return GajiPeriode::all();
    }

    public function create(array $data) : GajiPeriode
    {
        $data['periode_id'] = $this->generateId();
        return GajiPeriode::create($data);
    }

    public function getDetailData(string $id): ?GajiPeriode
    {
        return GajiPeriode::find($id);
    }

    public function findById(string $id): ?GajiPeriode
    {
        return GajiPeriode::find($id);
    }

    public function update(string $id, array $data): ?GajiPeriode
    {
        $model = GajiPeriode::find($id);

        if (!$model) {
            return null;
        }

        $model->update($data);
        return $model;
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return GajiPeriode::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $now = now();
        $bulanTahun = $now->format('mY'); // 012024

        $id = 'PER-' . $bulanTahun;

        $exists = GajiPeriode::where('periode_id', $id)->exists();

        if ($exists) {
            throw new \Exception('Periode gaji sudah ada');
        }

        return $id;
    }


}
