# 🔒 SSL Installation Guide - Gracias Clinic
## Mengaktifkan HTTPS untuk graciasclinic.web.id

---

## 📋 Pilih Metode Sesuai Hosting Anda

### ✅ **Method 1: Hosting dengan cPanel (PALING MUDAH)**
### ✅ **Method 2: Hosting dengan Plesk**
### ✅ **Method 3: VPS dengan Certbot (Let's Encrypt)**
### ✅ **Method 4: Cloudflare SSL (GRATIS & INSTANT)**

**Pilih salah satu method di bawah sesuai dengan jenis hosting Anda.**

---

## 🎯 METHOD 1: cPanel (Recommended untuk Shared Hosting)

### Langkah 1: Login ke cPanel
1. Buka browser, masuk ke: `https://graciasclinic.web.id:2083` atau `https://cpanel.hosting-anda.com`
2. Login dengan username & password cPanel

### Langkah 2: Aktifkan AutoSSL (GRATIS)
1. Di cPanel, cari menu **"SSL/TLS Status"** atau **"Let's Encrypt SSL"**
2. Klik **"Run AutoSSL"** atau **"Issue"**
3. Centang domain `graciasclinic.web.id` dan `www.graciasclinic.web.id`
4. Klik **"Run AutoSSL"** atau **"Install"**
5. Tunggu 1-5 menit sampai muncul status **"AutoSSL completed successfully"**

### Langkah 3: Force HTTPS Redirect
1. Di cPanel, klik **"File Manager"**
2. Navigate ke folder `public_html` atau root domain Anda
3. Cari file `.htaccess`
4. Klik kanan → **"Edit"**
5. Tambahkan kode ini di **PALING ATAS** file:

```apache
# Force HTTPS Redirect
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

6. Klik **"Save Changes"**

### Langkah 4: Test SSL
1. Buka browser baru (Incognito mode)
2. Akses: `http://graciasclinic.web.id` (HTTP)
3. Seharusnya otomatis redirect ke `https://graciasclinic.web.id` (HTTPS)
4. Check ada **icon gembok hijau** di address bar

### Langkah 5: Update Laravel .env
SSH atau File Manager, edit file `.env`:
```env
APP_URL=https://graciasclinic.web.id
SESSION_SECURE_COOKIE=true
```

### Langkah 6: Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

✅ **DONE! SSL sudah aktif.**

---

## 🎯 METHOD 2: Plesk Panel

### Langkah 1: Login ke Plesk
1. Buka: `https://your-server-ip:8443`
2. Login dengan credentials Plesk

### Langkah 2: Install Let's Encrypt SSL
1. Pilih domain **"graciasclinic.web.id"** dari daftar
2. Klik tab **"SSL/TLS Certificates"**
3. Klik tombol **"Install"** atau **"Get it free"** di bagian Let's Encrypt
4. Centang:
   - ☑ Secure the domain name graciasclinic.web.id
   - ☑ Include a 'www' subdomain for the domain
5. Isi email: `your-email@example.com`
6. Klik **"Get it free"** atau **"Install"**
7. Tunggu beberapa detik

### Langkah 3: Redirect HTTP to HTTPS
1. Masih di domain settings
2. Klik **"Hosting Settings"**
3. Scroll ke bawah, centang:
   - ☑ **"Permanent SEO-safe 301 redirect from HTTP to HTTPS"**
4. Klik **"OK"** atau **"Apply"**

### Langkah 4: Update .env & Clear Cache
(Sama seperti Method 1, Langkah 5 & 6)

✅ **DONE!**

---

## 🎯 METHOD 3: VPS/Dedicated Server (Ubuntu/Debian)

### Prerequisites:
- Root/sudo access ke server
- Domain sudah pointing ke IP server
- Port 80 dan 443 terbuka di firewall

### Langkah 1: Connect via SSH
```bash
ssh root@your-server-ip
# atau
ssh username@graciasclinic.web.id
```

### Langkah 2: Install Certbot

