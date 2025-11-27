# 📧 Dokumentasi Lengkap Email System - Gracias Clinic

> **Last Updated**: November 18, 2025  
> **Status**: Production Ready (Konfigurasi Sudah Benar)  
> **Problem**: Email tidak berfungsi di VPS production

---

## 📋 Daftar Isi

1. [Ringkasan Sistem Email](#ringkasan-sistem-email)
2. [3 Fitur Email yang Tersedia](#3-fitur-email-yang-tersedia)
3. [Konfigurasi Email](#konfigurasi-email)
4. [Alur Kerja Setiap Fitur](#alur-kerja-setiap-fitur)
5. [File-File yang Terlibat](#file-file-yang-terlibat)
6. [Troubleshooting di VPS](#troubleshooting-di-vps)
7. [Testing Email](#testing-email)
8. [Checklist Debugging](#checklist-debugging)

---

## 🎯 Ringkasan Sistem Email

Aplikasi Gracias Clinic menggunakan **3 fitur email utama**:

| # | Fitur | Trigger | Template | Status Queue |
|---|-------|---------|----------|--------------|
| 1 | **Email Verifikasi** | Saat user register | `CustomVerifyEmail` Notification | ✅ Queued (asynchronous) |
| 2 | **Reset Password** | Saat user forgot password | Laravel default (Breeze) | ❌ Sync (langsung) |
| 3 | **Konfirmasi Reservasi** | Saat admin konfirmasi | `ReservationConfirmed` Mailable | ❌ Sync (langsung) |

---

## 📨 3 Fitur Email yang Tersedia

### 1️⃣ Email Verifikasi (Registration)

**Kapan dikirim?**
- Saat user melakukan registrasi via form `/register`
- **TIDAK dikirim** saat login via Google OAuth (auto-verified)

**Isi Email:**
- Subject: "Verifikasi Email Anda - Gracias Clinic"
- Greeting: "Halo, {nama user}!"
- Pesan: Instruksi verifikasi dengan tombol "Verifikasi Email Saya"
- Link: Signed URL valid 60 menit
- Format: Markdown email (Laravel default styling)

**Cara Kerja:**
```
User Register 
  ↓
User Model created
  ↓
User->sendEmailVerificationNotification() dipanggil
  ↓
CustomVerifyEmail Notification di-dispatch ke queue
  ↓
Email dikirim (jika queue worker running)
  ↓
User klik link di email
  ↓
Route: verify-email/{id}/{hash}
  ↓
CustomVerifyEmailController->__invoke()
  ↓
Email diverifikasi, redirect ke login
```

**File Terlibat:**
- `app/Models/User.php` - Method `sendEmailVerificationNotification()`
- `app/Notifications/CustomVerifyEmail.php` - Notification class (QUEUED)
- `app/Http/Controllers/Auth/CustomVerifyEmailController.php` - Handler verifikasi
- `routes/auth.php` - Route `verification.verify`

---

### 2️⃣ Email Reset Password

**Kapan dikirim?**
- Saat user klik "Forgot Password" di halaman login
- User masukkan email dan submit

**Isi Email:**
- Subject: "Reset Password Notification"
- Isi: Link untuk reset password
- Link: Token valid 60 menit
- Format: Laravel default (Breeze)

**Cara Kerja:**
```
User klik "Forgot Password"
  ↓
Masukkan email di form /forgot-password
  ↓
PasswordResetLinkController->store()
  ↓
Laravel generate token & simpan di DB
  ↓
Email langsung dikirim (SYNC, tidak pakai queue)
  ↓
User klik link di email
  ↓
Route: reset-password/{token}
  ↓
NewPasswordController->create()
  ↓
User masukkan password baru
  ↓
Password berhasil direset
```

**File Terlibat:**
- `app/Http/Controllers/Auth/PasswordResetLinkController.php` - Generate link
- `app/Http/Controllers/Auth/NewPasswordController.php` - Handle reset
- `routes/auth.php` - Routes `password.*`
- Database table: `password_reset_tokens` (otomatis Laravel Breeze)

**⚠️ Catatan Penting:**
- Email reset password **TIDAK menggunakan queue** (dikirim langsung)
- Menggunakan Laravel Breeze default notification
- Token disimpan di database table `password_reset_tokens`

---

### 3️⃣ Email Konfirmasi Reservasi

**Kapan dikirim?**
- Saat **admin** mengkonfirmasi reservasi (ubah status: pending → confirmed)
- Dari halaman admin: `/admin/reservasi`

**Isi Email:**
- Subject: "Reservasi Anda Telah Dikonfirmasi - Gracias_Aesthetic_Clinic"
- Header: "✅ Reservasi Dikonfirmasi!"
- Informasi lengkap: Kode booking, treatment, dokter, tanggal, waktu, harga
- Design: HTML custom dengan gradient, responsive
- CTA Button: "📋 Lihat Detail Reservasi"

**Cara Kerja:**
```
Admin buka /admin/reservasi
  ↓
Admin klik "Konfirmasi" pada reservasi pending
  ↓
POST /admin/reservasi/{id}/konfirmasi
  ↓
ReservationAdminController->konfirmasi()
  ↓
Update status: pending → confirmed
  ↓
Mail::to(customer_email)->send(new ReservationConfirmed($reservation))
  ↓
Email langsung dikirim (SYNC, tidak pakai queue)
  ↓
Customer terima email konfirmasi
```

**File Terlibat:**
- `app/Http/Controllers/Admin/ReservationAdminController.php` - Method `konfirmasi()`
- `app/Mail/ReservationConfirmed.php` - Mailable class
- `resources/views/emails/reservation-confirmed.blade.php` - Email template (HTML)
- `routes/web.php` - Route `admin.reservasi.konfirmasi`

**Error Handling:**
```php
try {
    Mail::to($reservation->customer_email)->send(new ReservationConfirmed($reservation));
    Log::info('Email sent successfully');
    return 'success message';
} catch (\Exception $e) {
    Log::error('Email failed', ['error' => $e->getMessage()]);
    return 'warning message'; // Reservasi tetap dikonfirmasi
}
```

---

## ⚙️ Konfigurasi Email

### File `.env` (Production VPS)

```env
# Email Configuration (Gmail SMTP)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=dhikamahesa45@gmail.com
MAIL_PASSWORD="gwbo zrsx krnr segd"  # App Password (bukan password biasa!)
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="dhikamahesa45@gmail.com"
MAIL_FROM_NAME="Gracias Clinic"

# Queue Configuration (PENTING!)
QUEUE_CONNECTION=sync  # ⚠️ MASALAH ADA DI SINI!
```

### File `config/mail.php`

```php
return [
    'default' => env('MAIL_MAILER', 'smtp'),  // smtp
    
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.mailgun.org'),  // smtp.gmail.com
            'port' => env('MAIL_PORT', 587),  // 587
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),  // tls
            'username' => env('MAIL_USERNAME'),  // dhikamahesa45@gmail.com
            'password' => env('MAIL_PASSWORD'),  // App Password
        ],
    ],
    
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'Example'),
    ],
];
```

### Gmail App Password Setup

**Sudah dikonfigurasi dengan benar:**
- Gmail: `dhikamahesa45@gmail.com`
- App Password: `gwbo zrsx krnr segd` ✅
- 2FA: Harus sudah aktif di akun Gmail

---

## 🔄 Alur Kerja Setiap Fitur

### Diagram Email Verifikasi

```
┌─────────────────────────────────────────────────────────────┐
│                   USER REGISTRATION FLOW                     │
└─────────────────────────────────────────────────────────────┘

1. User Register (POST /register)
   ↓
2. RegisteredUserController->store()
   ├─ Create user in database
   ├─ email_verified_at = NULL
   └─ event(new Registered($user))
       ↓
3. User Model: sendEmailVerificationNotification()
   └─ $this->notify(new CustomVerifyEmail)
       ↓
4. CustomVerifyEmail Notification (QUEUED)
   ├─ implements ShouldQueue ✅
   ├─ via(['mail'])
   └─ toMail() generates:
       ├─ Subject: "Verifikasi Email Anda"
       ├─ Greeting: "Halo, {name}!"
       ├─ Button: "Verifikasi Email Saya"
       └─ Signed URL: /verify-email/{id}/{hash}
           (valid 60 menit)
       ↓
5. [QUEUE] Job added to queue
   ↓
6. ⚠️ Queue Worker must be running!
   $ php artisan queue:work
   ↓
7. Email sent via SMTP (Gmail)
   ↓
8. User receives email → Click button
   ↓
9. GET /verify-email/{id}/{hash}
   ├─ Middleware: signed, throttle:6,1
   └─ CustomVerifyEmailController->__invoke()
       ├─ Validate signed URL
       ├─ Find user by ID
       ├─ Verify hash matches email
       ├─ Check if already verified
       ├─ markEmailAsVerified()
       ├─ event(new Verified($user))
       └─ Redirect to login with success message
```

### Diagram Reset Password

```
┌─────────────────────────────────────────────────────────────┐
│                  PASSWORD RESET FLOW                         │
└─────────────────────────────────────────────────────────────┘

1. User klik "Forgot Password" → GET /forgot-password
   ↓
2. PasswordResetLinkController->create()
   └─ Show form input email
       ↓
3. User submit email → POST /forgot-password
   ↓
4. PasswordResetLinkController->store()
   ├─ Validate email exists in database
   ├─ Generate random token
   ├─ Save to password_reset_tokens table:
   │   ├─ email
   │   ├─ token (hashed)
   │   └─ created_at
   └─ Send email (LANGSUNG, tidak pakai queue)
       ├─ Laravel Default Notification
       ├─ Subject: "Reset Password Notification"
       └─ Link: /reset-password/{token}?email={email}
       ↓
5. Email sent IMMEDIATELY via SMTP
   ↓
6. User receives email → Click link
   ↓
7. GET /reset-password/{token}
   └─ NewPasswordController->create()
       └─ Show form: email + password + password_confirmation
           ↓
8. User submit new password → POST /reset-password
   ↓
9. NewPasswordController->store()
   ├─ Validate token & email
   ├─ Check token not expired (60 minutes)
   ├─ Update user password
   ├─ Delete token from database
   └─ Redirect to login with success
```

### Diagram Konfirmasi Reservasi

```
┌─────────────────────────────────────────────────────────────┐
│              RESERVATION CONFIRMATION FLOW                   │
└─────────────────────────────────────────────────────────────┘

1. Customer create reservation → Status: PENDING
   ↓
2. Admin login → /admin/reservasi
   ↓
3. Admin klik button "Konfirmasi"
   ↓
4. POST /admin/reservasi/{id}/konfirmasi
   ↓
5. ReservationAdminController->konfirmasi()
   ├─ Find reservation by ID
   ├─ Validate status = 'pending'
   ├─ Update status: pending → confirmed
   └─ try {
       │   Mail::to($reservation->customer_email)
       │       ->send(new ReservationConfirmed($reservation))
       │   ↓
       │   Log::info('Email sent')
       │   ↓
       │   Return: "success" message
       │ }
       └─ catch (Exception $e) {
           │   Log::error('Email failed', $e)
           │   ↓
           │   Return: "warning" message
           └─  (Reservasi tetap dikonfirmasi)
       }
       ↓
6. ReservationConfirmed Mailable
   ├─ envelope(): Subject
   ├─ content(): View 'emails.reservation-confirmed'
   └─ attachments(): [] (none)
       ↓
7. Email Template: resources/views/emails/reservation-confirmed.blade.php
   ├─ HTML modern dengan gradient
   ├─ Data: reservation_code, treatment, doctor, date, time, price
   ├─ Button: "Lihat Detail Reservasi" → /riwayat-reservasi
   └─ Footer: Contact info, social links
       ↓
8. Email sent IMMEDIATELY via SMTP (tidak pakai queue)
   ↓
9. Customer receives beautiful HTML email ✉️
```

---

## 📁 File-File yang Terlibat

### 1. Models

#### `app/Models/User.php`
```php
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    
    /**
     * Override method untuk custom email verification
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\CustomVerifyEmail);
    }
}
```
**Penjelasan:**
- `implements MustVerifyEmail` → Aktifkan fitur email verification
- `sendEmailVerificationNotification()` → Custom notification (bukan default Laravel)

---

### 2. Notifications

#### `app/Notifications/CustomVerifyEmail.php`
```php
class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;
    
    public function via($notifiable): array
    {
        return ['mail'];  // Kirim via email
    }
    
    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        
        return (new MailMessage)
            ->subject('Verifikasi Email Anda - Gracias Clinic')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Terima kasih telah mendaftar...')
            ->action('Verifikasi Email Saya', $verificationUrl)
            ->line('Link valid 60 menit');
    }
    
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),  // Valid 60 menit
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
```
**Penjelasan:**
- `implements ShouldQueue` → Email dikirim secara asynchronous (background)
- `temporarySignedRoute()` → Generate signed URL dengan expiry time
- Link format: `/verify-email/{id}/{hash}?expires=xxx&signature=yyy`

---

### 3. Controllers

#### `app/Http/Controllers/Auth/CustomVerifyEmailController.php`
```php
class CustomVerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)
    {
        // 1. Validasi signed URL
        if (!$request->hasValidSignature()) {
            abort(403, 'Link tidak valid atau sudah kadaluarsa.');
        }
        
        // 2. Cari user
        $user = User::findOrFail($id);
        
        // 3. Verifikasi hash
        if (!hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Link tidak valid.');
        }
        
        // 4. Cek sudah verified?
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('info', 'Email sudah terverifikasi.');
        }
        
        // 5. Verifikasi email
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        
        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi!');
    }
}
```
**Penjelasan:**
- `hasValidSignature()` → Cek signature & expiry time
- `markEmailAsVerified()` → Set `email_verified_at = now()`
- Security: Double check dengan hash email

---

#### `app/Http/Controllers/Admin/ReservationAdminController.php`
```php
public function konfirmasi($id)
{
    $reservation = Reservation::findOrFail($id);
    
    if ($reservation->status !== 'pending') {
        return back()->with('info', 'Tidak dapat dikonfirmasi lagi.');
    }
    
    $reservation->update(['status' => 'confirmed']);
    
    // 📧 Kirim email dengan error handling
    try {
        Mail::to($reservation->customer_email)
            ->send(new ReservationConfirmed($reservation));
        
        Log::info('Reservation email sent', [
            'reservation_code' => $reservation->reservation_code,
            'customer_email' => $reservation->customer_email,
        ]);
        
        return back()->with('success', 'Reservasi dikonfirmasi & email terkirim.');
        
    } catch (\Exception $e) {
        Log::error('Email failed', [
            'reservation_code' => $reservation->reservation_code,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        return back()->with('warning', 
            'Reservasi dikonfirmasi, namun email gagal dikirim.');
    }
}
```
**Penjelasan:**
- Error handling: Jika email gagal, reservasi tetap dikonfirmasi
- Logging: Semua aktivitas tercatat di `storage/logs/laravel.log`
- Email dikirim **langsung** (sync), tidak pakai queue

---

### 4. Mailables

#### `app/Mail/ReservationConfirmed.php`
```php
class ReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;
    
    public $reservation;  // Public agar bisa diakses di view
    
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservasi Anda Telah Dikonfirmasi - ' . config('app.name'),
        );
    }
    
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-confirmed',
        );
    }
    
    public function attachments(): array
    {
        return [];  // Tidak ada attachment
    }
}
```
**Penjelasan:**
- `public $reservation` → Data bisa diakses di Blade: `{{ $reservation->reservation_code }}`
- `envelope()` → Email metadata (subject, from, to)
- `content()` → View template

---

### 5. Views

#### `resources/views/emails/reservation-confirmed.blade.php`
**Ukuran:** ~250 baris HTML
**Fitur:**
- Responsive design (mobile-friendly)
- Gradient header dengan animasi
- Reservation card dengan detail lengkap:
  - Kode reservasi (besar & bold)
  - Status badge (confirmed)
  - Treatment, dokter, tanggal, waktu, harga
- Info box dengan reminder (datang 10 menit lebih awal)
- CTA button ke `/riwayat-reservasi`
- Footer dengan contact info & social links

**Data yang digunakan:**
```blade
{{ $reservation->reservation_code }}
{{ $reservation->customer_name }}
{{ $reservation->treatment->name }}
{{ $reservation->doctor->name }}
{{ $reservation->reservation_date }}
{{ $reservation->reservation_time }}
{{ $reservation->total_price }}
```

---

### 6. Routes

#### `routes/auth.php`
```php
// Email Verification Routes
Route::get('verify-email/{id}/{hash}', CustomVerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware('auth')->group(function () {
    // Halaman "Please verify your email"
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');
    
    // Resend verification email
    Route::post('email/verification-notification', 
        [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});
```

#### `routes/web.php`
```php
// Reservation Admin Routes
Route::prefix('admin')->middleware(['auth', 'check.admin'])->group(function () {
    Route::get('/reservasi', [ReservationAdminController::class, 'index'])
        ->name('reservasi.admin');
    
    Route::middleware(['throttle:30,1'])->group(function () {
        Route::post('/reservasi/{id}/konfirmasi', 
            [ReservationAdminController::class, 'konfirmasi'])
            ->name('admin.reservasi.konfirmasi');
    });
});
```

---

### 7. Middleware

#### Middleware yang Digunakan

**1. `signed` Middleware**
```php
// Validasi signed URL (untuk email verification)
if (!$request->hasValidSignature()) {
    abort(403);
}
```
- Digunakan di: `verification.verify` route
- Fungsi: Validasi signature & expiry time URL
- Protect dari: URL manipulation, expired links

**2. `throttle:6,1` Middleware**
```php
// Limit 6 requests per 1 minute
Route::middleware(['throttle:6,1'])
```
- Digunakan di: Verification routes, resend email
- Fungsi: Prevent spam email
- Limit: 6 requests per menit per IP

**3. `verified` Middleware**
```php
// Hanya user dengan email verified yang bisa akses
Route::middleware(['auth', 'verified'])
```
- Digunakan di: Reservation routes
- Fungsi: Force email verification before booking
- Redirect ke: `/verify-email` jika belum verified

---

### 8. Database

#### Tables yang Terlibat

**1. `users` table**
```sql
email VARCHAR(255) UNIQUE
email_verified_at TIMESTAMP NULL  -- NULL = belum verified
```

**2. `password_reset_tokens` table** (Laravel Breeze default)
```sql
email VARCHAR(255) PRIMARY KEY
token VARCHAR(255)  -- Hashed token
created_at TIMESTAMP
```
- Token valid: 60 menit (default)
- Auto-cleanup: Token lama dihapus otomatis

**3. `reservations` table**
```sql
customer_email VARCHAR(255)  -- Email tujuan konfirmasi
status ENUM('pending', 'confirmed', 'completed', 'cancelled')
```

---

## 🐛 Troubleshooting di VPS

### ❌ MASALAH UTAMA: Email Tidak Terkirim

**Gejala:**
- User register → Tidak terima email verifikasi
- Admin konfirmasi reservasi → Customer tidak terima email
- Forgot password → Tidak terima email reset

---

### 🔍 ROOT CAUSE ANALYSIS

#### 1. **Email Verifikasi Tidak Terkirim**

**Penyebab:** `QUEUE_CONNECTION=sync` + Notification implements `ShouldQueue`

**Penjelasan:**
```php
// CustomVerifyEmail.php
class CustomVerifyEmail extends Notification implements ShouldQueue
{
    // ^^ Ini artinya email HARUS diproses via queue
}
```

**Config di `.env`:**
```env
QUEUE_CONNECTION=sync  # ❌ MASALAH DI SINI!
```

**Apa yang terjadi:**
- `ShouldQueue` interface membuat notification masuk ke queue
- `QUEUE_CONNECTION=sync` artinya queue diproses synchronously (langsung)
- **TAPI** dengan `sync`, tidak ada queue worker yang running!
- Email masuk queue → Tidak ada worker → **Email tidak pernah dikirim**

**Solusi:**

**Opsi A: Ubah ke Database Queue (Recommended)**
```env
QUEUE_CONNECTION=database
```
Lalu jalankan queue worker di VPS:
```bash
# Install supervisor untuk auto-restart
sudo apt install supervisor

# Buat config supervisor
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

Isi file:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/graciasclinic.web.id/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/graciasclinic.web.id/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Reload supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*

# Check status
sudo supervisorctl status
```

**Opsi B: Hapus ShouldQueue (Quick Fix)**

Edit `app/Notifications/CustomVerifyEmail.php`:
```php
// SEBELUM (dengan queue):
class CustomVerifyEmail extends Notification implements ShouldQueue
{
    use Queueable;
    // ...
}

// SESUDAH (tanpa queue, langsung kirim):
class CustomVerifyEmail extends Notification  // Hapus implements ShouldQueue
{
    // use Queueable;  // Hapus atau comment
    // ...
}
```

**Trade-off:**
- ✅ Email langsung terkirim tanpa perlu queue worker
- ❌ User harus tunggu email terkirim sebelum page loading selesai (slower UX)

---

#### 2. **Email Reset Password Tidak Terkirim**

**Penyebab Potensial:**

**A. Gmail SMTP Blocked**
- Gmail mendeteksi login dari server baru (VPS)
- Perlu approval manual

**Cara Check:**
1. Login ke Gmail: `dhikamahesa45@gmail.com`
2. Cek inbox untuk email dari Google: "Critical security alert"
3. Atau cek: https://myaccount.google.com/notifications

**Solusi:**
- Buka email dari Google → Klik "Yes, it was me"
- Atau aktifkan "Less secure app access" (tidak recommended)
- **ATAU** regenerate App Password baru

---

**B. Firewall Block Port 587**

VPS firewall mungkin block outbound connection ke port 587 (SMTP)

**Cara Check:**
```bash
# SSH ke VPS, lalu test koneksi ke Gmail SMTP
telnet smtp.gmail.com 587

# Jika berhasil connect:
# 220 smtp.google.com ESMTP...

# Jika gagal:
# Connection refused / timeout
```

**Solusi:**
```bash
# Allow outbound ke port 587
sudo ufw allow out 587/tcp

# Atau disable firewall untuk testing
sudo ufw disable
```

---

**C. Wrong Credentials**

App Password salah atau expired

**Cara Check:**
1. Login ke Google Account: https://myaccount.google.com/security
2. Scroll ke "2-Step Verification" → Harus ON ✅
3. Klik "App passwords"
4. Generate password baru untuk "Mail" app

**Solusi:**
```env
# Update .env dengan password baru
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"  # Tanpa spasi!
```

Lalu:
```bash
php artisan config:clear
php artisan cache:clear
```

---

#### 3. **Email Konfirmasi Reservasi Tidak Terkirim**

**Penyebab Potensial:**

**A. Exception Tidak Terlihat**

Email gagal dikirim tapi exception di-catch, admin tidak tahu

**Cara Check:**
```bash
# SSH ke VPS, check log
tail -f storage/logs/laravel.log

# Cari error terkait email:
grep -i "email failed" storage/logs/laravel.log
grep -i "failed to send" storage/logs/laravel.log
grep -i "smtp" storage/logs/laravel.log
```

**Apa yang dicari:**
```
[2025-11-18 10:30:45] local.ERROR: Failed to send reservation confirmation email  
{"reservation_code":"GRS-20251118-ABC123","error":"Connection refused"}
```

---

**B. Laravel di Production Mode**

Saat `APP_DEBUG=false`, error detail tidak ditampilkan

**Cara Check:**
```env
# Temporary enable debug untuk testing
APP_DEBUG=true
APP_ENV=local
```

**PENTING:** Jangan lupa set kembali setelah testing:
```env
APP_DEBUG=false
APP_ENV=production
```

---

## 🧪 Testing Email

### Test 1: Test SMTP Connection (Manual)

```bash
# SSH ke VPS
ssh user@graciasclinic.web.id

# Test koneksi ke Gmail SMTP
telnet smtp.gmail.com 587

# Expected output:
# Trying 142.250.153.108...
# Connected to smtp.gmail.com.
# 220 smtp.google.com ESMTP...

# Ketik:
EHLO graciasclinic.web.id
# (Tekan Enter)

# Expected: List of SMTP capabilities
# 250-smtp.google.com at your service
# 250-STARTTLS
# 250-AUTH LOGIN PLAIN
# ...

# Ketik QUIT untuk keluar
```

**Jika gagal connect:**
- Firewall block port 587
- DNS issue
- ISP block SMTP

---

### Test 2: Test Email via Tinker

```bash
# SSH ke VPS
cd /var/www/graciasclinic.web.id
php artisan tinker
```

```php
// Test kirim email sederhana
Mail::raw('Test email from Gracias Clinic VPS', function($message) {
    $message->to('your-test-email@gmail.com')
            ->subject('Test Email Production');
});

// Check output
// Expected: null (success)
// Jika ada error, akan muncul exception message
```

**Jika berhasil:**
- Check inbox email tujuan
- Check spam folder juga!

**Jika gagal:**
- Lihat error message
- Check `storage/logs/laravel.log`

---

### Test 3: Test Email Verifikasi

```bash
php artisan tinker
```

```php
// Cari user test
$user = User::where('email', 'test@example.com')->first();

// Kirim email verifikasi manual
$user->sendEmailVerificationNotification();

// Check apakah masuk queue (jika pakai queue)
DB::table('jobs')->count();  // Jika ada job baru = masuk queue

// Process queue manual (jika pakai database queue)
Artisan::call('queue:work', ['--once' => true]);
```

---

### Test 4: Test Email Reset Password

**Via Browser:**
1. Buka: `https://graciasclinic.web.id/forgot-password`
2. Masukkan email registered user
3. Submit
4. Check inbox email

**Via Tinker:**
```php
use Illuminate\Support\Facades\Password;

Password::sendResetLink(['email' => 'test@example.com']);

// Expected output:
// "passwords.sent"  (success)
// "passwords.user"   (email not found)
// "passwords.throttled"  (too many requests)
```

---

### Test 5: Test Email Konfirmasi Reservasi

**Cara 1: Via Admin Dashboard**
1. Login sebagai admin: `https://graciasclinic.web.id/login`
2. Buka: `/admin/reservasi`
3. Cari reservasi dengan status "pending"
4. Klik "Konfirmasi"
5. Check:
   - Flash message: Success atau Warning?
   - Log file: `storage/logs/laravel.log`
   - Inbox customer email

**Cara 2: Via Tinker**
```php
use App\Models\Reservation;
use App\Mail\ReservationConfirmed;
use Illuminate\Support\Facades\Mail;

// Cari reservasi pending
$reservation = Reservation::where('status', 'pending')->first();

// Test send email
Mail::to($reservation->customer_email)
    ->send(new ReservationConfirmed($reservation));

// Check untuk exception
```

---

## ✅ Checklist Debugging

### Pre-Flight Checklist (Sebelum Deploy)

- [ ] `.env` sudah dikonfigurasi dengan benar
  - [ ] `MAIL_MAILER=smtp`
  - [ ] `MAIL_HOST=smtp.gmail.com`
  - [ ] `MAIL_PORT=587`
  - [ ] `MAIL_USERNAME=dhikamahesa45@gmail.com`
  - [ ] `MAIL_PASSWORD="gwbo zrsx krnr segd"`
  - [ ] `MAIL_ENCRYPTION=tls`
  - [ ] `MAIL_FROM_ADDRESS` dan `MAIL_FROM_NAME` terisi

- [ ] Gmail App Password sudah dibuat
  - [ ] 2FA aktif di Google Account
  - [ ] App Password generated untuk "Mail"

- [ ] Queue configuration
  - [ ] Pilih salah satu:
    - [ ] `QUEUE_CONNECTION=database` + Setup supervisor
    - [ ] Atau hapus `ShouldQueue` dari CustomVerifyEmail

- [ ] Firewall sudah allow port 587
  ```bash
  sudo ufw allow out 587/tcp
  ```

- [ ] Laravel cache sudah di-clear
  ```bash
  php artisan config:clear
  php artisan cache:clear
  php artisan route:clear
  php artisan view:clear
  ```

---

### Debugging Checklist (Saat Email Tidak Terkirim)

#### Step 1: Check Configuration

```bash
# SSH ke VPS
cd /var/www/graciasclinic.web.id

# Check .env
cat .env | grep MAIL

# Expected output:
# MAIL_MAILER=smtp
# MAIL_HOST=smtp.gmail.com
# MAIL_PORT=587
# MAIL_USERNAME=dhikamahesa45@gmail.com
# MAIL_PASSWORD="gwbo zrsx krnr segd"
# MAIL_ENCRYPTION=tls
# MAIL_FROM_ADDRESS="dhikamahesa45@gmail.com"
# MAIL_FROM_NAME="Gracias Clinic"
```

✅ **All values must match!**

---

#### Step 2: Check SMTP Connection

```bash
# Test telnet ke Gmail SMTP
telnet smtp.gmail.com 587

# Expected:
# Connected to smtp.gmail.com.
# 220 smtp.google.com ESMTP...
```

❌ **If failed:**
- Firewall issue → `sudo ufw allow out 587/tcp`
- DNS issue → `ping smtp.gmail.com`
- ISP blocking → Contact ISP or use VPN

---

#### Step 3: Check Queue (If Using)

```bash
# Check queue connection
cat .env | grep QUEUE_CONNECTION

# If QUEUE_CONNECTION=database
# Check queue worker status
sudo supervisorctl status

# Expected:
# laravel-worker:laravel-worker_00   RUNNING   pid 12345, uptime 1:23:45

# Check jobs table
php artisan tinker
>>> DB::table('jobs')->count()
=> 5  // Ada 5 job pending

# Process manually
>>> Artisan::call('queue:work', ['--once' => true])
```

❌ **If queue worker not running:**
```bash
sudo supervisorctl start laravel-worker:*
```

---

#### Step 4: Check Logs

```bash
# Real-time log monitoring
tail -f storage/logs/laravel.log

# Trigger email (e.g., konfirmasi reservasi via browser)
# Watch log output

# Search for errors
grep -i "error" storage/logs/laravel.log | tail -20
grep -i "exception" storage/logs/laravel.log | tail -20
grep -i "failed" storage/logs/laravel.log | tail -20
```

**Common Errors:**

1. **"Connection could not be established with host smtp.gmail.com"**
   - Firewall blocking port 587
   - Solution: `sudo ufw allow out 587/tcp`

2. **"Invalid credentials"**
   - Wrong App Password
   - Solution: Regenerate App Password di Google Account

3. **"Too many login attempts"**
   - Gmail temporarily blocked
   - Solution: Wait 1 hour, atau approve device di Gmail

4. **"530 5.7.0 Must issue a STARTTLS command first"**
   - Wrong encryption setting
   - Solution: `MAIL_ENCRYPTION=tls` (bukan ssl)

---

#### Step 5: Test Email Manually

```bash
php artisan tinker
```

```php
// Test 1: Raw email
Mail::raw('Test from VPS', function($msg) {
    $msg->to('your-email@gmail.com')->subject('Test');
});

// Test 2: Mailable
use App\Models\Reservation;
use App\Mail\ReservationConfirmed;

$r = Reservation::first();
Mail::to('your-email@gmail.com')->send(new ReservationConfirmed($r));

// Test 3: Notification
use App\Models\User;
use App\Notifications\CustomVerifyEmail;

$u = User::first();
$u->notify(new CustomVerifyEmail);
```

**Check inbox:**
- Main inbox
- Spam folder
- Promotions tab (Gmail)

---

#### Step 6: Check Google Account

1. Login ke Gmail: https://mail.google.com
2. Check "Critical security alert" emails
3. Approve any blocked sign-in attempts

4. Check App Passwords: https://myaccount.google.com/apppasswords
5. Verify App Password still valid

6. Check Activity: https://myaccount.google.com/notifications
7. Look for blocked sign-in attempts from VPS IP

---

## 🚀 Recommended Production Setup

### Setup 1: Database Queue + Supervisor (BEST)

**Advantages:**
- ✅ Email dikirim di background (fast UX)
- ✅ Auto-retry jika gagal
- ✅ Bisa monitor via logs
- ✅ Auto-restart jika crash

**Steps:**

1. **Update `.env`:**
```env
QUEUE_CONNECTION=database
```

2. **Create jobs table:**
```bash
php artisan queue:table
php artisan migrate
```

3. **Install Supervisor:**
```bash
sudo apt update
sudo apt install supervisor
```

4. **Create worker config:**
```bash
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

Paste:
```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/graciasclinic.web.id/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/graciasclinic.web.id/storage/logs/worker.log
stopwaitsecs=3600
```

5. **Start worker:**
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

6. **Check status:**
```bash
sudo supervisorctl status

# Expected:
# laravel-worker:laravel-worker_00   RUNNING   pid 1234, uptime 0:01:23
```

7. **Monitor logs:**
```bash
tail -f storage/logs/worker.log
```

8. **Restart worker (setelah code update):**
```bash
php artisan queue:restart
# atau
sudo supervisorctl restart laravel-worker:*
```

---

### Setup 2: Sync (No Queue) - SIMPLE

**Advantages:**
- ✅ Simple setup (no worker needed)
- ✅ Email langsung terkirim

**Disadvantages:**
- ❌ Slower UX (user tunggu email terkirim)
- ❌ Jika email gagal, user lihat error

**Steps:**

1. **Update `.env`:**
```env
QUEUE_CONNECTION=sync
```

2. **Remove ShouldQueue:**

Edit `app/Notifications/CustomVerifyEmail.php`:
```php
// Remove implements ShouldQueue
class CustomVerifyEmail extends Notification  // ← Remove: implements ShouldQueue
{
    // Remove use Queueable;
    
    public function via($notifiable): array
    {
        return ['mail'];
    }
    
    // ... rest same
}
```

3. **Clear cache:**
```bash
php artisan config:clear
php artisan cache:clear
```

Done! Email akan terkirim langsung.

---

## 📊 Monitoring & Maintenance

### 1. Monitor Queue (If Using Database Queue)

```bash
# Check pending jobs
php artisan queue:monitor

# Check failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear all failed jobs
php artisan queue:flush
```

---

### 2. Monitor Email Logs

```bash
# Email sent successfully
grep "Email sent" storage/logs/laravel.log

# Email failed
grep "Email failed" storage/logs/laravel.log

# Count emails sent today
grep "$(date +%Y-%m-%d)" storage/logs/laravel.log | grep "Email sent" | wc -l
```

---

### 3. Monitor Gmail Quota

Gmail SMTP has limits:
- **Free Gmail**: 500 emails/day
- **Google Workspace**: 2,000 emails/day

**Solution if hit limit:**
- Upgrade to Google Workspace
- Or use dedicated email service (SendGrid, Mailgun, Amazon SES)

---

## 🔒 Security Best Practices

### 1. Never Commit .env

```bash
# .gitignore harus include:
.env
.env.backup
.env.production
```

### 2. Use App Password (Not Real Password)

✅ `MAIL_PASSWORD="gwbo zrsx krnr segd"` (App Password)  
❌ `MAIL_PASSWORD="myRealGmailPassword123"` (NEVER!)

### 3. Rate Limiting

Sudah implemented:
```php
// Limit resend verification email
Route::post('email/verification-notification', ...)
    ->middleware('throttle:6,1');  // 6 per minute

// Limit admin konfirmasi
Route::post('/reservasi/{id}/konfirmasi', ...)
    ->middleware(['throttle:30,1']);  // 30 per minute
```

### 4. Signed URLs

Email verification menggunakan signed URL:
```php
URL::temporarySignedRoute('verification.verify', 
    Carbon::now()->addMinutes(60),  // Valid 60 menit saja
    ['id' => $user->id, 'hash' => sha1($user->email)]
);
```

Protect dari:
- URL manipulation
- Replay attacks
- Expired links

---

## 📞 Support & Contact

Jika semua troubleshooting gagal, kemungkinan:

1. **ISP blocking SMTP** → Contact ISP atau gunakan VPN
2. **Gmail policy violation** → Switch ke email service lain (SendGrid, Mailgun)
3. **VPS provider blocking** → Contact VPS support

**Alternative Email Services (Recommended for Production):**

| Service | Free Tier | Price | Features |
|---------|-----------|-------|----------|
| **SendGrid** | 100 emails/day | $19.95/mo (40k) | Good deliverability |
| **Mailgun** | 5,000 emails/mo | $35/mo (50k) | Developer-friendly |
| **Amazon SES** | 62,000 emails/mo* | $0.10 per 1,000 | Cheapest, scalable |
| **Postmark** | No free tier | $15/mo (10k) | Transactional focus |

*Free with AWS Free Tier from EC2

---

## 🎯 Quick Fix Summary

### If Email Verifikasi Tidak Terkirim:

**Quick Fix (5 menit):**
```bash
# 1. Edit Notification
nano app/Notifications/CustomVerifyEmail.php

# 2. Remove: implements ShouldQueue
# 3. Comment: use Queueable;

# 4. Clear cache
php artisan config:clear
php artisan cache:clear

# 5. Test
php artisan tinker
>>> User::first()->sendEmailVerificationNotification()
```

**Proper Fix (30 menit):**
```bash
# 1. Setup database queue
php artisan queue:table
php artisan migrate

# 2. Update .env
QUEUE_CONNECTION=database

# 3. Setup supervisor (lihat section di atas)

# 4. Start worker
sudo supervisorctl start laravel-worker:*
```

---

### If Email Reset Password Tidak Terkirim:

```bash
# 1. Test SMTP connection
telnet smtp.gmail.com 587

# 2. If failed, check firewall
sudo ufw allow out 587/tcp

# 3. Test via tinker
php artisan tinker
>>> Password::sendResetLink(['email' => 'test@example.com'])

# 4. Check logs
tail -f storage/logs/laravel.log
```

---

### If Email Konfirmasi Reservasi Tidak Terkirim:

```bash
# 1. Enable debug mode temporary
# Edit .env:
APP_DEBUG=true

# 2. Clear cache
php artisan config:clear

# 3. Konfirmasi reservasi via browser
# 4. Check error message di page

# 5. Check logs
tail -f storage/logs/laravel.log

# 6. Disable debug after testing
APP_DEBUG=false
```

---

## 📚 Additional Resources

- [Laravel Mail Documentation](https://laravel.com/docs/10.x/mail)
- [Laravel Queue Documentation](https://laravel.com/docs/10.x/queues)
- [Laravel Notifications](https://laravel.com/docs/10.x/notifications)
- [Gmail SMTP Settings](https://support.google.com/mail/answer/7126229)
- [Google App Passwords](https://support.google.com/accounts/answer/185833)
- [Supervisor Documentation](http://supervisord.org/configuration.html)

---

**© 2025 Gracias Aesthetic Clinic**  
**Dokumentasi dibuat:** November 18, 2025  
**Untuk:** Production VPS Deployment Troubleshooting
