<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\GajiManualRequest;
use App\Services\Gaji\GajiManualService;
use App\Services\Payroll\GajiManualService as PayrollGajiManualService;
use App\Services\Sdm\SdmService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class GajiManualController extends Controller
{
    public function __construct(
        private readonly GajiManualService     $gajimanualservice,
        private readonly TransactionService  $transactionService,
        private readonly ResponseService     $responseService,
        private readonly SdmService $sdmService
    )
    {
    }

    public function index(): View
    {
        return view('admin.gaji.gaji_manual.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->gajimanualservice->getListData($request);
            },
            [
                'action' => function ($row) {
                    $rowId = $row->transaksi_id;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'delete'),
                    ]);
                },
            ]
        );
    }

    public function store(GajiManualRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {

            $data = $this->gajimanualservice->create(
                $request->only(['periode_id', 'sdm_id'])
            );

            return $this->responseService->successResponse(
                'Transaksi payroll berhasil dibuat',
                $data,
                201
            );
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {

            $trx = $this->gajimanualservice->getDetailTransaksi($id);
            $detail = $this->gajimanualservice->getDetailKomponen($id);

            return $this->responseService->successResponse('Data berhasil diambil', [
                'transaksi' => $trx,
                'detail' => $detail,
            ]);
        });
    }

    public function update(GajiManualRequest $request, string $id): JsonResponse
    {
        $trx = $this->gajimanualservice->findTrxById($id);

        if (!$trx) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $trx) {

            $updated = $this->gajimanualservice->update(
                $trx,
                $request->only(['periode_id', 'sdm_id'])
            );

            return $this->responseService->successResponse('Data berhasil diperbarui', $updated);
        });
    }

    public function storeDetail(GajiManualRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {

            $data = $this->gajimanualservice->createDetail(
                $request->only(['transaksi_id', 'komponen_id', 'nominal', 'keterangan'])
            );

            return $this->responseService->successResponse('Detail berhasil dibuat', $data, 201);
        });
    }

    public function updateDetail(GajiManualRequest $request, string $detailId): JsonResponse
    {
        $detail = $this->gajimanualservice->findDetailById($detailId);

        if (!$detail) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $detail) {

            $updated = $this->gajimanualservice->updateDetail(
                $detail,
                $request->only(['komponen_id', 'nominal', 'keterangan'])
            );

            return $this->responseService->successResponse('Detail berhasil diperbarui', $updated);
        });
    }
    public function detailgaji(string $uuid): View
    {
        $person = $this->sdmService->getPersonDetailByUuid($uuid);
        $data = $this->sdmService->getHistoriByUuid($uuid);

        return view('admin.gaji.detailgaji', [
            'person' => $person,
            'data' => $data,
            'id' => $uuid,
        ]);
    }

}
