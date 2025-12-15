<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Izin;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class IzinService
{
    public function getListData(): Collection
    {
        // 1. Ambil izin dari koneksi att
        $izin = DB::connection('att')
            ->table('izin')
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
        $izin->transform(function ($row) use ($sdm) {
            $row->nama_lengkap = $sdm[$row->sdm_id]->nama_lengkap ?? null;
            return $row;
        });

        return $izin;
    }

    public function create(array $data): Izin
    {
        $data['izin_id'] = $this->generateId();
        $data['status'] = 'PENGAJUAN';

        return Izin::create($data);
    }

    public function getDetailData(string $id)
    {
        $izin = Izin::findOrFail($id);

        $sdm = DB::connection('mysql')
            ->table('sdm')
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select(
                'sdm.id',
                'person.nama_lengkap'
            )
            ->where('sdm.id', $izin->sdm_id)
            ->first();

        // field tambahan
        $izin->nama_lengkap = $sdm->nama_lengkap ?? '-';

        return $izin;
    }

    public function findById(string $id): ?Izin
    {
        return Izin::find($id);
    }

    public function update(Izin $model, array $data): Izin
    {
        $model->update($data);
        return $model;
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return Izin::orderBy($orderBy)->get();
    }

    private function generateId(): string
    {
        $last = Izin::orderBy('izin_id', 'desc')->first();

        if (!$last) {
            return 'IZ-001';
        }

        $lastNumber = intval(substr($last->izin_id, 4));
        $newNumber = $lastNumber + 1;

        return 'IZ-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
