<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\TarifLemburRequest;
use App\Services\Gaji\TarifLemburService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TarifLemburController extends Controller
{
    public function __construct(
        private readonly TarifLemburService $tariflemburservice,
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
                return $this->tariflemburservice->getListData($request);
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

    public function store(TarifLemburRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->tariflemburservice->create($request->only([
                'tarif_id',
                'jenis_lembur',
                'tarif-per_jam',
                'berlaku_sampai'

            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->tariflemburservice->getDetailData($id);
            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(TarifLemburRequest $request, string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request, $id) {
            $data = $this->tariflemburservice->update($id, $request->only([
                'tarif_id',
                'jenis_lembur',
                'tarif-per_jam',
                'berlaku_sampai'
            ]));
            return $this->responseService->successResponse('Data berhasil diupdate', $data);
        });
    }


}
