<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Lembur;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class LemburService
{

    public function getListData(): Collection
    {
        // 1. Ambil data lembur menggunakan Eloquent
        $lembur = Lembur::all();

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
        $lembur->transform(function ($row) use ($sdm) {
            $row->nama_lengkap = $sdm[$row->sdm_id]->nama_lengkap ?? null;
            return $row;
        });

        return $lembur;
    }


    public function create(array $data) : Lembur
    {
        $data['lembur_id'] = $this->generateId();
        $data['status'] = 'PENGAJUAN';
        return Lembur::create($data);
    }

    public function getDetailData(string $id)
    {
        if ($id === 'undefined' || empty($id)) {
            return null;
        }

        $lembur = Lembur::find($id);
        if (!$lembur) {
            return null;
        }

        $sdm = DB::connection('mysql')
            ->table('sdm')
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select(
                'sdm.id',
                'person.nama_lengkap'
            )
            ->where('sdm.id', $lembur->sdm_id)
            ->first();

        $lembur->nama_lengkap = $sdm->nama_lengkap ?? '-';

        return $lembur;
    }



    public function findById(string $id): ?Lembur
    {
        if ($id === 'undefined' || empty($id)) {
            return null;
        }
        return Lembur::find($id);
    }

    public function update(Lembur $model, array $data): Lembur
    {
        $model->update($data);
        return $model;
    }


    public function getListDataOrdered(string $orderBy): Collection
    {
        return Lembur::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = Lembur::orderBy('lembur_id', 'desc')->first();

        if (!$last) {
            return 'LMB-001';
        }
        $lastNumber = intval(substr($last->lembur_id, 4));

        $newNumber = $lastNumber + 1;

        return 'LMB-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
