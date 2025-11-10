<?php

namespace App\Services\Ref;

use App\Models\Ref\RefJenisAsuransi;
use App\Models\Ref\RefJenisDokumen;
use Illuminate\Support\Collection;

final class RefJenisDokumenService
{
    public function getListData(): Collection
    {
        return RefJenisDokumen::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return RefJenisDokumen::orderBy($orderBy)->get();
    }

    public function create(array $data): RefJenisDokumen
    {
        return RefJenisDokumen::create($data);
    }

    public function getDetailData(string $id): ?RefJenisDokumen
    {
        return RefJenisDokumen::find($id);
    }

    public function findById(string $id): ?RefJenisDokumen
    {
        return RefJenisDokumen::find($id);
    }

    public function update(RefJenisDokumen $jenisdokumen, array $data): RefJenisDokumen
    {
        $jenisdokumen->update($data);

        return $jenisdokumen;
    }

    public function delete(RefJenisDokumen $jenisdokumen): void
    {
        $jenisdokumen->delete();
    }

}
