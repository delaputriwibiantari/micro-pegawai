<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gaji\GajiPeriode;
use App\Services\Gaji\GajiJabatanService;
use App\Services\Gaji\GajiPeriodeService;
use App\Services\Gaji\GajiUmumService;
use App\Services\Gaji\KomponenGajiService;
use App\Services\Ref\RefJenisDokumenService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class RefGajiController extends Controller
{
    public function __construct(
        private readonly GajiUmumService             $gajiumumservice,
        private readonly TransactionService          $transactionService,
        private readonly ResponseService             $responseService,
        private readonly KomponenGajiService          $komponengajiservice,
        private readonly GajiPeriodeService          $gajiperiodeservice

    ) {}

    public function gajiumum(): JsonResponse
    {
        $data = $this->gajiumumservice->getListDataOrdered('umum_id');

        return $this->responseService->successResponse('Data berhasil diambil', $data);
    }


    public function komponengaji(): JsonResponse
    {
        $data = $this->komponengajiservice->getListDataOrdered('komponen_id');

        return $this->responseService->successResponse('Data berhasil diambil', $data);
    }

    public function Gajiperiode(): JsonResponse
    {
        $data = $this->gajiperiodeservice->getListDataOrdered('periode_id');

        return $this->responseService->successResponse('Data berhasil diambil', $data);
    }
}
