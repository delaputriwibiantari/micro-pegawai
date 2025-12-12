<?php

namespace App\Services\Absensi;

use App\Models\Absensi\LiburNasional;
use Illuminate\Support\Collection;

final class LiburNasionalService
{
    public function getListData(): Collection
    {
        return LiburNasional::all();
    }

    public function create(array $data) : LiburNasional
    {
        $data['kalnas_id'] = $this->generateId();
        return LiburNasional::create($data);
    }

    public function getDetailData(string $id): ?LiburNasional
    {
        return LiburNasional::find($id);
    }

    public function findById(string $id): ?LiburNasional
    {
        return LiburNasional::find($id);
    }

    public function update(LiburNasional $model, array $data): LiburNasional
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return LiburNasional::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = LiburNasional::orderBy('kalnas_id', 'desc')->first();

        if (!$last) {
            return 'KAL-00001';
        }
        $lastNumber = intval(substr($last->kalnas_id, 4));

        $newNumber = $lastNumber + 1;

        return 'KAL-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
}
