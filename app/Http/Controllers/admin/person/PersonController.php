<?php

namespace App\Http\Controllers;

use App\Models\Person\Person;
use App\Services\Person\PersonService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Js;

class PersonController extends Controller
{
    public function __construct(
        private readonly PersonService $personService,
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
        return $this->transactionService->handleWithShow(
            fn() => $this->personService->getListData(),
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_person, 'detail'),
                    $this->transactionService->actionButton($row->id_person, 'edit'),
                ]),
            ]
        );
    }

    public function listApi(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn()=> $this->personService->getListData()
        );
    }

}
