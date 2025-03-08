<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use App\Services\ExpenseService;
use App\Services\ApprovalService;
use App\Http\Controllers\Api\ExpenseController;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\ApproveExpenseRequest;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;
class ExpenseControllerTest extends TestCase
{
    protected $expenseService;
    protected $approvalService;
    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Mocking services
        $this->expenseService = Mockery::mock(ExpenseService::class);
        $this->approvalService = Mockery::mock(ApprovalService::class);

        // Inject ke controller
        $this->controller = new ExpenseController($this->expenseService, $this->approvalService);
    }

    protected function getValidationErrors(array $data)
    {
        $request = new ExpenseRequest();
        $validator = Validator::make($data, $request->rules());

        return $validator->errors();
    }

    public function test_index_returns_expenses()
    {
        $mockData = [['id' => 1, 'amount' => 10000, 'description' => 'Makan']];
        $this->expenseService->shouldReceive('getAllExpenses')->once()->andReturn($mockData);

        $response = $this->controller->index();
        
        $this->assertEquals(200, $response->status());
        $this->assertTrue($response->getData()->success);
        $this->assertJson(json_encode($mockData), json_encode($response->getData()->data));
    }

    public function test_store_creates_expense()
    { 
        $request = new ExpenseRequest([
            'amount' => 10000,
        ]);
    
         $request->setValidator(validator($request->all(), (new ExpenseRequest())->rules()));
     
        $mockStatus = (object) ['id' => 1, 'name' => 'Pending'];
    
        $mockApprovals = collect([]);
    
        $mockExpense = Mockery::mock(Expense::class)->makePartial();
        $mockExpense->id = 1;
        $mockExpense->amount = 10000;
        $mockExpense->shouldReceive('getAttribute')->with('status')->andReturn($mockStatus);
        $mockExpense->shouldReceive('getAttribute')->with('approvals')->andReturn($mockApprovals);
    
        $this->expenseService->shouldReceive('createExpense')->once()->andReturn($mockExpense);
    
        $response = $this->controller->store($request);
    
        $this->assertEquals(201, $response->status());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals('Pengeluaran berhasil ditambahkan', $response->getData()->message);
        $this->assertEquals(1, $response->getData()->data->status->id);
        $this->assertEquals('Pending', $response->getData()->data->status->name);
    }

    public function test_amount_is_required()
    {
        $errors = $this->getValidationErrors(['amount' => '']);
        $this->assertTrue($errors->has('amount'));
        $this->assertEquals('The amount field is required.', $errors->first('amount'));
    }
    
    public function test_amount_must_be_numeric()
    {
        $errors = $this->getValidationErrors(['amount' => 'abc']);
        $this->assertTrue($errors->has('amount'));
        $this->assertEquals('The amount field must be a number.', $errors->first('amount'));
    }

    public function test_amount_must_be_at_least_1()
    {
        $errors = $this->getValidationErrors(['amount' => 0]);
        $this->assertTrue($errors->has('amount'));
        $this->assertEquals('The amount field must be at least 1.', $errors->first('amount'));
    }

    public function test_successful_request()
    {
        $errors = $this->getValidationErrors(['amount' => 100]);
        $this->assertFalse($errors->has('amount'));
    }

    public function test_show_returns_expense()
    {
        $mockExpense = Mockery::mock(Expense::class)->makePartial();
        $mockExpense->id = 1;
        $mockExpense->amount = 10000;
        $mockExpense->description = 'Makan';
        $mockStatus = (object) ['id' => 1, 'name' => 'Pending'];
        $mockApprovals = collect([]);

        $mockExpense->shouldReceive('getAttribute')->with('status')->andReturn($mockStatus);
        $mockExpense->shouldReceive('getAttribute')->with('approvals')->andReturn($mockApprovals);
        $this->expenseService->shouldReceive('getExpenseById')->with(1)->once()->andReturn($mockExpense);

        $response = $this->controller->show(1);
        
        $this->assertEquals(200, $response->status());
        $this->assertTrue($response->getData()->success);
    }

    public function test_update_expense()
{
    $request = new ExpenseRequest([
        'amount' => 15000,
    ]);

    $request->setValidator(validator($request->all(), (new ExpenseRequest())->rules()));

    $mockStatus = (object) ['id' => 1, 'name' => 'Pending'];
    $mockApprovals = collect([]);

    $mockExpense = Mockery::mock(Expense::class)->makePartial();
    $mockExpense->id = 1;
    $mockExpense->amount = 15000;
    $mockExpense->shouldReceive('getAttribute')->with('status')->andReturn($mockStatus);
    $mockExpense->shouldReceive('getAttribute')->with('approvals')->andReturn($mockApprovals);

    $this->expenseService->shouldReceive('updateExpense')->with(1, $request->validated())->once()->andReturn($mockExpense);

    $response = $this->controller->update($request, 1);

    $this->assertEquals(200, $response->status());
    $this->assertTrue($response->getData()->success);
    $this->assertEquals('Pengeluaran berhasil diperbarui', $response->getData()->message);
    $this->assertEquals(1, $response->getData()->data->status->id);
    $this->assertEquals('Pending', $response->getData()->data->status->name);
}

    public function test_destroy_expense()
    {
        $this->expenseService->shouldReceive('deleteExpense')->with(1)->once()->andReturn(true);

        $response = $this->controller->destroy(1);

        $this->assertEquals(200, $response->status());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals('Pengeluaran berhasil dihapus', $response->getData()->message);
    }

    public function test_approve_expense()
    {
        $mockApproval = ['id' => 1, 'status' => 'approved'];
        $request = ApproveExpenseRequest::create('/approve/1', 'POST', ['approver_id' => 2]);

        $this->approvalService->shouldReceive('approveExpense')->with(1, 2)->once()->andReturn($mockApproval);

        $response = $this->controller->approveExpense($request, 1);

        $this->assertEquals(200, $response->status());
        $this->assertTrue($response->getData()->success);
        $this->assertEquals('Pengeluaran berhasil disetujui', $response->getData()->message);
    }
}
