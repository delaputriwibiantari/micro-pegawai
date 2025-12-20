<?php

namespace App\Http\Controllers\admin\absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\absensi\AbsensiRequest;
use App\Services\Absensi\AbsensiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AbsensiController extends Controller
{
    public function __construct(
        private readonly AbsensiService $absensiService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.absensi.absensi.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->absensiService->getListData($request);
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                    ]);
                },
            ]
        );
    }

    public function store(AbsensiRequest $request): JsonResponse
{
    return $this->transactionService->handleWithTransaction(function () use ($request) {

        $result = $this->absensiService->create($request->all());

        if (isset($result['error'])) {
            return $this->responseService->errorResponse(
                $result['message'],
                422
            );
        }

        return $this->responseService->successResponse(
            'Data berhasil dibuat',
            $result,
            201
        );
    });
}


    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->absensiService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(AbsensiRequest $request, string $id): JsonResponse
    {
        $data = $this->absensiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->absensiService->update($data, $request->only([
                'absensi_id',
                'tanggal',
                'jadwal_id',
                'jenis_absen_id',
                'total_terlambat',
                'sdm_id',
                'waktu_selesai',
                'waktu_mulai',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }
}
