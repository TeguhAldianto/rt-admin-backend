<?php

namespace App\Repositories\Eloquent;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    protected Payment $model;

    public function __construct(Payment $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function createMultiple(array $data)
    {
        return $this->model->insert($data); // Menggunakan insert untuk bulk create agar lebih cepat
    }
}
