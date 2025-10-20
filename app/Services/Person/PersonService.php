<?php

namespace App\Services\Person;

use App\Models\Person\Person;
use App\Services\Tools\FileUploadService;
use Illuminate\Support\Collection;

class  PersonService{
    public function __construct(
        private FileUploadService $fileUploadService
    ){}
}