#### Untuk Ubuntu 20.04/22.04:
```bash
sudo apt update
sudo apt install certbot
```

#### Jika pakai Apache:
```bash
sudo apt install python3-certbot-apache
```

#### Jika pakai Nginx:
```bash
sudo apt install python3-certbot-nginx
```

### Langkah 3: Stop Web Server Sementara (Optional)
```bash
# Jika pakai Apache:
sudo systemctl stop apache2

# Jika pakai Nginx:
sudo systemctl stop nginx
```

### Langkah 4: Generate SSL Certificate

#### Option A: Standalone (recommended saat pertama kali)
```bash
sudo certbot certonly --standalone -d graciasclinic.web.id -d www.graciasclinic.web.id
```

#### Option B: Apache (otomatis configure)
```bash
sudo certbot --apache -d graciasclinic.web.id -d www.graciasclinic.web.id
```

#### Option C: Nginx (otomatis configure)
```bash
sudo certbot --nginx -d graciasclinic.web.id -d www.graciasclinic.web.id
```

**Jawab pertanyaan Certbot:**
```
Enter email address: your-email@example.com
Agree to Terms: A (agree)
Share email with EFF: N (no)
```

### Langkah 5: Start Web Server Kembali
```bash
# Apache:
sudo systemctl start apache2

# Nginx:
sudo systemctl start nginx
```

### Langkah 6: Configure Apache Virtual Host (Jika tidak pakai auto)

Edit file config:
```bash
sudo nano /etc/apache2/sites-available/graciasclinic.web.id-ssl.conf
```

Tambahkan:
```apache
<VirtualHost *:443>
    ServerName graciasclinic.web.id
    ServerAlias www.graciasclinic.web.id
    DocumentRoot /var/www/graciasclinic.web.id/public

    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/graciasclinic.web.id/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/graciasclinic.web.id/privkey.pem

    <Directory /var/www/graciasclinic.web.id/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/graciasclinic-error.log
    CustomLog ${APACHE_LOG_DIR}/graciasclinic-access.log combined
</VirtualHost>

# HTTP to HTTPS Redirect
<VirtualHost *:80>
    ServerName graciasclinic.web.id
    ServerAlias www.graciasclinic.web.id
    Redirect permanent / https://graciasclinic.web.id/
</VirtualHost>
```

Enable config:
```bash
sudo a2enmod ssl
sudo a2ensite graciasclinic.web.id-ssl.conf
sudo systemctl reload apache2
```

### Langkah 7: Configure Nginx (Jika pakai Nginx)

Edit config:
```bash
sudo nano /etc/nginx/sites-available/graciasclinic.web.id
```

Tambahkan/edit:
```nginx
# HTTP Redirect to HTTPS
server {
    listen 80;
    listen [::]:80;
    server_name graciasclinic.web.id www.graciasclinic.web.id;
    return 301 https://$server_name$request_uri;
}

# HTTPS Server
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name graciasclinic.web.id www.graciasclinic.web.id;
    root /var/www/graciasclinic.web.id/public;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/graciasclinic.web.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/graciasclinic.web.id/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php index.html;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Test & reload:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

### Langkah 8: Auto-Renewal Setup
```bash
# Test renewal
sudo certbot renew --dry-run

