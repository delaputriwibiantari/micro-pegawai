<?php

namespace App\Http\Controllers\admin\absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\absensi\IzinApprovalRequest;
use App\Http\Requests\absensi\IzinRequest;
use App\Services\Absensi\IzinApprovalService;
use App\Services\Absensi\IzinService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class IzinController extends Controller
{
    public function __construct(
        private readonly IzinService           $izinservice,
        private readonly IzinApprovalService   $izinapprovalservice,
        private readonly TransactionService    $transactionService,
        private readonly ResponseService       $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.absensi.izin.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->izinservice->getListData($request);
            },
            [
                'waktu_izin' => function ($row) {
                    return $row->jam_mulai . ' - ' . $row->jam_selesai ;
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

    public function store(IzinRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->izinservice->create($request->only([
                'izin_id',
                'jenis_izin',
                'status',
                'keterangan',
                'tanggal',
                'jam_mulai',
                'jam_selesai',
                'sdm_id'
            ]));

            return $this->responseService
                ->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->izinservice->getDetailData($id);

            return $this->responseService
                ->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(IzinRequest $request, string $id): JsonResponse
    {
        $data = $this->izinservice->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->izinservice->update($data, $request->only([
                'jenis_izin',
                'keterangan',
                'tanggal',
                'jam_mulai',
                'jam_selesai',
            ]));

            return $this->responseService
                ->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function approval(IzinApprovalRequest $request, string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request, $id) {
            $izin = $this->izinapprovalservice->approval(
                $id,
                $request->status,
                $request->all()
            );

            return $this->responseService
                ->successResponse('Izin berhasil diproses', $izin);
        });
    }
}
