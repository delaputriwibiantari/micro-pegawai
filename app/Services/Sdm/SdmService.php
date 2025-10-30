<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\sdm\Sdm;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

class  SdmService{
    public function __construct(
        private FileUploadService $fileUploadService
    ){}

    public function getListData(): Collection
    {
        $query = Sdm::query()
        ->leftJoin('person', 'sdm.id_person', '=', 'person.id')
        ->select([
            'sdm.id',
            'sdm.nip',
            'sdm.status_pegawai',
            'sdm.tipe_pegawai',
            'sdm.tanggal_masuk',
            'sdm.id_person',
            'person.nik',
            'person.nama_lengkap',
            'person.nama_panggilan',
            'person.tempat_lahir',
            'person.alamat',
        ]);


        $search = request('search.value');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                ->orwhere('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nama_panggilan', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%");

            });
        }
        return $query->get();
    }

    public function create(array $data): Sdm
    {
        return Sdm::create($data);
    }

    public function getDetailData(string $id): ?Sdm
    {
        return Sdm::query()
        ->leftJoin('person', 'sdm.id_person', '=', 'person.id')
        ->select([
            'sdm.*',
            'person.nama_lengkap',
            'person.tempat_lahir',
            'person.nik',
            'person.tanggal_lahir',
            'person.alamat',
        ])
        ->where('sdm.id', $id)
        ->first();
    }

    public function findById(string $id): ?Sdm
    {
        return Sdm::find($id);
    }

     public function update(Sdm $sdm, array $data): Sdm
    {
        $sdm->update($data);

        return $sdm;
    }


    public function findPersonByNik(string $nik): ?object
    {
        return Person::query()
            ->leftJoin('sdm', 'person.id', '=', 'sdm.id_person')
            ->select([
                'person.id as id_person',
                'person.nik',
                'person.nama_lengkap',
                'person.tempat_lahir',
                'person.tanggal_lahir',
                'person.alamat',
            ])
            ->whereRaw('TRIM(person.nik) = ?', [trim($nik)])
            ->whereNull('sdm.id') // belum terdaftar di SDM
            ->first();
    }

    public function formatPersonData(object $person): array
    {
        return [
            'id_person' => $person->id_person,
            'nik' => $person->nik ?? 'Tidak tersedia',
            'nama_lengkap' => $person->nama_lengkap ?? 'Tidak tersedia',
            'tempat_lahir' => $person->tempat_lahir ?? 'Tidak tersedia',
            'tanggal_lahir' => isset($person->tanggal_lahir)
                ? date('d-m-Y', strtotime($person->tanggal_lahir))
                : null,
            'alamat' => $person->alamat ?? 'Tidak tersedia',
        ];
    }


}
