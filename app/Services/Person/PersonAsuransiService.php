<?php

namespace App\Services\Person;

use App\Models\Person\Person;
use App\Models\Person\PersonAsuransi;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final readonly class PersonAsuransiService
{
    public function __construct(
        private PersonService $personService,
    )
    {
    }

    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return $this->personService->getPersonDetailByUuid($uuid);
    }

    public function getListData(string $uuid, Request $request): Collection
    {
        $nomorKK = Person::where('uuid_person', $uuid)->value('kk');

        if (!$nomorKK) {
            return collect();
        }

        return PersonAsuransi::query()
            ->leftJoin('person', 'person.id', '=', 'asuransi_karyawan.id_person')
            ->leftJoin('ref_jenis_asuransi', 'ref_jenis_asuransi.id_jenis_asuransi', '=', 'asuransi_karyawan.id_jenis_asuransi')
            ->select([
                'asuransi_karyawan.id',
                'asuransi_karyawan.id_jenis_asuransi',
                'ref_jenis_asuransi.id_jenis_asuransi',
                'ref_jenis_asuransi.nama_asuransi as jenis_asuransi',
                'asuransi_karyawan.nomer_peserta',
                'asuransi_karyawan.kartu_anggota',
                'asuransi_karyawan.status',
                'asuransi_karyawan.tanggal_mulai',
                'asuransi_karyawan.tanggal_berakhir',
                'person.id as person_id',
                'person.nama_lengkap',
                'person.nik',
                'person.uuid_person',
            ])
            ->where(function ($q) use ($nomorKK, $uuid) {
                $q->where('asuransi_karyawan.kartu_anggota', $nomorKK)
                    ->orWhere('person.uuid_person', $uuid);
            })
            ->when($request->query('id'), fn($q, $v) => $q->where('asuransi_karyawan.id_jenis_asuransi', $v))
            ->when($request->query('status'), fn($q, $v) => $q->where('asuransi_karyawan.status', $v))
            ->orderBy('person.nama_lengkap')
            ->get();
    }

    public function create(array $data): PersonAsuransi
    {
        return PersonAsuransi::create($data);
    }

    public function getDetailData(string $id): ?PersonAsuransi
    {
        return PersonAsuransi::query()
            ->leftJoin('person', 'person.id', '=', 'asuransi_karyawan.id_person')
            ->leftJoin('ref_jenis_asuransi', 'ref_jenis_asuransi.id_jenis_asuransi', '=', 'asuransi_karyawan.id_jenis_asuransi')
            ->select([
                'asuransi_karyawan.*',
                'person.nama_lengkap', 'person.nik', 'person.uuid_person',
                'ref_jenis_asuransi.id_jenis_asuransi', 'ref_jenis_asuransi.nama_asuransi',
            ])
            ->where('asuransi_karyawan.id', $id)
            ->first();
    }

    public function findById(string $id): ?PersonAsuransi
    {
        return PersonAsuransi::find($id);
    }

    public function update(PersonAsuransi $personAsuransi, array $data): PersonAsuransi
    {
        $personAsuransi->update($data);

        return $personAsuransi;
    }

    public function delete(PersonAsuransi $personAsuransi): bool
    {
        return $personAsuransi->delete();
    }

    public function resolvePersonId(?int $idPerson = null, ?string $uuid_person = null): ?int
    {
        if ($idPerson) {
            return $idPerson;
        }

        if ($uuid_person) {
            return Person::where('uuid_person', $uuid_person)->value('id');
        }
        return null;
    }

    public function checkActivePolisExists(int $idPerson, int $idJenisAsuransi): bool
    {
        return PersonAsuransi::where('id_person', $idPerson)
            ->where('id_jenis_asuransi', $idJenisAsuransi)
            ->where('status', 'AKTIF')
            ->exists();
    }

    public function checkActivePolisExistsForUpdate(PersonAsuransi $personAsuransi, int $idJenisAsuransi): bool
    {
        return PersonAsuransi::where('id_person', $personAsuransi->id_person)
            ->where('id_jenis_asuransi', $idJenisAsuransi)
            ->where('status', 'AKTIF')
            ->where('id', '!=', $personAsuransi->id)
            ->exists();
    }

    public function findByNik(string $nik): ?Person
    {
        return $this->personService->findByNik($nik);
    }
}
