<?php

namespace App\Http\Controllers\admin\sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmStoreRequest;
use App\Http\Requests\Sdm\SdmUpdateRequest;
use App\Models\Person\Person;
use App\Services\Sdm\SdmService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SdmController extends Controller
{
    public function __construct(
        private readonly SdmService $sdmService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService

    )
    {}

    public function index(): View
    {
        return view('admin.sdm.index');
    }

    public function list(): JsonResponse
    {
        $data = $this->sdmService->getListData();

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
            fn()=> $this->sdmService->getListData()
        );
    }

    public function store(SdmStoreRequest $request): JsonResponse
    {

        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $payload = $request->only([
               'nip',
                'status_pegawai',
                'tipe_pegawai',
                'tanggal_masuk',
                'id_person',
            ]);

            $created = $this->sdmService->create($payload);

            return $this->responseService->successResponse('Data berhasil dibuat', $created, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmService->getDetailData($id);
            

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function cari(Request $request): JsonResponse
    {
        $request->validate([
            'nik' => 'required|string|size:16|regex:/^[0-9]+$/'
        ]);

        $person = $this->sdmService->findPersonByNik($request->nik);

        if (!$person) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan atau sudah terdaftar di SDM',
                'data' => null
            ]);
        }

        $formatted = $this->sdmService->formatPersonData($person);

        return response()->json([
            'success' => true,
            'message' => 'Data ditemukan',
            'data' => $formatted
        ]);
    }

    public function update(SdmUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }


        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
             $payload = $request->only([
               'nip',
                'status_pegawai',
                'tipe_pegawai',
                'tanggal_masuk',
                'id_person',
            ]);

            $updatedData = $this->sdmService->update($data, $payload);

            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }


}
