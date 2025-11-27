# 🎯 Discount Feature - Implementation Guide

## 📊 Database Structure

### **Tabel: `discounts`**
```sql
- id (PK)
- name (string) - Nama event diskon (e.g., "11.11 Sale", "Black Friday")
- description (text, nullable)
- type (enum: 'percentage', 'fixed') - Tipe diskon
- value (decimal) - Nilai diskon (% atau nominal Rp)
- start_date (datetime) - Tanggal mulai
- end_date (datetime) - Tanggal berakhir
- is_active (boolean) - Status aktif manual
```

### **Tabel: `treatments`**
```sql
- id (PK)
- name (string)
- description (text)
- price (decimal)
- duration (integer) - dalam menit
- image (string)
```

### **Tabel Pivot: `discount_treatment`**
```sql
- id (PK)
- discount_id (FK → discounts.id)
- treatment_id (FK → treatments.id)
```

### **Relasi:**
- Many-to-Many: Treatment ↔ Discount
- Satu treatment bisa punya banyak diskon (tapi hanya 1 aktif pada saat bersamaan)
- Satu diskon bisa diterapkan ke banyak treatment

---

## 🔧 Logic Landing Page (UPDATED)

### **LandingPageController@index**

```php
/**
 * Prioritas tampilan:
 * 1. Treatment dengan diskon aktif (max 4)
 * 2. Jika < 4, lengkapi dengan treatment tanpa diskon
 */

// Query 1: Treatment dengan diskon aktif
$treatmentsWithDiscount = Treatment::with('discounts')
    ->whereHas('discounts', function($query) {
        $query->active(); // is_active = true && dalam periode
    })
    ->latest()
    ->take(4)
    ->get();

// Query 2: Treatment tanpa diskon (jika perlu melengkapi)
if ($treatmentsWithDiscount->count() < 4) {
    $remaining = 4 - $treatmentsWithDiscount->count();
    
    $treatmentsWithoutDiscount = Treatment::with('discounts')
        ->whereDoesntHave('discounts', function($query) {
            $query->active();
        })
        ->latest()
        ->take($remaining)
        ->get();
    
    $treatments = $treatmentsWithDiscount->merge($treatmentsWithoutDiscount);
}
```

---

## 🎨 View - Menampilkan Treatment dengan Diskon

### **Contoh Blade Template:**

```blade
@foreach($treatments as $treatment)
<div class="treatment-card">
    {{-- Image --}}
    <img src="{{ asset('storage/' . $treatment->image) }}" alt="{{ $treatment->name }}">
    
    {{-- Discount Badge (jika ada) --}}
    @if($treatment->hasActiveDiscount())
        <div class="discount-badge">
            -{{ $treatment->getDiscountPercentage() }}%
        </div>
    @endif
    
    {{-- Treatment Info --}}
    <h3>{{ $treatment->name }}</h3>
    <p>{{ Str::limit($treatment->description, 100) }}</p>
    
    {{-- Price --}}
    <div class="price-section">
        @if($treatment->hasActiveDiscount())
            {{-- Original Price (dicoret) --}}
            <span class="original-price">
                {{ $treatment->getFormattedPrice() }}
            </span>
            
            {{-- Discounted Price --}}
            <span class="discounted-price">
                {{ $treatment->getFormattedDiscountedPrice() }}
            </span>
            
            {{-- Hemat Info --}}
            <small class="save-info">
                Hemat Rp {{ number_format($treatment->getDiscountAmount(), 0, ',', '.') }}
            </small>
        @else
            {{-- Normal Price --}}
            <span class="normal-price">
                {{ $treatment->getFormattedPrice() }}
            </span>
        @endif
    </div>
    
    {{-- Duration --}}
    <p class="duration">
        <i class="fas fa-clock"></i> {{ $treatment->duration }} menit
    </p>
    
    {{-- CTA Button --}}
    <a href="{{ route('reservations.create', $treatment->id) }}" class="btn-book">
        Book Now
    </a>
</div>
@endforeach
```

---

## 💡 Model Methods - Treatment

### **Available Methods:**

```php
// Check apakah ada diskon aktif
$treatment->hasActiveDiscount() // true/false

// Get diskon aktif (object)
$treatment->getActiveDiscount() // Discount object atau null

// Get harga setelah diskon
$treatment->getDiscountedPrice() // 850000 (dari 1000000)

// Get persentase diskon (untuk badge)
$treatment->getDiscountPercentage() // 15 (berarti 15%)

// Get nominal potongan
$treatment->getDiscountAmount() // 150000

// Get formatted price
$treatment->getFormattedPrice() // "Rp 1.000.000"
$treatment->getFormattedDiscountedPrice() // "Rp 850.000"
```

---

## 📝 Contoh Data

### **Skenario 1: Diskon Percentage (15%)**

```php
Discount:
- name: "11.11 Flash Sale"
- type: "percentage"
- value: 15
- start_date: "2025-11-11 00:00:00"
- end_date: "2025-11-11 23:59:59"
- is_active: true

Treatment:
- name: "Facial Treatment"
- price: 1000000

Result:
- hasActiveDiscount(): true
- getDiscountPercentage(): 15
- getDiscountAmount(): 150000
- getDiscountedPrice(): 850000
- Display: "Rp 1.000.000" → "Rp 850.000" (Hemat Rp 150.000)
```

