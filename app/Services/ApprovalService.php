<?php

namespace App\Services;

use App\Repositories\ApprovalRepository;

class ApprovalService
{
    protected $approvalRepository;

    public function __construct(ApprovalRepository $approvalRepository)
    {
        $this->approvalRepository = $approvalRepository;
    }

    public function approveExpense($expenseId, $approverId)
    {
        return $this->approvalRepository->approveExpense($expenseId, $approverId);
    }
}
