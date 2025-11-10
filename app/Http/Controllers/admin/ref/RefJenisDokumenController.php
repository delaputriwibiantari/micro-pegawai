<?php

namespace App\Http\Controllers\admin\ref;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ref\RefJenisDokumenRequest;
use App\Http\Requests\Ref\RefJenjangPendidikanRequest;
use App\Models\Ref\RefJenisDokumen;
use App\Services\Ref\RefJenisDokumenService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;



final class RefJenisDokumenController extends Controller
{
    public function __construct(
        private readonly RefJenisDokumenService     $refJenisDokumenService,
        private readonly TransactionService          $transactionService,
        private readonly ResponseService             $responseService,
    )
    {
    }

    public function index(): View
    {
        return view('admin.ref.jenis_dokumen.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->refJenisDokumenService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_jenis_dokumen;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(RefJenisDokumenRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->refJenisDokumenService->create($request->only([
                'jenis_dokumen',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->refJenisDokumenService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(RefJenisDokumenRequest $request, string $id): JsonResponse
    {
        $data = $this->refJenisDokumenService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->refJenisDokumenService->update($data, $request->only([
                'jenis_dokumen',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->refJenisDokumenService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->refJenisDokumenService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
