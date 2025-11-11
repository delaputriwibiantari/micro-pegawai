<?php

namespace App\Services\Sdm;

use App\Models\pendidikan\Pendidikan;
use App\Models\Person\Person;
use App\Models\sdm\Sdm;
use App\Models\sdm\SdmPendidikan;
use App\Services\Person\PersonService;
use App\Services\Tools\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class  SdmPendidikanService{
    public function __construct(
        private FileUploadService $fileUploadService,
        private PersonService     $personService,
    ){}

    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return $this->personService->getPersonDetailByUuid($uuid);
    }

    public function getListData(string $uuid,  Request $request): Collection
    {
        $idSdm = Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('sdm.id');

        if (!$idSdm) {
            return collect();
        }

        return SdmPendidikan::query()
            ->leftJoin('sdm', 'sdm.id', '=', 'pendidikan.id_sdm')
            ->leftJoin('ref_jenjang_pendidikan', 'ref_jenjang_pendidikan.id_jenjang_pendidikan', '=', 'pendidikan.id_jenjang_pendidikan')
            ->select([
                'pendidikan.*',
                'ref_jenjang_pendidikan.jenjang_pendidikan',
            ])
            ->where('pendidikan.id_sdm', $idSdm)
            ->when($request->query('id_jenjang_pendidikan'), fn($q, $v) => $q->where('pendidikan.id_jenjang_pendidikan', $v))
            ->orderByDesc('pendidikan.tahun_lulus')
            ->orderBy('pendidikan.institusi')
            ->get();
    }

    public function create(array $data): SdmPendidikan
    {
        return SdmPendidikan::create($data);
    }

    public function getDetailData(string $id): ?SdmPendidikan
    {
        return SdmPendidikan::query()
            ->leftJoin('ref_jenjang_pendidikan', 'ref_jenjang_pendidikan.id_jenjang_pendidikan', '=', 'pendidikan.id_jenjang_pendidikan')
            ->select([
                'pendidikan.*',
                'ref_jenjang_pendidikan.jenjang_pendidikan',
            ])
            ->where('pendidikan.id', $id)
            ->first();
    }

    public function findById(string $id): ?SdmPendidikan
    {
        return SdmPendidikan::find($id);
    }

    public function update(SdmPendidikan $Pendidikan, array $data): SdmPendidikan
    {
        $Pendidikan->update($data);

        return $Pendidikan;
    }

    public function delete(SdmPendidikan $riwayatPendidikan): void
    {
        if ($riwayatPendidikan->file_ijazah) {
            $this->fileUploadService->deleteFileByType($riwayatPendidikan->file_ijazah, 'ijazah');
        }

        if ($riwayatPendidikan->file_transkip) {
            $this->fileUploadService->deleteFileByType($riwayatPendidikan->file_ijazah, 'transkip');
        }

        $riwayatPendidikan->delete();
    }



    public function resolveIdSdmFromUuid(string $uuid): ?int
    {
        return Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('sdm.id');
    }

    public function handleFileUpload($file, int $idSdm, string $dokumen): ?array
    {
        if (!$file) {
            return null;
        }

        $personSdm = Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->select([
                'person.uuid_person',
                'person.nama_lengkap',
            ])
            ->where('sdm.id', $idSdm)
            ->first();

        $uniqueCode = substr(md5(uniqid()), 0, 6);
        $template = '{id_sdm}_{nama_lengkap}_{dokumen}_{unique_code}';

        $data = [
            'id_sdm' => $personSdm->uuid_person ?? 'unknown',
            'nama_lengkap' => $personSdm->nama_lengkap ?? 'unknown',
            'dokumen' => $dokumen,
            'unique_code' => $uniqueCode,
        ];

        return $this->fileUploadService->uploadWithTemplate($file, 'pendidikan', $template, $data);
    }

    public function updateFileUpload($file, ?string $oldFileName, int $idSdm, string $dokumen): ?array
    {
        if (!$file) {
            return null;
        }

        $personSdm = Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->select([
                'person.uuid_person',
                'person.nama_lengkap',
            ])
            ->where('sdm.id', $idSdm)
            ->first();

        $uniqueCode = substr(md5(uniqid()), 0, 6);
        $template = '{id_sdm}_{nama_lengkap}_{dokumen}_{unique_code}';

        $data = [
            'id_sdm' => $personSdm->uuid_person ?? 'unknown',
            'nama_lengkap' => $personSdm->nama_lengkap ?? 'unknown',
            'dokumen' => $dokumen,
            'unique_code' => $uniqueCode,
        ];

        // Handle null oldFileName - berikan default value string kosong
        $oldFileName = $oldFileName ?? '';

        return $this->fileUploadService->updateWithTemplate($file, $oldFileName, 'pendidikan', $template, $data);
    }
}
