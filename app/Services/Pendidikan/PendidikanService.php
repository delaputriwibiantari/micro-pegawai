<?php

namespace App\Services\Pendidikan;

use App\Models\pendidikan\Pendidikan;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

class  PendidikanService{
    public function __construct(
        private FileUploadService $fileUploadService
    ){}

    public function getListData(): Collection
    {
        $query = Pendidikan::select([
            'id',
            'id_sdm',
            'institusi',
            'jurusan',
            'tahun_masuk',
            'tahun_lulus',
            'jenis_nilai',
            'sks',
            'sumber_biaya',
        ]);
        return $query->get();
    }

    public function create(array $data): Pendidikan
    {
        return Pendidikan::create($data);
    }

    public function getDetailData(string $id): ?Pendidikan
    {
        return Pendidikan::query()
        ->leftJoin('sdm', 'pendidikan.id_sdm', '=', 'sdm.id')
        ->select([
            'pendidikan.*',
            'sdm.id',
        ])
        ->where('pendidikan.id', $id)
        ->first();
    }

    public function findById(string $id): ?Pendidikan
    {
        return Pendidikan::find($id);
    }

     public function update(Pendidikan $pendidikan, array $data): Pendidikan
    {
        $pendidikan->update($data);

        return $pendidikan;
    }


    public function findPersonByNik(string $nik): ?object
    {
        return Pendidikan::query()
            ->leftJoin('sdm', 'pendidikan.id_sdm', '=', 'sdm.id')
            ->select([
                'pendidikan.*',
                'sdm.id',
            ])
            ->whereRaw('TRIM(sdm.id) = ?', [trim($nik)])
            ->whereNull('pendidikan.id') // belum terdaftar di SDM
            ->first();
    }

    public function formatPersonData(object $person): array
    {
        return [
            'id_sdm' => $person->id_sdm,
        ];
    }
}
