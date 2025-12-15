<?php

namespace App\Http\Controllers\admin\absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\absensi\LemburApprovalRequest;
use App\Http\Requests\absensi\LemburRequest;
use App\Services\Absensi\LemburApprovalService;
use App\Services\Absensi\LemburService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class LemburController extends Controller
{
    public function __construct(
        private readonly LemburService  $lemburservice,
        private readonly LemburApprovalService $lemburapprovalservice,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.absensi.lembur.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->lemburservice->getListData($request);
            },
            [
                    'jam_pelaksanaan' => function ($row) {
                    return $row->jam_mulai . ' - ' . $row->jam_selesai;
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

    public function store(LemburRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->lemburservice->create($request->only([
                'lembur_id',
                'tanggal',
                'jam_mulai',
                'jam_selesai',
                'durasi_jam',
                'sdm_id'
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->lemburservice->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(LemburRequest $request, string $id): JsonResponse
    {
        $data = $this->lemburservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->lemburservice->update($data, $request->only([
                'lembur_id',
                'tanggal',
                'jam_mulai',
                'jam_selesai',
                'durasi_jam',
                'sdm_id'
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function approval(LemburApprovalRequest $request, string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request, $id) {
            $cuti = $this->lemburapprovalservice->approval(
                $id,
                $request->status,
                $request->all()
            );

            return $this->responseService
                ->successResponse('Cuti berhasil diproses', $cuti);
        });
    }
}
