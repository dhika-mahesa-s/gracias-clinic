<?php
// app/Models/Feedback.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'reservation_id',
        'user_id',
        'name',
        'email',
        'phone',
        'service_type',
        'message',
        'staff_rating',
        'professional_rating',
        'result_rating',
        'return_rating',
        'overall_rating',
        'is_approved',
        'is_hidden',
        'is_visible', // TAMBAHKAN INI
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_hidden' => 'boolean',
        'is_visible' => 'boolean', // TAMBAHKAN INI
        'staff_rating' => 'integer',
        'professional_rating' => 'integer',
        'result_rating' => 'integer',
        'return_rating' => 'integer',
        'overall_rating' => 'integer',
    ];
    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model User
     */
    public function reservations()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Scope untuk feedback yang tidak disembunyikan
     */
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    /**
     * Scope untuk pencarian berdasarkan nama
     */
    public function scopeSearch($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    /**
     * Scope filter berdasarkan rating keseluruhan
     */
    public function scopeWithRating($query, $rating)
    {
        return $query->where('overall_rating', $rating);
    }

    /**
     * Menghitung rata-rata rating dari seluruh aspek
     */
    public function getAverageRatingAttribute()
    {
        $ratings = [
            $this->staff_rating,
            $this->professional_rating,
            $this->result_rating,
            $this->return_rating,
            $this->overall_rating,
        ];

        // Hapus nilai null agar tidak error
        $ratings = array_filter($ratings, fn($r) => !is_null($r));

        return count($ratings) > 0
            ? round(array_sum($ratings) / count($ratings), 1)
            : null;
    }
}
