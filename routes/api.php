<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ApproverController;
use App\Http\Controllers\Api\ApprovalStageController;


Route::apiResource('expenses', ExpenseController::class);
Route::post('/approvers', [ApproverController::class, 'store']);
Route::post('/approval-stages', [ApprovalStageController::class, 'store']);
Route::put('/approval-stages/{id}', [ApprovalStageController::class, 'update']);
Route::patch('/expense/{id}/approve', [ExpenseController::class, 'approveExpense']);
