<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
    ];

    /**
     * Relationship dengan Treatment
     */
    public function treatments()
    {
        return $this->belongsToMany(Treatment::class, 'discount_treatment')
                    ->withTimestamps();
    }

    /**
     * Check apakah diskon sedang aktif (dalam periode waktu)
     */
    public function isCurrentlyActive()
    {
        $now = Carbon::now();
        return $this->is_active 
               && $now->greaterThanOrEqualTo($this->start_date)
               && $now->lessThanOrEqualTo($this->end_date);
    }

    /**
     * Hitung harga setelah diskon
     */
    public function calculateDiscountedPrice($originalPrice)
    {
        if ($this->type === 'percentage') {
            return $originalPrice - ($originalPrice * ($this->value / 100));
        } else {
            return max(0, $originalPrice - $this->value);
        }
    }

    /**
     * Get discount amount
     */
    public function getDiscountAmount($originalPrice)
    {
        if ($this->type === 'percentage') {
            return $originalPrice * ($this->value / 100);
        } else {
            return min($this->value, $originalPrice);
        }
    }

    /**
     * Scope untuk diskon yang sedang aktif
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }
}
