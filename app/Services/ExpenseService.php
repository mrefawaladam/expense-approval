<?php

namespace App\Services;

use App\Repositories\ExpenseRepository;

class ExpenseService
{
    protected $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function getAllExpenses()
    {
        return $this->expenseRepository->getAll();
    }

    public function getExpenseById($id)
    {
        return $this->expenseRepository->findById($id);
    }

    public function createExpense($data)
    {
        return $this->expenseRepository->create($data);
    }

    public function updateExpense($id, $data)
    {
        return $this->expenseRepository->update($id, $data);
    }

    public function deleteExpense($id)
    {
        return $this->expenseRepository->delete($id);
    }
}
