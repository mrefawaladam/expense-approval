<?php

namespace App\Repositories;

use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Models\Expense;

class ApprovalRepository
{
    public function approveExpense($expenseId, $approverId)
    {
        $expense = Expense::findOrFail($expenseId);
        
        $approval = Approval::create([
            'expense_id'  => $expense->id,
            'approver_id' => $approverId,
            'status_id'   =>   2
        ]);

        $totalStages = ApprovalStage::count();
        $approvedCount = Approval::where('expense_id', $expenseId)->count();

        if ($approvedCount >= $totalStages) {
            $expense->update(['status_id' => 2]);  
        }

        return $approval;
    }
}
