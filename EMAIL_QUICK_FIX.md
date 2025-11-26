# 📧 Email System - Quick Reference

## 🚨 MASALAH UTAMA

**Email tidak terkirim di VPS production karena:**

### 1. Email Verifikasi ❌
**Root Cause:** `CustomVerifyEmail` menggunakan `ShouldQueue` tetapi `QUEUE_CONNECTION=sync` tanpa queue worker

**Quick Fix:**
```bash
# Opsi A: Hapus ShouldQueue (paling cepat)
nano app/Notifications/CustomVerifyEmail.php
# Hapus: implements ShouldQueue
# Hapus/comment: use Queueable;

php artisan config:clear
php artisan cache:clear
```

**Atau Opsi B: Setup database queue (recommended)**
```bash
# Edit .env
QUEUE_CONNECTION=database

# Setup supervisor (lihat EMAIL_SYSTEM_DOCUMENTATION.md section "Setup 1")
```

---

### 2. Email Reset Password & Konfirmasi Reservasi ❌
**Root Cause:** Kemungkinan Gmail SMTP connection issue

**Quick Check:**
```bash
# Test SMTP connection
telnet smtp.gmail.com 587

# Jika gagal, allow firewall
sudo ufw allow out 587/tcp

# Test via tinker
php artisan tinker
>>> Mail::raw('Test', fn($m)=>$m->to('test@gmail.com')->subject('Test'))
```

---

## ✅ SOLUSI CEPAT (5 MENIT)

### Di VPS, jalankan script otomatis:

```bash
# 1. Upload file email-fix-vps.sh ke VPS
# 2. Berikan permission
chmod +x email-fix-vps.sh

# 3. Jalankan
sudo bash email-fix-vps.sh
```

Script akan otomatis:
- ✅ Check konfigurasi .env
- ✅ Test koneksi SMTP
- ✅ Check firewall
- ✅ Fix queue configuration
- ✅ Clear cache
- ✅ Fix permissions
- ✅ Test kirim email

---

## 📋 MANUAL FIX (Step by Step)

### Fix 1: Email Verifikasi

```bash
# Edit notification file
nano app/Notifications/CustomVerifyEmail.php

# Ubah baris ini:
class CustomVerifyEmail extends Notification implements ShouldQueue
# Menjadi:
class CustomVerifyEmail extends Notification

# Dan comment baris ini:
use Queueable;
# Menjadi:
// use Queueable;

# Save, lalu:
php artisan config:clear
php artisan cache:clear
```

---

### Fix 2: SMTP Connection

```bash
# 1. Test koneksi
telnet smtp.gmail.com 587

# 2. Jika gagal, allow port 587
sudo ufw allow out 587/tcp

# 3. Test lagi
telnet smtp.gmail.com 587

# 4. Jika masih gagal, check .env
cat .env | grep MAIL

# Pastikan:
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=dhikamahesa45@gmail.com
MAIL_PASSWORD="gwbo zrsx krnr segd"
```

---

### Fix 3: Gmail App Password

**Jika kredensial ditolak:**

1. Login ke Google Account: https://myaccount.google.com/security
2. Cek 2-Step Verification → Harus ON ✅
3. Klik "App passwords"
4. Generate password baru untuk "Mail"
5. Copy password (format: xxxx xxxx xxxx xxxx)
6. Update .env:
```env
MAIL_PASSWORD="xxxxxxxxxxxxxx"  # Tanpa spasi!
```
7. Clear cache:
```bash
php artisan config:clear
```

---

## 🧪 TESTING

### Test 1: Email Verifikasi
```bash
php artisan tinker

>>> $user = User::where('email', 'test@example.com')->first()
>>> $user->sendEmailVerificationNotification()
>>> exit

# Check inbox email user
```

---

### Test 2: Email Reset Password
1. Browser: https://graciasclinic.web.id/forgot-password
2. Masukkan email
3. Submit
4. Check inbox

---

### Test 3: Email Konfirmasi Reservasi
1. Login admin: https://graciasclinic.web.id/login
2. Buka: https://graciasclinic.web.id/admin/reservasi
3. Klik "Konfirmasi" pada reservasi pending
4. Check inbox customer

---

## 🔍 DEBUGGING

### Check Logs
```bash
# Real-time monitoring
tail -f storage/logs/laravel.log

# Search errors
grep -i "error" storage/logs/laravel.log | tail -20
grep -i "mail" storage/logs/laravel.log | tail -20
```

---

### Check Queue (jika pakai database queue)
```bash
# Check worker status
sudo supervisorctl status

# Check pending jobs
php artisan tinker
>>> DB::table('jobs')->count()

# Process manually
>>> Artisan::call('queue:work', ['--once' => true])
```

---

## 📞 TROUBLESHOOTING CHECKLIST

- [ ] `.env` MAIL_* config sudah benar
- [ ] Port 587 tidak diblok firewall
- [ ] Gmail App Password valid (bukan password biasa)
- [ ] Queue worker running (jika pakai database queue)
- [ ] `CustomVerifyEmail` tidak pakai `ShouldQueue` (atau worker running)
- [ ] Cache sudah di-clear (`php artisan config:clear`)
- [ ] Permissions storage sudah benar (775)
- [ ] Check `storage/logs/laravel.log` untuk error
- [ ] Test SMTP: `telnet smtp.gmail.com 587` berhasil
- [ ] Gmail tidak block device (check Gmail inbox)

---

## 📚 FILE DOKUMENTASI LENGKAP

**`EMAIL_SYSTEM_DOCUMENTATION.md`** - 700+ baris dokumentasi detail:
- ✅ Penjelasan 3 fitur email
- ✅ Diagram alur kerja
- ✅ File-file yang terlibat
- ✅ Konfigurasi lengkap
- ✅ Troubleshooting detail
- ✅ Setup production (database queue + supervisor)
- ✅ Testing & monitoring
- ✅ Security best practices

---

## 🎯 RECOMMENDED SETUP

**Production (VPS):**
```env
QUEUE_CONNECTION=database
```

**Setup supervisor:**
```bash
sudo apt install supervisor
sudo nano /etc/supervisor/conf.d/laravel-worker.conf

# Paste config dari EMAIL_SYSTEM_DOCUMENTATION.md

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

**Keuntungan:**
- ✅ Email dikirim di background (fast)
- ✅ Auto-retry jika gagal
- ✅ Auto-restart jika crash
- ✅ Bisa monitor via logs

---

**Last Updated:** November 18, 2025  
**For VPS:** graciasclinic.web.id
