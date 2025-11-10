# Email Verification Setup - Gracias Clinic

## 📧 Fitur Email Verification

Email verification telah ditambahkan untuk memastikan setiap user menggunakan email yang valid dan aktif.

## 🔐 Cara Kerja

1. **Registrasi**: User mendaftar dengan email dan password
2. **Email Terkirim**: Sistem otomatis mengirim email verifikasi
3. **Klik Link**: User mengklik link verifikasi di email
4. **Akun Aktif**: Email terverifikasi, akun siap digunakan

## ⚙️ Setup SMTP Email

Untuk mengirim email verifikasi, Anda perlu mengkonfigurasi SMTP di file `.env`:

### Contoh Menggunakan Gmail:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Gracias Clinic"
```

### Cara Mendapatkan App Password Gmail:

1. Buka **Google Account** → **Security**
2. Aktifkan **2-Step Verification**
3. Buka **App Passwords**
4. Generate password untuk "Mail" → "Other"
5. Copy password dan masukkan ke `MAIL_PASSWORD`

### Alternatif Email Provider:

#### Mailtrap (Development/Testing):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

#### Mailgun:
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.mailgun.org
MAILGUN_SECRET=your-mailgun-api-key
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

## 🚀 Routes yang Dilindungi

Route berikut memerlukan email verification:

- `/reservasi` - Buat reservasi baru
- `/feedback` - Beri feedback
- `/riwayat-reservasi` - Lihat history reservasi

## 🔄 Flow User

### User Baru (Manual Registration):
1. Register → Email verification dikirim
2. Cek email → Klik link verifikasi
3. Email verified → Bisa akses semua fitur

### User Google OAuth:
- Email otomatis terverifikasi (Google sudah verify)
- Langsung bisa akses semua fitur

## 📝 Testing

### Test Email Verification:

1. **Register user baru**:
```bash
# Buka browser
http://localhost/register

# Isi form dan submit
```

2. **Cek log email** (jika development):
```bash
# Lihat di storage/logs/laravel.log
# Atau gunakan Mailtrap untuk testing
```

3. **Resend verification email**:
```bash
# User bisa klik "Kirim Ulang" di halaman verify
```

## 🛠️ Artisan Commands

### Clear cache setelah update:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 📧 Custom Email Template

Email verification menggunakan custom notification di:
- `app/Notifications/CustomVerifyEmail.php`

Template email mencakup:
- ✅ Greeting personal dengan nama user
- ✅ Branding Gracias Clinic
- ✅ Call-to-action button yang jelas
- ✅ Expiry notice (60 menit)
- ✅ Signature profesional

## 🔍 Troubleshooting

### Email tidak terkirim?

1. **Cek konfigurasi .env**
   - Pastikan MAIL_* sudah diisi dengan benar
   - Run `php artisan config:clear`

2. **Cek log error**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Test SMTP connection**
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('test@example.com')->subject('Test');
   });
   ```

### Link verifikasi kadaluarsa?

- User bisa klik "Kirim Ulang Email Verifikasi"
- Link valid selama 60 menit

### User tidak menerima email?

1. Cek folder spam/junk
2. Pastikan email address benar
3. Cek quota SMTP provider

## 🎨 UI/UX Features

✅ Halaman verifikasi modern dengan animasi
✅ Instructions step-by-step yang jelas
✅ Resend email button
✅ Flash messages untuk feedback
✅ Responsive design
✅ Consistent dengan login/register page

## 🔒 Security Features

✅ Signed URLs (tidak bisa di-tamper)
✅ Expiration time (60 menit)
✅ Throttle resend (max 6x per menit)
✅ Auto-verify untuk Google OAuth
✅ Protected routes dengan middleware 'verified'

## 📱 Mobile Friendly

Halaman verify-email responsive dan mobile-friendly dengan:
- Icon sparkles (konsisten dengan brand)
- Clear call-to-action
- Easy navigation
- Smooth animations

---

**Gracias Clinic** - Your Beauty, Our Priority ✨
