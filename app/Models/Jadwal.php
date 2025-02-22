<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
