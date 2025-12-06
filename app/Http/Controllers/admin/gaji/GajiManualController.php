<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\GajiManualRequest;
use App\Services\Payroll\PayrollService;
use App\Services\Gaji\GajiManualService;
use App\Services\Sdm\SdmService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class GajiManualController extends Controller
{
    public function __construct(
        private readonly GajiManualService $gajimanualservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
        private readonly SdmService $sdmService
    ) {}

    public function index(): View
    {
        return view('admin.gaji.gaji_manual.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn () => $this->gajimanualservice->getListData($request),
            [
                'action' => fn ($row) =>
                    implode(' ', [
                        $this->transactionService->actionButton($row->transaksi_id, 'detail'),
                        $this->transactionService->actionButton($row->transaksi_id, 'delete'),
                    ]),
            ]
        );
    }

    /** ==============================
     *  PROSES PAYROLL
     *  ============================== */
    public function store(GajiManualRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {

            $data = $this->gajimanualservice->prosesPayroll(
                $request->only([
                    'periode_id',
                    'sdm_id',
                    'gaji_master_id',
                    'manual'   // komponen input manual opsional
                ])
            );

            return $this->responseService->successResponse(
                'Transaksi payroll berhasil diproses.',
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

    /** ==============================
     *  DETAIL KOMPONEN
     *  ============================== */
    public function storeDetail(GajiManualRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {

            $data = $this->gajimanualservice->createDetail(
                $request->only(['transaksi_id', 'komponen_id', 'nominal', 'keterangan'])
            );

            return $this->responseService->successResponse('Detail berhasil ditambahkan', $data, 201);
        });
    }

    public function updateDetail(GajiManualRequest $request, string $detailId): JsonResponse
    {
        $detail = $this->gajimanualservice->findDetailById($detailId);

        if (!$detail) {
            return $this->responseService->errorResponse('Detail tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $detail) {

            $updated = $this->gajimanualservice->updateDetail(
                $detail,
                $request->only(['komponen_id', 'nominal', 'keterangan'])
            );

            return $this->responseService->successResponse('Detail berhasil diperbarui', $updated);
        });
    }

    /** ==============================
     *  HISTORI GAJI SDM
     *  ============================== */
    public function detailgaji(string $uuid): View
    {
        return view('admin.gaji.detailgaji', [
            'person' => $this->sdmService->getPersonDetailByUuid($uuid),
            'data'   => $this->sdmService->getHistoriByUuid($uuid),
            'id'     => $uuid,
        ]);
    }
}
