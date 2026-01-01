<?php

namespace App\Services\Gaji;


use App\Models\Gaji\KomponenGaji;
use App\Models\Gaji\TarifPotongan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class TarifPotonganService
{
    public function getListData(): Collection
    {
        $data = TarifPotongan::query()
            ->leftJoin('komponen_gaji', 'tarif_potongan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->select([
                'tarif_potongan.*',
                'komponen_gaji.nama_komponen',
            ])
            ->get();

        return $data;
    }

    public function create(array $data): TarifPotongan
    {
        return DB::transaction(function () use ($data) {
            $data['potongan_id'] = $this->generateId();
            $tarif = TarifPotongan::create($data);

            // Otomatis update komponen terkait agar menggunakan tarif ini
            if ($tarif->komponen_id) {
                KomponenGaji::where('komponen_id', $tarif->komponen_id)->update([
                    'aturan_nominal' => 'tarif_potongan',
                    'referensi_id'   => $tarif->potongan_id
                ]);
            }

            return $tarif;
        });
    }

    public function getDetailData(string $id) : ?TarifPotongan
    {
        $data = TarifPotongan::query()
            ->leftJoin('komponen_gaji', 'tarif_potongan.komponen_id', '=', 'komponen_gaji.komponen_id')
            ->select([
                'tarif_potongan.*',
                'komponen_gaji.nama_komponen',
            ])
            ->where('tarif_potongan.id', $id)
            ->first();

        if (!$data) return null;

        return $data;
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

    public function getListDataOrdered(string $orderBy): Collection
    {
        return TarifPotongan::orderBy($orderBy)->get();
    }
}
