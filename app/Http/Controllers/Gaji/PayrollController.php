<?php

namespace App\Http\Controllers\Gaji;

use App\Http\Controllers\Controller;
use App\Models\Gaji\GajiPeriode;
use App\Models\Gaji\GajiTrx;
use App\Models\sdm\Sdm;
use App\Services\Gaji\PayrollManualProcessorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PayrollController extends Controller
{
    protected $processor;

    public function __construct(PayrollManualProcessorService $processor)
    {
        $this->processor = $processor;

        // Middleware to ensure auth if needed
        // $this->middleware('auth');
    }

    /**
     * Display a listing of payroll periods/transactions.
     */
    public function index()
    {
        $periodes = GajiPeriode::orderBy('tahun', 'desc')
            ->orderBy('periode_id', 'desc') // Assuming string month like '01'
            ->get();

        return view('admin.gaji.payroll.index', compact('periodes'));
    }

    /**
     * Show the form for creating a new payroll generation.
     */
    public function create()
    {
        // Get open/draft periods
        $periodes = GajiPeriode::where('status', 'DRAFT')->get();
        // Get active employees (Tetap & Kontrak)
        $employees = Sdm::with('person')
            ->whereIn('status_pegawai', ['TETAP', 'KONTRAK'])
            ->get();

        return view('admin.gaji.payroll.create', compact('periodes', 'employees'));
    }

    /**
     * Store a newly created resource in storage (Generate Payroll).
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode_id' => 'required',
            'sdm_id'     => 'nullable'
        ]);

        try {
            if ($request->filled('sdm_id')) {
                // Process single employee
                $result = $this->processor->processSingleEmployee(
                    $request->periode_id,
                    $request->sdm_id
                );

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Payroll generated successfully.',
                        'data' => $result
                    ]);
                }

                return redirect()->route('admin.payroll.index')
                    ->with('success', "Payroll generated successfully for employee.");
            } else {
                // Process all active employees
                $query = Sdm::whereIn('status_pegawai', ['TETAP', 'KONTRAK']);
                $employees = $query->get();
                $count = 0;

                foreach ($employees as $sdm) {
                    $this->processor->processSingleEmployee($request->periode_id, $sdm->id);
                    $count++;
                }

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => "Payroll generated successfully for $count employees.",
                    ]);
                }

                return redirect()->route('admin.payroll.index')
                    ->with('success', "Payroll generated successfully for $count employees.");
            }
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error generating payroll: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error generating payroll: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource (Payslip).
     */
    public function show($id)
    {
        // $id here could be the GajiTrx id
        $trx = GajiTrx::with(['details.komponen', 'sdm.person'])
            ->findOrFail($id);

        return view('admin.gaji.payroll.show', compact('trx'));
    }
}
