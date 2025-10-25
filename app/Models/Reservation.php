<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    // Kolom yang benar sesuai DB & controller
    protected $fillable = [
        'reservation_code',
        'user_id',
        'doctor_id',
        'treatment_id',
        'schedule_id',
        'reservation_date',
        'reservation_time',
        'total_price',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'notes',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        // TIME di MySQL → simpan string; kalau mau, buat custom cast
        'reservation_time' => 'string',
        // Sesuaikan dengan tipe kolommu (integer/decimal)
        'total_price'      => 'integer',
    ];

    /* =======================
       RELATIONSHIPS
    ======================= */
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

    /* ==========================================================
       ALIAS untuk kompatibilitas kode lama (opsional tapi helpful)
       booking_id -> reservation_code
       tanggal    -> reservation_date
       waktu      -> reservation_time
       harga      -> total_price
    ========================================================== */

    protected function bookingId(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation_code,
            set: fn ($value) => ['reservation_code' => $value],
        );
    }

    protected function tanggal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation_date,
            set: fn ($value) => ['reservation_date' => $value],
        );
    }

    protected function waktu(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reservation_time,
            set: fn ($value) => ['reservation_time' => $value],
        );
    }

    protected function harga(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->total_price,
            set: fn ($value) => ['total_price' => $value],
        );
    }
}
