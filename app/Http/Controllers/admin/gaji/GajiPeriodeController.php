<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\GajiPeriodeRequest;
use App\Services\Gaji\GajiPeriodeService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

final class GajiPeriodeController extends Controller
{
    public function __construct(
        private readonly GajiPeriodeService $gajiperiodeservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.gaji.gaji_umum.index');
    }

    public function list(Request $request):JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->gajiperiodeservice->getListData($request);
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]

        );
    }

    public function store(GajiPeriodeRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->gajiperiodeservice->create($request->only([
                'periode_id',
                'tahun',
                'tanggal_mulai',
                'tanggal_selesai',
                'status',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->gajiperiodeservice->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(GajiPeriodeRequest $request, string $id): JsonResponse
    {
        $data = $this->gajiperiodeservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->gajiperiodeservice->update($data, $request->only([
                'periode_id',
                'tahun',
                'tanggal_mulai',
                'tanggal_selesai',
                'status',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
