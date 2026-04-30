<?php

namespace App\Repositories\Contracts;

interface ExpenseRepositoryInterface
{
    public function getAll();
    public function create(array $data);
}
