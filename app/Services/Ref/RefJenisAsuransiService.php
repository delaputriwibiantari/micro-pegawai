<?php

namespace App\Services\Ref;

use App\Models\Ref\RefJenisAsuransi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

final class RefJenisAsuransiService
{
    public function getListData(): Collection
    {
        return RefJenisAsuransi::all();
    }

    public function getListDataOrdered(string $orderBy = 'id'): Collection
    {
        if (!Schema::hasColumn('ref_jenis_asuransi', $orderBy)) {
        $orderBy = 'id';
        }

        return RefJenisAsuransi::orderBy($orderBy)->get();
    }

    public function create(array $data): RefJenisAsuransi
    {
        return RefJenisAsuransi::create($data);
    }

    public function getDetailData(string $id): ?RefJenisAsuransi
    {
        return RefJenisAsuransi::find($id);
    }

    public function findById(string $id): ?RefJenisAsuransi
    {
        return RefJenisAsuransi::find($id);
    }

    public function update(RefJenisAsuransi $jenisAsuransi, array $data): RefJenisAsuransi
    {
        $jenisAsuransi->update($data);

        return $jenisAsuransi;
    }

    public function delete(RefJenisAsuransi $jenisAsuransi): void
    {
        $jenisAsuransi->delete();
    }

}
