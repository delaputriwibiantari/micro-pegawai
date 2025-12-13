<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\GajiUmumRequest;
use App\Services\Gaji\GajiUmumService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class GajiUmumController extends Controller
{
    public function __construct(
        private readonly GajiUmumService  $gajiumumservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.gaji.gaji_umum.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->gajiumumservice->getListData($request);
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

    public function store(GajiUmumRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->gajiumumservice->create($request->only([
                'umum_id',
                'nominal',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->gajiumumservice->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

   public function update(GajiUmumRequest $request, string $id): JsonResponse
    {
        $data = $this->gajiumumservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->gajiumumservice->update($data, $request->only([
                'umum_id',
                'nominal',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
