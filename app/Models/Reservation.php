<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'booking_id',
        'user_id',
        'doctor_id',
        'treatment_id',
        'tanggal',
        'waktu',
        'harga',
        'status',
        'notes',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class);
    }

    public function treatment()
    {
        return $this->belongsTo(\App\Models\Treatment::class);
    }
}