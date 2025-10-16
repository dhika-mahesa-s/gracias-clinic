<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_code',
        'user_id',
        'doctor_id',
        'treatment_id',
        'schedule_id',
        'reservation_date',
        'reservation_time',
        'total_price',
        'status',
        'notes',
        'customer_name',
        'customer_email',
        'customer_phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
