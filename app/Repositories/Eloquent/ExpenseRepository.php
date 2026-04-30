<?php

namespace App\Repositories\Eloquent;

use App\Models\Expense;
use App\Repositories\Contracts\ExpenseRepositoryInterface;

class ExpenseRepository implements ExpenseRepositoryInterface
{
    protected Expense $model;

    public function __construct(Expense $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->orderBy('expense_date', 'desc')->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
