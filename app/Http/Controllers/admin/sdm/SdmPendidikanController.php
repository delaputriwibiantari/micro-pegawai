<?php

namespace App\Http\Controllers\admin\sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmPendidikanStoreRequest;
use App\Http\Requests\Sdm\SdmPendidikanUpdateRequest;
use App\Services\Sdm\SdmPendidikanService;
use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class SdmPendidikanController extends Controller
{
    public function __construct(
        private readonly SdmPendidikanService       $sdmpendidikanService,
        private readonly TransactionService         $transactionService,
        private readonly ResponseService            $responseService,
        private readonly FileUploadService          $fileUploadService,

    )
    {}

    public function index(string $uuid): View
    {
        $person = $this->sdmpendidikanService->getPersonDetailByUuid($uuid);

        return view('admin.sdm.pendidikan.index', ['person' => $person, 'id' => $uuid]);
    }

    public function list(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(

            function () use ($uuid, $request) {
                return $this->sdmpendidikanService->getListData($uuid, $request);
                
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id, 'detail'),
                    $this->transactionService->actionButton($row->id, 'edit'),
                    $this->transactionService->actionButton($row->id, 'delete'),
                ]),
            ]
        );
    }

    public function listApi(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmpendidikanService->getListData($uuid, $request);
            }
        );
    }

    public function store(SdmPendidikanStoreRequest $request): JsonResponse
    {
        $idSdm = $this->sdmpendidikanService->resolveIdSdmFromUuid($request->uuid_person);
        if (!$idSdm) {
            return $this->responseService->errorResponse('SDM tidak ditemukan');
        }
        $fileIjazah = $request->file('file_ijazah');
        $fileTranskip = $request->file('file_transkip');
        if ($fileIjazah) {
            try {
                $this->fileUploadService->validateFileForUpload($fileIjazah);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        if ($fileTranskip) {
            try {
                $this->fileUploadService->validateFileForUpload($fileTranskip);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $idSdm, $fileIjazah, $fileTranskip) {
            $payload = $request->only([
                'id_jenjang_pendidikan', 'institusi', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'jenis_nilai',
                'sks', 'sumber_biaya',
            ]);
            $payload['id_sdm'] = $idSdm;
            $data = $this->sdmpendidikanService->create($payload);
            if ($fileIjazah) {
                $uploadResult = $this->sdmpendidikanService->handleFileUpload($fileIjazah, $idSdm, 'ijazah');
                $data->update([
                    'file_ijazah' => $uploadResult['file_name'],
                ]);
            }
            if ($fileTranskip) {
                $uploadResult = $this->sdmpendidikanService->handleFileUpload($fileTranskip, $idSdm, 'transkip');
                $data->update([
                    'file_transkip' => $uploadResult['file_name'],
                ]);
            }
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function update(SdmPendidikanUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmpendidikanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        $fileIjazah = $request->file('file_ijazah');
        $fileTranskip = $request->file('file_transkip');
        if ($fileIjazah) {
            try {
                $this->fileUploadService->validateFileForUpload($fileIjazah);
            } catch (InvalidArgumentException$e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        if ($fileTranskip) {
            try {
                $this->fileUploadService->validateFileForUpload($fileTranskip);
            } catch (InvalidArgumentException $e) {
                return $this->responseService->errorResponse($e->getMessage(), 422);
            }
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data, $fileIjazah, $fileTranskip) {
            $payload = $request->only([
                'id_jenjang_pendidikan', 'institusi', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'jenis_nilai',
                'sks', 'sumber_biaya',
            ]);
            $updatedData = $this->sdmpendidikanService->update($data, $payload);
            if ($fileIjazah) {
                $uploadResult = $this->sdmpendidikanService->updateFileUpload(
                    $fileIjazah,
                    $data->file_ijazah,
                    $data->id_sdm,
                    'ijazah'
                );
                $updatedData->update([
                    'file_ijazah' => $uploadResult['file_name'],
                ]);
            }
            if ($fileTranskip) {
                $uploadResult = $this->sdmpendidikanService->updateFileUpload(
                    $fileTranskip,
                    $data->file_transkip,
                    $data->id_sdm,
                    'transkip'
                );
                $updatedData->update([
                    'file_transkip' => $uploadResult['file_name'],
                ]);
            }
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmpendidikanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->sdmpendidikanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->sdmpendidikanService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
