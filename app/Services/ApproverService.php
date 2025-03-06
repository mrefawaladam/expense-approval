<?php

namespace App\Services;

use App\Repositories\ApproverRepository;
use Illuminate\Validation\ValidationException;

class ApproverService
{
    protected $approverRepository;

    public function __construct(ApproverRepository $approverRepository)
    {
        $this->approverRepository = $approverRepository;
    }

    public function createApprover(array $data)
    {
        if ($this->approverRepository->findByName($data['name'])) {
            throw ValidationException::withMessages(['name' => 'Approver dengan nama ini sudah ada.']);
        }

        return $this->approverRepository->create($data);
    }
}
