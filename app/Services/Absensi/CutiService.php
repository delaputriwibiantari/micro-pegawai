<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Cuti;
use App\Models\sdm\Sdm;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class CutiService
{

    public function getListData(): Collection
    {
        // 1. Ambil cuti dari koneksi att
        $cuti = DB::connection('att')
            ->table('cuti')
            ->get();

        // 2. Ambil sdm + person dari mysql
        $sdm = DB::connection('mysql')
            ->table('sdm')
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select(
                'sdm.id',
                'person.nama_lengkap'
            )
            ->get()
            ->keyBy('id'); // key = sdm.id

        // 3. Mapping manual
        $cuti->transform(function ($row) use ($sdm) {
            $row->nama_lengkap = $sdm[$row->sdm_id]->nama_lengkap ?? null;
            return $row;
        });

        return $cuti;
    }


    public function create(array $data) : Cuti
    {
        $data['cuti_id'] = $this->generateId();
        $data['status'] = 'PENGAJUAN';
        return Cuti::create($data);
    }

    public function getDetailData(string $id)
    {
        $cuti = Cuti::findOrFail($id);

        $sdm = DB::connection('mysql')
            ->table('sdm')
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select(
                'sdm.id',
                'person.nama_lengkap'
            )
            ->where('sdm.id', $cuti->sdm_id)
            ->first();

        // GANTI isi sdm_id dengan nama_lengkap
        $cuti->sdm_id = $sdm->nama_lengkap ?? '-';

        return $cuti;
    }


    public function findById(string $id): ?Cuti
    {
        return Cuti::find($id);
    }

    public function update(Cuti $model, array $data): Cuti
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return Cuti::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = Cuti::orderBy('cuti_id', 'desc')->first();

        if (!$last) {
            return 'CT-001';
        }
        $lastNumber = intval(substr($last->cuti_id, 4));

        $newNumber = $lastNumber + 1;

        return 'CT-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
