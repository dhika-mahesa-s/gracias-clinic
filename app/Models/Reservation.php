<?php
// app/Models/Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Penting untuk Alias

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    // Sesuaikan dengan nama kolom aktual di migrasi Anda
    protected $fillable = [
        'reservation_code',
        'user_id',
        'doctor_id',
        'treatment_id',
        'schedule_id', // Jika ada
        'reservation_date',
        'reservation_time',
        'total_price',
        'customer_name', // Jika tidak login
        'customer_email', // Jika tidak login
        'customer_phone', // Jika tidak login
        'status',
        'notes',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'total_price' => 'integer', // Sesuaikan jika decimal
    ];

    // Relasi (Pastikan model User, Doctor, Treatment ada)
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
    // public function schedule() { return $this->belongsTo(Schedule::class); } // Jika ada

    // ALIAS (Untuk kompatibilitas dengan view lama)
    protected function bookingId(): Attribute
    {
        return Attribute::make(get: fn() => $this->reservation_code);
    }
    protected function tanggal(): Attribute
    {
        return Attribute::make(get: fn() => $this->reservation_date);
    }
    protected function waktu(): Attribute
    {
        return Attribute::make(get: fn() => $this->reservation_time);
    }
    protected function harga(): Attribute
    {
        return Attribute::make(get: fn() => $this->total_price);
    }
}
