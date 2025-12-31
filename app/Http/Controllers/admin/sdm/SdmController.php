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
use Illuminate\Support\Facades\Crypt;

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
        return view('admin.sdm.sdm.index');
    }

    public function histori(string $uuid): View
{
    try {
        $uuid = Crypt::decryptString($uuid);
    } catch (\Exception $e) {
        abort(403, 'Akses terlarang');
    }

    $person = $this->sdmService->getPersonDetailByUuid($uuid);
    $data = $this->sdmService->getHistoriByUuid($uuid);

    return view('admin.sdm.sdm.histori', [
        'person' => $person,
        'data' => $data,
        'id' => $uuid,
    ]);
}


    public function list(Request $request): JsonResponse
    {
                $adminId = auth('admin')->id();
        if (!$adminId) {
            return response()->json(['success' => false], 401);
        }
        // dd($request->all());
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->sdmService->getListData($request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id, 'detail'),
                    $this->transactionService->actionButton($row->id, 'edit'),
                    $this->transactionService->actionLink(
                                route(
                                    'admin.sdm.sdm.histori',
                                    Crypt::encryptString($row->uuid_person)
                                ),
                                'histori',
                                'Riwayat'
                            ),
                ]),
            ]
        );
    }

    public function listApi(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn()=> $this->sdmService->getListData()
        );
    }

    public function store(SdmStoreRequest $request): JsonResponse
    {
        if ($this->sdmService->checkDuplicate($request->id_person)) {
            return $this->responseService->errorResponse('Kombinasi jenis/status SDM untuk person ini sudah terdaftar');
        }

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

    public function find_by_nik($nik): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($nik) {
            $data = $this->sdmService->findByNik($nik);
            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan');
            }

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }


}
