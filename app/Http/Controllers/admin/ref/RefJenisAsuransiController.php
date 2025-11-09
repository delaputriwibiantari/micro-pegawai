<?php

namespace App\Http\Controllers\admin\ref;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ref\RefJenisAsuransiRequest;
use App\Services\Ref\RefJenisAsuransiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class RefJenisAsuransiController extends Controller
{
    public function __construct(
        private readonly RefJenisAsuransiService $refJenisAsuransiService,
        private readonly TransactionService      $transactionService,
        private readonly ResponseService         $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.ref.jenis_asuransi.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->refJenisAsuransiService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_jenis_asuransi;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(RefJenisAsuransiRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->refJenisAsuransiService->create($request->only([
                'kode_asuransi',
                'nama_asuransi',
                'penyelenggara',
                'tipe_asuransi',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refJenisAsuransiService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(RefJenisAsuransiRequest $request, string $id): JsonResponse
    {
        $data = $this->refJenisAsuransiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->refJenisAsuransiService->update($data, $request->only([
                'kode_asuransi',
                'nama_asuransi',
                'penyelenggara',
                'tipe_asuransi',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->refJenisAsuransiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->refJenisAsuransiService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }

}