# Setup cron untuk auto-renewal
sudo crontab -e
```

Tambahkan:
```cron
0 2 * * * /usr/bin/certbot renew --quiet && systemctl reload apache2
# atau untuk nginx:
# 0 2 * * * /usr/bin/certbot renew --quiet && systemctl reload nginx
```

### Langkah 9: Update .env & Clear Cache
(Sama seperti Method 1, Langkah 5 & 6)

✅ **DONE!**

---

## 🎯 METHOD 4: Cloudflare SSL (PALING MUDAH & INSTANT!)

### Keuntungan Cloudflare:
- ✅ **GRATIS selamanya**
- ✅ **Instant aktif** (5 menit)
- ✅ **CDN gratis** (website jadi lebih cepat)
- ✅ **DDoS protection**
- ✅ **Free SSL** tanpa install apapun di server

### Langkah 1: Daftar Cloudflare
1. Buka: https://dash.cloudflare.com/sign-up
2. Daftar dengan email
3. Verify email

### Langkah 2: Add Domain
1. Klik **"Add Site"**
2. Masukkan: `graciasclinic.web.id`
3. Pilih **"Free Plan"** (Rp 0)
4. Klik **"Continue"**

### Langkah 3: DNS Records
Cloudflare akan scan DNS records otomatis. Pastikan ada:

| Type | Name | Content | Proxy Status |
|------|------|---------|--------------|
| A | graciasclinic.web.id | IP-server-anda | Proxied (Orange) |
| A | www | IP-server-anda | Proxied (Orange) |

Jika belum ada, klik **"Add Record"**:
```
Type: A
Name: @
IPv4 address: [IP server Anda]
Proxy status: Proxied (harus ORANGE cloud)
```

Klik **"Continue"**

### Langkah 4: Change Nameservers
Cloudflare akan memberikan 2 nameservers:
```
luna.ns.cloudflare.com
rafe.ns.cloudflare.com
```

**Cara update nameserver di registrar domain Anda:**

#### A. Jika beli di Niagahoster:
1. Login ke https://panel.niagahoster.co.id
2. Pilih **"Domain"** → Pilih domain `graciasclinic.web.id`
3. Klik **"Kelola"** atau **"Manage"**
4. Cari **"Nameserver"** atau **"DNS Management"**
5. Ubah ke **"Custom Nameserver"**
6. Isi:
   ```
   Nameserver 1: luna.ns.cloudflare.com
   Nameserver 2: rafe.ns.cloudflare.com
   ```
7. Klik **"Save"**

#### B. Jika beli di Domainesia:
1. Login ke https://my.domainesia.com
2. **"Layanan Saya"** → **"Domain"**
3. Klik domain `graciasclinic.web.id`
4. Klik **"Name Server"**
5. Pilih **"Custom"**
6. Isi nameserver Cloudflare
7. **"Update Nameserver"**

#### C. Jika beli di Rumahweb/IDCloudhost/dll:
1. Login ke panel domain
2. Cari menu **"DNS Management"** atau **"Nameserver"**
3. Ubah ke nameserver Cloudflare
4. Save

**Tunggu 5-60 menit** untuk propagasi DNS.

### Langkah 5: Aktifkan SSL di Cloudflare
1. Di Cloudflare Dashboard, pilih domain `graciasclinic.web.id`
2. Klik tab **"SSL/TLS"**
3. Pilih mode: **"Full"** atau **"Full (strict)"** 
   - Pilih **"Full"** jika server belum ada SSL
   - Pilih **"Full (strict)"** jika server sudah ada SSL
4. Klik **"Save"**

### Langkah 6: Force HTTPS Redirect
1. Masih di tab **"SSL/TLS"**
2. Klik **"Edge Certificates"**
3. Scroll ke bawah
4. Aktifkan toggle:
   - ☑ **"Always Use HTTPS"** → ON
   - ☑ **"Automatic HTTPS Rewrites"** → ON
5. Tunggu beberapa detik

### Langkah 7: Test SSL
1. Tunggu 5-10 menit
2. Buka browser baru (Incognito)
3. Akses: `http://graciasclinic.web.id`
4. Seharusnya redirect ke: `https://graciasclinic.web.id`
5. Check icon gembok hijau

### Langkah 8: Update .env
```env
APP_URL=https://graciasclinic.web.id
SESSION_SECURE_COOKIE=true
```

Clear cache:
```bash
php artisan config:clear
php artisan cache:clear
```

### Langkah 9: Bonus - Aktifkan CDN & Security
Di Cloudflare Dashboard:

**Speed (CDN):**
1. Tab **"Speed"** → **"Optimization"**
2. Aktifkan:
   - ☑ Auto Minify (JavaScript, CSS, HTML)
   - ☑ Brotli
   - ☑ Rocket Loader

