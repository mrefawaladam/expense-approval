<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ExpenseService;
use App\Services\ApprovalService;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Requests\ExpenseRequest;
use App\Models\Status;
use App\Models\Approver;
use App\Models\ApprovalStage;
class ExpensesTest extends TestCase
{
    use RefreshDatabase;

    protected $expenseService;
    protected $approvalService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->expenseService = $this->app->make(ExpenseService::class);
        $this->approvalService = $this->app->make(ApprovalService::class);

        Status::factory()->create(['id' => 1, 'name' => 'Pending']);
        Status::factory()->create(['id' => 2, 'name' => 'Approved']);
        Status::factory()->create(['id' => 3, 'name' => 'Rejected']);

        // Seed Approvers
        Approver::factory()->create(['id' => 1, 'name' => 'Ana']);
        Approver::factory()->create(['id' => 2, 'name' => 'Ani']);
        Approver::factory()->create(['id' => 3, 'name' => 'Ina']);

        // Seed Approval Stages
        ApprovalStage::factory()->create(['approver_id' => 1, 'stage' => 1]);
        ApprovalStage::factory()->create(['approver_id' => 2, 'stage' => 2]);
        ApprovalStage::factory()->create(['approver_id' => 3, 'stage' => 3]);
    }

    public function test_store_method(): void
    {
        // Arrange
        $requestData = [
            'amount' => 1000,
            'status_id' => 1,
        ];

        // Act
        $response = $this->postJson('/api/expenses', $requestData);
       
        // Assert
        $response->assertStatus(201);
        $responseData = $response->json('data');
        $this->assertTrue($response->json('success'));
        $this->assertEquals('Pengeluaran berhasil ditambahkan', $response->json('message'));
        $this->assertEquals($requestData['amount'], $responseData['amount']);
        $this->assertEquals($requestData['status_id'], $responseData['status']['id']);
    }

    /**
     * Test the approveExpense method of ExpenseController.
     */
    public function test_approve_expense_method(): void
    {
        // Arrange
        $requestData = [ 
            'approver_id' => 1,
        ];

        $expectedApproval = (object)[
            'id' => 1,
            'expense_id' => 1,
            'approver_id' => 1,
            'status_id' => 2, 
        ];

        $response = $this->postJson('/api/approval-stages/1', $requestData);
 
        // Assert
        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertTrue($responseData['success']);
        $this->assertEquals('Pengeluaran berhasil disetujui', $responseData['message']);
        $this->assertEquals($expectedApproval->id, $responseData['data']['id']);
        $this->assertEquals($expectedApproval->expense_id, $responseData['data']['expense_id']);
        $this->assertEquals($expectedApproval->approver_id, $responseData['data']['approver_id']);
        $this->assertEquals($expectedApproval->status_id, $responseData['data']['status_id']);
    }
}