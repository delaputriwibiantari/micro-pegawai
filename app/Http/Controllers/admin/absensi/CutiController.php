<?php

namespace App\Http\Controllers\admin\absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\absensi\CutiApprovalRequest;
use App\Http\Requests\absensi\CutiRequest;
use App\Services\Absensi\CutiApprovalService;
use App\Services\Absensi\CutiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class CutiController extends Controller
{
    public function __construct(
        private readonly CutiService  $cutiservice,
        private readonly CutiApprovalService $cutiapprovalservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.absensi.cuti.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->cutiservice->getListData($request);
            },
            [
                    'tanggal_pelaksanaan' => function ($row) {
                    return $row->tanggal_mulai . ' - ' . $row->tanggal_selesai;
                },
                'action' => function ($row) {
                    $rowId = $row->id;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                        $this->transactionService->actionButton($rowId, 'approval'),
                    ]);
                },
            ]
        );
    }

    public function store(CutiRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->cutiservice->create($request->only([
                'cuti_id',
                'jenis_cuti',
                'status',
                'keterangan',
                'total_hari',
                'tanggal_mulai',
                'tanggal_selesai',
                'total_hari',
                'sdm_id'
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->cutiservice->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(CutiRequest $request, string $id): JsonResponse
    {
        $data = $this->cutiservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->cutiservice->update($data, $request->only([
                'jenis_cuti',
                'keterangan',
                'total_hari',
                'tanggal_mulai',
                'tanggal_selesai',
                'total_hari',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function approval(CutiApprovalRequest $request, string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request, $id) {
            $cuti = $this->cutiapprovalservice->approval(
                $id,
                $request->status,
                $request->all()
            );

            return $this->responseService
                ->successResponse('Cuti berhasil diproses', $cuti);
        });
    }
}
