<?php

namespace App\Http\Controllers\admin\gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\gaji\KomponenGajiRequest;
use App\Services\Gaji\KomponenGajiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class KomponenGajiController extends Controller
{
    public function __construct(
        private readonly KomponenGajiService  $Komponengajiservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.gaji.komponen_gaji.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->Komponengajiservice->getListData($request);
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

    public function store(KomponenGajiRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->Komponengajiservice->create($request->only([
                'komponen_id',
                'nama_komponen',
                'jenis',
                'deskripsi',
                'is_umum',
                'aturan_nominal', // ← TAMBAH
                'referensi_id',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->Komponengajiservice->getDetailData($id);

            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan', 404);
            }

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(KomponenGajiRequest $request, string $id): JsonResponse
    {
        $data = $this->Komponengajiservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->Komponengajiservice->update($data, $request->only([
                'komponen_id',
                'nama_komponen',
                'jenis',
                'deskripsi',
                'is_umum',
                'aturan_nominal', // ← TAMBAH
                'referensi_id',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
