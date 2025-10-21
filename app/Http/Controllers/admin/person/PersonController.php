<?php

namespace App\Http\Controllers;

use App\Services\Person\PersonService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function __construct(
        private readonly PersonService      $personService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService    $responseService,
    ){}

    public function index(): View
    {
        return view('admin.person.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithShow(
            fn() => $this->personService->getlistdata());
    }
}
