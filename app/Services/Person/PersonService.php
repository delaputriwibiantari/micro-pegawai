<?php

namespace App\Services\Person;

use App\Models\Person\Person;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

class  PersonService{
    public function __construct(
        private FileUploadService $fileUploadService
    ){}

    public function getListData(): Collection
    {
        $query = Person::select([
            'id',
            'nama_lengkap',
            'nama_panggilan',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'kewarganegaraan',
            'email',
            'no_hp',
            'foto',
            'jk',
            'nik',
            'kk',
            'npwp',
            'alamat',
            'id_desa'
        ]);

        $search = request('search.value');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nama_panggilan', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }
        return $query->get();
    }

    public function create(array $data): Person
    {
        return Person::create($data);
    }

    public function getDetailData(string $id): ?Person
    {
        return Person::query()
            ->leftJoin('ref_almt_desa', 'person.id_desa', '=', 'ref_almt_desa.id_desa')
            ->leftJoin('ref_almt_kecamatan', 'ref_almt_desa.id_kecamatan', '=', 'ref_almt_kecamatan.id_kecamatan')
            ->leftJoin('ref_almt_kabupaten', 'ref_almt_kecamatan.id_kabupaten', '=', 'ref_almt_kabupaten.id_kabupaten')
            ->leftJoin('ref_almt_provinsi', 'ref_almt_kabupaten.id_provinsi', '=', 'ref_almt_provinsi.id_provinsi')
            ->select([
                'person.*',
                'ref_almt_desa.desa',
                'ref_almt_kecamatan.kecamatan',
                'ref_almt_kabupaten.kabupaten',
                'ref_almt_provinsi.provinsi',
            ])
            ->where('person.id', $id)
            ->first();
    }

    public function findById(string $id): ?Person
    {
        return Person::find($id);
    }

     public function update(Person $person, array $data): Person
    {
        $person->update($data);

        return $person;
    }

    public function handleFileUpload($foto, ?Person $person = null): ?array
    {
        if (!$foto) {
            return null;
        }

        if ($person && $person->foto) {
            return $this->fileUploadService->updateFileByType($foto, $person->foto, 'person_foto');
        }

        return $this->fileUploadService->uploadByType($foto, 'person_foto');
    }

    public function findByNik(string $nik): ?Person
    {
        return Person::query()
            ->leftJoin('ref_almt_desa', 'person.id_desa', '=', 'ref_almt_desa.id_desa')
            ->leftJoin('ref_almt_kecamatan', 'ref_almt_desa.id_kecamatan', '=', 'ref_almt_kecamatan.id_kecamatan')
            ->leftJoin('ref_almt_kabupaten', 'ref_almt_kecamatan.id_kabupaten', '=', 'ref_almt_kabupaten.id_kabupaten')
            ->leftJoin('ref_almt_provinsi', 'ref_almt_kabupaten.id_provinsi', '=', 'ref_almt_provinsi.id_provinsi')
            ->select([
                'person.id',
                'person.nik',
                'person.nama_lengkap',
                'person.tempat_lahir',
                'person.tanggal_lahir',
                'ref_almt_desa.desa',
                'ref_almt_kecamatan.kecamatan',
                'ref_almt_kabupaten.kabupaten',
                'ref_almt_provinsi.provinsi',
            ])
            ->where('person.nik', $nik)
            ->orderBy('person.nama_lengkap')
            ->first();
    }

    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return Person::query()
            ->leftJoin('ref_almt_desa', 'person.id_desa', '=', 'ref_almt_desa.id_desa')
            ->leftJoin('ref_almt_kecamatan', 'ref_almt_desa.id_kecamatan', '=', 'ref_almt_kecamatan.id_kecamatan')
            ->leftJoin('ref_almt_kabupaten', 'ref_almt_kecamatan.id_kabupaten', '=', 'ref_almt_kabupaten.id_kabupaten')
            ->leftJoin('ref_almt_provinsi', 'ref_almt_kabupaten.id_provinsi', '=', 'ref_almt_provinsi.id_provinsi')
            ->select([
                'person.id_person', 'person.uuid_person', 'person.nama_lengkap', 'person.jk',
                'person.tempat_lahir', 'person.tanggal_lahir', 'person.nik', 'person.nomor_kk',
                'person.npwp', 'person.nomor_hp', 'person.foto', 'person.alamat',
                'ref_almt_desa.desa', 'ref_almt_kecamatan.kecamatan',
                'ref_almt_kabupaten.kabupaten', 'ref_almt_provinsi.provinsi',
            ])
            ->where('person.uuid_person', $uuid)
            ->first();
    }
}
