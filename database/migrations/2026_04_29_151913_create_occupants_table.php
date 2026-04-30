<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('occupants', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('id_card_photo')->nullable(); // Disimpan sebagai path file
            $table->enum('occupant_status', ['kontrak', 'tetap']);
            $table->string('phone_number');
            $table->enum('marital_status', ['menikah', 'belum_menikah']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occupants');
    }
};