### **Skenario 2: Diskon Fixed Amount (Rp 200.000)**

```php
Discount:
- name: "Grand Opening Promo"
- type: "fixed"
- value: 200000
- start_date: "2025-11-01 00:00:00"
- end_date: "2025-11-30 23:59:59"
- is_active: true

Treatment:
- name: "Body Massage"
- price: 800000

Result:
- hasActiveDiscount(): true
- getDiscountPercentage(): 25 (dihitung: 200000/800000 * 100)
- getDiscountAmount(): 200000
- getDiscountedPrice(): 600000
- Display: "Rp 800.000" → "Rp 600.000" (Hemat Rp 200.000)
```

---

## 🎯 Query Logic Explanation

### **Scope: `active()`**

```php
public function scopeActive($query)
{
    $now = Carbon::now();
    return $query->where('is_active', true)
                ->where('start_date', '<=', $now)
                ->where('end_date', '>=', $now);
}
```

Diskon dianggap aktif jika:
- ✅ `is_active = true`
- ✅ Tanggal sekarang ≥ `start_date`
- ✅ Tanggal sekarang ≤ `end_date`

### **whereHas vs whereDoesntHave**

```php
// Ambil treatment yang PUNYA diskon aktif
Treatment::whereHas('discounts', function($query) {
    $query->active();
})

// Ambil treatment yang TIDAK PUNYA diskon aktif
Treatment::whereDoesntHave('discounts', function($query) {
    $query->active();
})
```

---

## 🧪 Testing

### **Test Case 1: Ada 3 treatment dengan diskon aktif**

```
Result: Tampilkan 3 treatment diskon + 1 treatment tanpa diskon
Total: 4 treatment
```

### **Test Case 2: Ada 5 treatment dengan diskon aktif**

```
Result: Tampilkan 4 treatment dengan diskon saja (prioritas terbaru)
Total: 4 treatment
```

### **Test Case 3: Tidak ada treatment dengan diskon aktif**

```
Result: Tampilkan 4 treatment tanpa diskon (latest)
Total: 4 treatment
```

### **Test Case 4: Hanya 2 treatment total di database**

```
Result: Tampilkan 2 treatment saja
Total: 2 treatment
```

---

## 🎨 CSS Example (Discount Badge & Price Styling)

```css
/* Discount Badge */
.discount-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
    box-shadow: 0 2px 8px rgba(245, 87, 108, 0.4);
}

/* Price Section */
.price-section {
    display: flex;
    flex-direction: column;
    gap: 5px;
    margin: 15px 0;
}

/* Original Price (strikethrough) */
.original-price {
    color: #999;
    text-decoration: line-through;
    font-size: 14px;
}

/* Discounted Price */
.discounted-price {
    color: #f5576c;
    font-size: 20px;
    font-weight: bold;
}

/* Save Info */
.save-info {
    color: #4caf50;
    font-size: 12px;
    font-weight: 500;
}

/* Normal Price */
.normal-price {
    color: #333;
    font-size: 20px;
    font-weight: bold;
}
```

---

## 📌 Admin Panel - Cara Buat Diskon

### **Step 1: Create Discount**

```php
$discount = Discount::create([
    'name' => '11.11 Flash Sale',
    'description' => 'Diskon special 11 November',
    'type' => 'percentage', // atau 'fixed'
    'value' => 15, // 15% atau Rp 15000
    'start_date' => '2025-11-11 00:00:00',
    'end_date' => '2025-11-11 23:59:59',
    'is_active' => true,
]);
```

### **Step 2: Attach ke Treatment**

```php
// Attach ke 1 treatment
$discount->treatments()->attach($treatmentId);

// Attach ke multiple treatments
$discount->treatments()->attach([1, 2, 3, 4]);

// Atau dari sisi Treatment
$treatment->discounts()->attach($discountId);
```

### **Step 3: Detach (hapus diskon dari treatment)**

```php
// Detach 1 treatment
$discount->treatments()->detach($treatmentId);

// Detach semua treatments
$discount->treatments()->detach();
```

---

## 🚀 Deployment Checklist

- [x] Migration `create_discounts_table` dijalankan
- [x] Migration `create_discount_treatment_table` dijalankan
- [x] Model `Discount` dan `Treatment` sudah ada relasi
- [x] Scope `active()` di Model Discount sudah berfungsi
- [x] LandingPageController diupdate untuk prioritas diskon
- [x] View diupdate untuk tampilkan badge & price diskon
- [x] CSS styling untuk discount badge & strikethrough price
- [x] Test dengan dummy data

---

## 📖 Best Practices

1. ✅ **Selalu gunakan eager loading** `with('discounts')` untuk avoid N+1 query
2. ✅ **Cache query** jika traffic tinggi (cache 5-10 menit)
3. ✅ **Validate date range** saat create/update diskon
4. ✅ **Auto-deactivate expired discounts** (gunakan scheduled command)
5. ✅ **Limit 1 active discount per treatment** (business rule)
6. ✅ **Log discount usage** untuk analytics

---

## 🔄 Auto-Deactivate Expired Discounts (Optional)

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Jalankan setiap jam
    $schedule->call(function () {
        Discount::where('is_active', true)
                ->where('end_date', '<', now())
                ->update(['is_active' => false]);
    })->hourly();
}
```

---

**Created:** November 27, 2025
**Feature:** Treatment Discount System
**Status:** ✅ Implemented & Ready to Use
