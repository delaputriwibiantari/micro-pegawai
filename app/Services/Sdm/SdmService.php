<?php

namespace App\Services\Sdm;


use App\Models\sdm\Sdm;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

class  SdmService{
    public function __construct(
        private FileUploadService $fileUploadService
    ){}

    public function getListData(): Collection
    {
        $query = Sdm::select([
            'id',
            'nip',
            'status_pegawai',
            'tipe_pegawai',
            'tanggal_masuk',
            'id_person'
        ]);

        $search = request('search.value');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                ->orwhere('nama_lengkap', 'like', "%{$search}%")
                ->orWhere('nama_panggilan', 'like', "%{$search}%")
                ->orWhere('tempat_lahir', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('no_hp', 'like', "%{$search}%");
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


    public function findByNik(string $nik): ?Sdm
    {
        return Sdm::query()
            ->leftJoin('person', 'sdm.id_person', '=', 'person.id')
            ->select([
                'sdm.id',
                'person.nik', // Ambil dari person, bukan sdm
                'person.nama_lengkap',
                'person.tempat_lahir',
                'person.tanggal_lahir',
            ])
            ->where('person.nik', $nik) // Cari di person.nik
            ->orderBy('person.nama_lengkap')
            ->first();
    }

    public function formatPersonData(Sdm $sdm): array
    {
        return [
            'id' => $sdm->id,
            'id_person' => $sdm->id_person,
            'nik' => $sdm->nik,
            'nama_lengkap' => $sdm->nama_lengkap,
            'tempat_lahir' => $sdm->tempat_lahir,
            'tanggal_lahir' => $sdm->tanggal_lahir ? $sdm->tanggal_lahir->format('d-m-Y') : null,
            'alamat' => $sdm->alamat ?? 'Tidak tersedia',
            'jenis_kelamin' => $sdm->jenis_kelamin ?? 'Tidak tersedia'
        ];
    }

}
