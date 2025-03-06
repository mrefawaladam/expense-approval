<?php

namespace App\Repositories;

use App\Models\ApprovalStage;

class ApprovalStageRepository
{
    public function create(array $data)
    {
        return ApprovalStage::create($data);
    }

    public function update(int $id, array $data)
    {
        $approvalStage = ApprovalStage::findOrFail($id);
        $approvalStage->update($data);
        return $approvalStage;
    }

    public function findByApproverId(int $approverId)
    {
        return ApprovalStage::where('approver_id', $approverId)->first();
    }
}
