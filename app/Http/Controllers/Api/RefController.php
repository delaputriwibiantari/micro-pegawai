<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Ref\RefEselonService;
use App\Services\Ref\RefHubunganKeluargaService;
use App\Services\Ref\RefJenisAsuransiService;
use App\Services\Ref\RefJenjangPendidikanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;

final class RefController extends Controller
{
    public function __construct(
        private readonly RefJenjangPendidikanService $refJenjangPendidikanService,
        private readonly TransactionService          $transactionService,
        private readonly ResponseService             $responseService,
        private readonly RefHubunganKeluargaService  $refHubunganKeluargaService,
    ) {}

        public function jenjangPendidikan(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refJenjangPendidikanService->getListDataOrdered('id_jenjang_pendidikan');

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function hubunganKeluarga(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->refHubunganKeluargaService->getListDataOrdered('id_hubungan_keluarga');

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
