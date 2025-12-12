<?php

namespace App\Http\Controllers\admin\absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\absensi\JenisAbsensiRequest;
use App\Services\Absensi\JenisAbsensiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class JenisAbsensiController extends Controller
{
    public function __construct(
        private readonly JenisAbsensiService  $jenisabsensiservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.absensi.jenis_absensi.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->jenisabsensiservice->getListData($request);
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

    public function store(JenisAbsensiRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->jenisabsensiservice->create($request->only([
                'jenis_absen_id',
                'nama_absen',
                'kategori',
                'potong_gaji',
                'warna'
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->jenisabsensiservice->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(JenisAbsensiRequest $request, string $id): JsonResponse
    {
        $data = $this->jenisabsensiservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->jenisabsensiservice->update($data, $request->only([
                'jenis_absen_id',
                'nama_absen',
                'kategori',
                'potong_gaji',
                'warna'
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
