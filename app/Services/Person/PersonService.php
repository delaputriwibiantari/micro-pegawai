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
        return Person::select([
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
            'nik',
            'kk',
            'npwp',
            'alamat',
            'id_desa'
        ])->orderBy('nama')->get();
    }
}
