<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Ini adalah kolom yang hilang tersebut (Relasi ke tabel occupants)
            $table->foreignId('occupant_id')->constrained('occupants')->cascadeOnDelete();

            $table->enum('payment_type', ['satpam', 'kebersihan']);
            $table->integer('amount');
            $table->tinyInteger('for_month');
            $table->year('for_year');
            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
