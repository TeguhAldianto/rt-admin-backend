<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseHistory extends Model
{
    use HasFactory;

    protected $fillable = ['house_id', 'occupant_id', 'start_date', 'end_date', 'is_active'];

    public function occupant()
    {
        return $this->belongsTo(Occupant::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
