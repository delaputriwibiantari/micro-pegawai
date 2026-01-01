<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\sdm\Sdm;
use App\Services\Person\PersonService;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

class  SdmService{
    public function __construct(
        private FileUploadService $fileUploadService,
        private PersonService $personService,
    ){}

    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return $this->personService->getPersonDetailByUuid($uuid);
    }

    public function getHistoriByUuid(string $uuid): Collection
    {
        return Sdm::query()
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select([
                'sdm.id',
                'sdm.nip',
                'sdm.status_pegawai',
                'sdm.tipe_pegawai',
                'sdm.tanggal_masuk',
                'person.nama_lengkap',
                'person.uuid_person',
            ])
            ->where('person.uuid_person', $uuid)
            ->orderByDesc('sdm.tanggal_masuk')
            ->get();
    }

    public function getListData(): Collection
    {
        return Sdm::query()
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->select([
                'sdm.id',
                'sdm.nip',
                'sdm.status_pegawai',
                'sdm.tipe_pegawai',
                'sdm.tanggal_masuk',
                'person.nama_lengkap',
                'person.uuid_person',
            ])
            ->get();
    }

    public function create(array $data): Sdm
    {
        return Sdm::create($data);
    }

    public function getDetailData(string $id): ?Sdm
    {
        return Sdm::query()
            ->leftJoin('person', 'person.id', '=', 'sdm.id_person')
            ->leftJoin('ref_almt_desa', 'person.id_desa', '=', 'ref_almt_desa.id_desa')
            ->leftJoin('ref_almt_kecamatan', 'ref_almt_desa.id_kecamatan', '=', 'ref_almt_kecamatan.id_kecamatan')
            ->leftJoin('ref_almt_kabupaten', 'ref_almt_kecamatan.id_kabupaten', '=', 'ref_almt_kabupaten.id_kabupaten')
            ->leftJoin('ref_almt_provinsi', 'ref_almt_kabupaten.id_provinsi', '=', 'ref_almt_provinsi.id_provinsi')
            ->select([
                'sdm.*',
                'person.nama_lengkap',
                'person.tempat_lahir',
                'person.nik',
                'person.kk',
                'person.npwp',
                'person.tanggal_lahir',
                'person.alamat',
                'person.no_hp',
                'person.foto',
                'ref_almt_desa.desa',
                'ref_almt_kecamatan.kecamatan',
                'ref_almt_kabupaten.kabupaten',
                'ref_almt_provinsi.provinsi',
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

    public function checkDuplicate(int $idPerson): bool
    {
        return Sdm::where('id_person', $idPerson)
            ->exists();
    }


    public function findByNik(string $nik): ?Person
    {
        return $this->personService->findByNik($nik);
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->select('sdm.*', 'person.nama_lengkap')
            ->orderBy($orderBy)
            ->get();
    }

}
