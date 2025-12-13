<?php

namespace App\Services\Gaji;

use App\Models\Gaji\TarifLembur;
use Illuminate\Support\Collection;

final class TarifLemburService
{
    public function getListData(): Collection
    {
        return TarifLembur::all();
    }

    public function create(array $data) : TarifLembur
    {
        $data['tarif_id'] = $this->generateId();
        return TarifLembur::create($data);
    }

    public function getDetailData(string $id) : ?TarifLembur
    {
        return TarifLembur::find($id);
    }

    public function findById(string $id) : ?TarifLembur
    {
        return TarifLembur::find($id);
    }

   public function update(TarifLembur $model, array $data): TarifLembur
    {
        $model->update($data);
        return $model;
    }

    private function generateId(): string
    {
        $last = TarifLembur::orderBy('tarif_id', 'desc')->first();

        if (!$last) {
            return 'TLE-001';
        }
        $lastNumber = intval(substr($last->tarif_id, 4));

        $newNumber = $lastNumber + 1;

        return 'TLE-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
