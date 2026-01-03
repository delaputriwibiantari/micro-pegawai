<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\GajiManualRequest;
use App\Services\Payroll\PayrollService;
use App\Services\Gaji\GajiManualService;
use App\Services\Gaji\PayrollManualProcessorService;
use App\Services\Sdm\SdmService;
use App\Models\Gaji\GajiPeriode;
use App\Models\sdm\Sdm;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class GajiManualController extends Controller
{
    public function __construct(
        private readonly GajiManualService $gajimanualservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
        private readonly SdmService $sdmService,
        private readonly PayrollManualProcessorService $payrollProcessor
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
                'action' => fn ($row) => implode(' ', [

                    $this->transactionService->actionLink(
                        route(
                            'admin.gaji.gaji_manual.detailgaji',
                            Crypt::encryptString($row->transaksi_id)
                        ),
                        'detail_gaji',
                        'Detail Gaji'
                    ),
                ]),
            ]
        );
    }


    /** ==============================
     *  PROSES PAYROLL
     *  ============================== */
    public function store(GajiManualRequest $request): JsonResponse
    {
        try {
            Log::info('Store GajiManual dipanggil', $request->all());

            return $this->transactionService->handleWithTransaction(function () use ($request) {
                $validated = $request->validated();

                Log::info('Validated data:', $validated);

                $result = $this->payrollProcessor->processSingleEmployee(
                    $validated['periode_id'],
                    $validated['sdm_id']
                );

                return $this->responseService->successResponse(
                    'Penggajian manual berhasil diproses.',
                    [
                        'transaksi_id' => $result->transaksi_id
                    ],
                    201
                );
            });
        } catch (\Exception $e) {
            Log::error('Error di store GajiManual:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
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
                $request->only([
                    'periode_id',
                    'sdm_id',
                ])
            );
            return $this->responseService
                ->successResponse('Data berhasil dibuat', $data, 201);
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
public function detailgaji(string $id): View
{
    try {
        // 🔥 kalau BUKAN UUID → berarti encrypted → decrypt
        if (!Str::isUuid($id)) {
            $id = Crypt::decryptString($id);
        }
    } catch (\Exception $e) {
        abort(403, 'Akses terlarang');
    }

    $trx = $this->gajimanualservice->getDetailTransaksi($id);

    if (!$trx) {
        abort(404, 'Transaksi tidak ditemukan');
    }

    $detail = $this->gajimanualservice->getDetailKomponen($id);

    if (!$trx->sdm_id) {
        abort(404, 'SDM tidak ditemukan pada transaksi ini');
    }

    $sdm = $this->sdmService->getDetailData($trx->sdm_id);

    if (!$sdm) {
        abort(404, 'Data SDM tidak ditemukan');
    }

    return view('admin.gaji.gaji_manual.detailgaji', [
        'person' => $sdm,
        'trx'    => $trx,
        'detail' => $detail,
        'id'     => $id,
    ]);
}

}
