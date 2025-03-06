<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApproverRequest;
use App\Services\ApproverService;
use Illuminate\Http\JsonResponse;

class ApproverController extends Controller
{
    protected $approverService;

    public function __construct(ApproverService $approverService)
    {
        $this->approverService = $approverService;
    }

    public function store(ApproverRequest $request): JsonResponse
    {
        $approver = $this->approverService->createApprover($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Approver berhasil ditambahkan',
            'data' => $approver
        ], 201);
    }
}
