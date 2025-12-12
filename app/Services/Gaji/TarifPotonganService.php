<?php

namespace App\Services\Gaji;


use App\Models\Gaji\TarifPotongan;
use Illuminate\Support\Collection;

final class TarifPotonganService
{
    public function getListData(): Collection
    {
        return TarifPotongan::all();
    }

    public function create(array $data) : TarifPotongan
    {
        $data['potongan_id'] = $this->generateId();
        return TarifPotongan::create($data);
    }

    public function getDetailData(string $id) : ?TarifPotongan
    {
        return TarifPotongan::find($id);
    }

    public function findById(string $id) : ?TarifPotongan
    {
        return TarifPotongan::find($id);
    }

    public function update(TarifPotongan $model, array $data): TarifPotongan
    {
        $model->update($data);
        return $model;
    }

    private function generateId(): string
    {
        $last = TarifPotongan::orderBy('potongan_id', 'desc')->first();

        if (!$last) {
            return 'POT-001';
        }
        $lastNumber = intval(substr($last->potongan_id, 4));

        $newNumber = $lastNumber + 1;

        return 'POT-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
