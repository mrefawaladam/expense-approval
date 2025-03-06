<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ExpenseService;
use App\Services\ApprovalService;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ApproveExpenseRequest;
use App\Http\Resources\ExpenseCollection;
use App\Http\Resources\ExpenseResource;

class ExpenseController extends Controller
{
    protected $expenseService;

    public function __construct(
        ExpenseService $expenseService,
        ApprovalService $approvalService
        )
    {
        $this->expenseService = $expenseService;
        $this->approvalService = $approvalService;
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->expenseService->getAllExpenses()
        ]);
    }


    public function approveExpense(ApproveExpenseRequest $request, $id)
    {
        $approval = $this->approvalService->approveExpense($id, $request->approver_id);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil disetujui',
            'data' => $approval
        ], 200);
    }

    public function store(ExpenseRequest $request)
    {
       
        $expense = $this->expenseService->createExpense($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil ditambahkan',
            'data' => new ExpenseResource($expense)
        ], 201);
    }


    public function show($id)
    {
        $expense = $this->expenseService->getExpenseById($id);

        return response()->json([
            'success' => true,
            'data' => new ExpenseResource($expense)
        ]);
    }

    public function update(ExpenseRequest $request, $id)
    {

        $expense = $this->expenseService->updateExpense($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil diperbarui',
            'data' => $expense
        ]);
    }

    public function destroy($id)
    {
        $this->expenseService->deleteExpense($id);
        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil dihapus'
        ]);
    }
}