**Security:**
1. Tab **"Security"** → **"Settings"**
2. Security Level: **"Medium"**
3. Challenge Passage: **1 Hour**

**Caching:**
1. Tab **"Caching"** → **"Configuration"**
2. Caching Level: **"Standard"**
3. Browser Cache TTL: **"4 hours"**

✅ **DONE! SSL aktif + CDN + Security gratis!**

---

## ✅ Verification Checklist

Setelah install SSL, test semua ini:

### 1. SSL Test
- [ ] `http://graciasclinic.web.id` redirect ke `https://graciasclinic.web.id`
- [ ] `https://graciasclinic.web.id` loading dengan icon gembok hijau
- [ ] `https://www.graciasclinic.web.id` juga berfungsi
- [ ] Certificate valid (tidak ada warning)

### 2. Laravel App Test
- [ ] Homepage loading normal
- [ ] Login dengan email berfungsi
- [ ] Login dengan Google OAuth berfungsi
- [ ] Create reservasi berfungsi
- [ ] Email notifications terkirim
- [ ] Admin dashboard bisa diakses
- [ ] Assets (CSS/JS/Images) loading

### 3. SSL Quality Test
Test di: https://www.ssllabs.com/ssltest/
- [ ] Rating minimal **A**
- [ ] No warnings

---

## 🔧 Troubleshooting

### Problem: "Your connection is not private" / NET::ERR_CERT_AUTHORITY_INVALID
**Cause**: Certificate belum ter-install atau salah konfigurasi

**Fix**:
```bash
# Check certificate path
sudo ls -la /etc/letsencrypt/live/graciasclinic.web.id/

# Re-generate certificate
sudo certbot certonly --standalone -d graciasclinic.web.id -d www.graciasclinic.web.id --force-renewal
```

### Problem: Redirect loop (too many redirects)
**Cause**: Double redirect (Cloudflare + .htaccess)

**Fix di .htaccess**:
```apache
# Jika pakai Cloudflare, ganti dengan ini:
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTP:X-Forwarded-Proto} !https
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

### Problem: Mixed Content (icon gembok kuning, bukan hijau)
**Cause**: Ada asset (CSS/JS/images) yang di-load via HTTP

**Fix**:
```bash
# Check mixed content di browser console
# Ganti semua http:// menjadi https:// atau //

# Atau gunakan relative URL
# WRONG: <img src="http://graciasclinic.web.id/images/logo.png">
# RIGHT:  <img src="/images/logo.png">
```

### Problem: Google OAuth masih error
**Cause**: Belum update Authorized Redirect URI

**Fix**:
1. Login ke https://console.cloud.google.com
2. APIs & Services → Credentials
3. Edit OAuth Client ID
4. Update Authorized redirect URIs:
   ```
   https://graciasclinic.web.id/auth/callback
   ```
5. Save & tunggu 5-10 menit

---

## 📊 Comparison

| Method | Difficulty | Time | Cost | Best For |
|--------|-----------|------|------|----------|
| **cPanel AutoSSL** | ⭐ Easy | 5 min | FREE | Shared Hosting |
| **Plesk Let's Encrypt** | ⭐ Easy | 5 min | FREE | Plesk Server |
| **VPS Certbot** | ⭐⭐⭐ Medium | 15 min | FREE | VPS/Dedicated |
| **Cloudflare** | ⭐ Easiest | 10 min | FREE | All (+ CDN) |

**Rekomendasi Saya:**
- Jika pakai **shared hosting** → Method 1 (cPanel)
- Jika pakai **VPS** → Method 4 (Cloudflare) atau Method 3 (Certbot)
- Ingin **paling mudah** → Method 4 (Cloudflare)

---

## 📞 Support

Jika ada kendala, hubungi:
- **Email**: dhikamahesa45@gmail.com
- **Check SSL**: https://www.ssllabs.com/ssltest/analyze.html?d=graciasclinic.web.id

---

**Last Updated**: November 16, 2025  
**SSL Provider**: Let's Encrypt (FREE)  
**Renewal**: Automatic (90 days)
