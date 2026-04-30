<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\OccupantRepositoryInterface;
use App\Repositories\Eloquent\OccupantRepository;
use App\Repositories\Contracts\HouseRepositoryInterface;
use App\Repositories\Eloquent\HouseRepository;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use App\Repositories\Eloquent\PaymentRepository;
use App\Repositories\Contracts\ExpenseRepositoryInterface; // <-- Tambahan untuk Expense
use App\Repositories\Eloquent\ExpenseRepository;         // <-- Tambahan untuk Expense

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Daftarkan semua binding interface ke implementasinya di sini
        $this->app->bind(OccupantRepositoryInterface::class, OccupantRepository::class);
        $this->app->bind(HouseRepositoryInterface::class, HouseRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class); // <-- Binding Expense
    }

    public function boot(): void
    {
        //
    }
}
