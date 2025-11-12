<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\sdm\Sdm;
use App\Models\sdm\SdmRekening;
use App\Services\Person\PersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

final readonly class SdmRekeningService
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
        $idSdm = Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('sdm.id');

        if (!$idSdm) {
            return collect();
        }

        return SdmRekening::query()
            ->join('bank', 'bank.id_bank', '=', 'sdm_rekening.id_bank')
            ->select([
                'sdm_rekening.id_rekening',
                'sdm_rekening.id_sdm',
                'sdm_rekening.id_bank',
                'bank.nama_bank as bank', // ambil nama bank dari tabel ref_bank
                'sdm_rekening.no_rekening',
                'sdm_rekening.nama_pemilik',
                'sdm_rekening.kode_bank',
                'sdm_rekening.cabang_bank',
                'sdm_rekening.jenis_rekening',
                'sdm_rekening.status_aktif',
                'sdm_rekening.rekening_utama',
            ])
            ->where('sdm_rekening.id_sdm', $idSdm)
            ->when(
                $request->query('status_aktif'),
                fn($q, $status) => $q->where('sdm_rekening.status_aktif', $status)
            )
            ->when(
                $request->query('jenis_rekening'),
                fn($q, $jenis) => $q->where('sdm_rekening.jenis_rekening', $jenis)
            )
            ->when(
                $request->query('rekening_utama'),
                fn($q, $utama) => $q->where('sdm_rekening.rekening_utama', $utama)
            )
            ->orderByDesc('sdm_rekening.rekening_utama')
            ->orderBy('bank.nama_bank') // urutkan berdasarkan nama bank
            ->orderBy('sdm_rekening.no_rekening')
            ->get();
    }


    public function create(array $data): SdmRekening
    {
        return SdmRekening::create($data);
    }

    public function getDetailData(string $id): ?SdmRekening
    {
        return SdmRekening::query()
            ->join('bank', 'bank.id_bank', '=', 'sdm_rekening.id_bank')
            ->select([
                'sdm_rekening.*',
                'bank.nama_bank as bank'
            ])
            ->where('sdm_rekening.id_rekening', $id)
            ->first();
    }


    public function findById(string $id): ?SdmRekening
    {
        return SdmRekening::find($id);
    }

    public function delete(SdmRekening $rekening): void
    {
        $rekening->delete();
    }

    public function resolveIdSdmFromUuid(string $uuid): ?int
    {
        return Sdm::query()
            ->join('person', 'person.id', '=', 'sdm.id_person')
            ->where('person.uuid_person', $uuid)
            ->value('sdm.id');
    }

    public function checkDuplicate(int $idSdm, string $noRekening): bool
    {
        return SdmRekening::where('id_sdm', $idSdm)
            ->where('no_rekening', $noRekening)
            ->exists();
    }

    public function checkDuplicateForUpdate(SdmRekening $rekening, string $noRekening): bool
    {
        return SdmRekening::where('id_sdm', $rekening->id_sdm)
            ->where('no_rekening', $noRekening)
            ->where('id_rekening', '!=', $rekening->id_rekening)
            ->exists();
    }

    public function unsetOtherMainAccounts(int $idSdm, ?int $excludeId = null): void
    {
        $query = SdmRekening::where('id_sdm', $idSdm);

        if ($excludeId) {
            $query->where('id_rekening', '!=', $excludeId);
        }

        $query->update(['rekening_utama' => 'n']);
    }

    public function update(SdmRekening $rekening, array $data): SdmRekening
    {
        $rekening->update($data);

        return $rekening;
    }
}
