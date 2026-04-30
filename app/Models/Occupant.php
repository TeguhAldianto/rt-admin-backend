<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'id_card_photo',
        'occupant_status',
        'phone_number',
        'marital_status',
    ];

    public function houseHistories()
    {
        return $this->hasMany(HouseHistory::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
