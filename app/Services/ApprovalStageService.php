<?php

namespace App\Services;

use App\Repositories\ApprovalStageRepository;
use App\Repositories\ApproverRepository;
use Illuminate\Validation\ValidationException;

class ApprovalStageService
{
    protected $approvalStageRepository;
    protected $approverRepository;

    public function __construct(ApprovalStageRepository $approvalStageRepository, ApproverRepository $approverRepository)
    {
        $this->approvalStageRepository = $approvalStageRepository;
        $this->approverRepository = $approverRepository;
    }

    public function createApprovalStage(array $data)
    {   
        return $this->approvalStageRepository->create($data);
    }

    public function updateApprovalStage(int $id, array $data)
    {  
        return $this->approvalStageRepository->update($id, $data);
    }
}
