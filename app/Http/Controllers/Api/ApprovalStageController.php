<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalStageRequest;
use App\Services\ApprovalStageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApprovalStageController extends Controller
{
    protected $approvalStageService;

    public function __construct(ApprovalStageService $approvalStageService)
    {
        $this->approvalStageService = $approvalStageService;
    }

    public function store(ApprovalStageRequest $request)
    {
        $approvalStage = $this->approvalStageService->createApprovalStage($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tahap approval berhasil ditambahkan',
            'data' => $approvalStage
        ], 201);
    }

    public function update(ApprovalStageRequest $request, int $id)
    {
        $approvalStage = $this->approvalStageService->updateApprovalStage($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tahap approval berhasil diperbarui',
            'data' => $approvalStage
        ]);
    }
}
