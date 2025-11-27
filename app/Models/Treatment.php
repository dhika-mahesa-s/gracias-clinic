<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'image',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Relationship dengan Discount
     */
    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_treatment')
                    ->withTimestamps();
    }

    /**
     * Get active discount untuk treatment ini
     */
    public function getActiveDiscount()
    {
        return $this->discounts()
                    ->active()
                    ->first();
    }

    /**
     * Get discounted price
     */
    public function getDiscountedPrice()
    {
        $discount = $this->getActiveDiscount();
        
        if ($discount) {
            return $discount->calculateDiscountedPrice($this->price);
        }
        
        return $this->price;
    }

    /**
     * Check if treatment has active discount
     */
    public function hasActiveDiscount()
    {
        return $this->getActiveDiscount() !== null;
    }

    /**
     * Get discount percentage (untuk display badge)
     */
    public function getDiscountPercentage()
    {
        $discount = $this->getActiveDiscount();
        
        if (!$discount) {
            return null;
        }

        if ($discount->type === 'percentage') {
            return $discount->value;
        } else {
            // Hitung persentase dari fixed amount
            return round(($discount->value / $this->price) * 100, 0);
        }
    }

    /**
     * Get discount amount (nominal potongan)
     */
    public function getDiscountAmount()
    {
        $discount = $this->getActiveDiscount();
        
        if (!$discount) {
            return 0;
        }

        return $discount->getDiscountAmount($this->price);
    }

    /**
     * Get formatted original price
     */
    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted discounted price
     */
    public function getFormattedDiscountedPrice()
    {
        return 'Rp ' . number_format($this->getDiscountedPrice(), 0, ',', '.');
    }
}
