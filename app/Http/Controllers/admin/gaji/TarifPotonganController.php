<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\absensi\JadwalKerjaRequest;
use App\Http\Requests\gaji\TarifPotonganRequest;
use App\Models\Gaji\TarifPotongan;
use App\Services\Gaji\TarifPotonganService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

final class TarifPotonganController extends Controller
{
    public function __construct(
        private readonly TarifPotonganService $tarifpotonganservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.gaji.tarif_potongan.index');
    }

    public function list(Request $request):JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->tarifpotonganservice->getListData($request);
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

    public function store(TarifPotonganRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->tarifpotonganservice->create($request->only([
                'potongan_id',
                'nama_potongan',
                'tarif_per_kejadian',
                'deskripsi',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->tarifpotonganservice->getDetailData($id);
            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

     public function update(TarifPotonganRequest $request, string $id): JsonResponse
    {
        $data = $this->tarifpotonganservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->tarifpotonganservice->update($data, $request->only([
                'potongan_id',
                'nama_potongan',
                'tarif_per_kejadian',
                'deskripsi',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
