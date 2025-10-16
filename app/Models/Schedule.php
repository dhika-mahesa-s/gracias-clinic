<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'quota',
        'status',
    ];

    // 🔗 Relasi
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
