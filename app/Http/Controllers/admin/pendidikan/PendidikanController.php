<?php

namespace App\Http\Controllers\admin\pendidikan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pendidikan\PendidikanStoreRequest;
use App\Services\Pendidikan\PendidikanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;


class PendidikanController extends Controller
{
    public function __construct(
        private readonly PendidikanService $pendidikanService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,

    )
    {}

    public function index(): View
    {
        return view('admin.person.index');
    }

    public function list(): JsonResponse
    {
        $data = $this->pendidikanService->getListData();

        // Tambahkan action untuk setiap row
        $data->transform(function ($row) {
            $row->action = implode(' ', [
                $this->transactionService->actionButton($row->id, 'detail'),
                $this->transactionService->actionButton($row->id, 'edit'),
            ]);
            return $row;
        });

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }

    public function listApi(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn()=> $this->pendidikanService->getListData()
        );
    }

    public function store(PendidikanStoreRequest $request): JsonResponse
    {

        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $payload = $request->only([
                'id_sdm',
                'institusi',
                'jurusan',
                'tahun_masuk',
                'tahun_lulus',
                'jenis_nilai',
                'sks',
                'sumber_biaya',
            ]);

            $created = $this->pendidikanService->create($payload);

            return $this->responseService->successResponse('Data berhasil dibuat', $created, 201);
        });
    }



    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->pendidikanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }
}
