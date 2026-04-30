<?php

namespace App\Services;

use App\Repositories\Contracts\ExpenseRepositoryInterface;

class ExpenseService
{
    protected ExpenseRepositoryInterface $expenseRepository;

    public function __construct(ExpenseRepositoryInterface $expenseRepository)
    {
        $this->expenseRepository = $expenseRepository;
    }

    public function getAllExpenses()
    {
        return $this->expenseRepository->getAll();
    }

    public function recordExpense(array $data)
    {
        return $this->expenseRepository->create($data);
    }
}
