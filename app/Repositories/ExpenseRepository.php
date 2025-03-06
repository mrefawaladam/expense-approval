<?php

namespace App\Repositories;

use App\Models\Expense;

class ExpenseRepository
{
    public function getAll()
    {
        return Expense::with('status', 'approvals')->get();
    }

    public function findById($id)
    {
        return Expense::with('status', 'approvals')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Expense::create([
            'amount' => $data['amount'],
            'status_id' => 1
        ]);
    }

    public function update($id, array $data)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($data);
        return $expense;
    }

    public function delete($id)
    {
        return Expense::destroy($id);
    }
}
