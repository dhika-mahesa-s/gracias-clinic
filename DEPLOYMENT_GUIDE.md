# 🚀 Deployment Guide - Gracias Clinic
## Deploy ke Domain: graciasclinic.web.id

---

## 📋 Checklist Pre-Deployment

### 1. ✅ Update Google OAuth Console
Karena domain berubah dari `localhost:8000` ke `graciasclinic.web.id`, Anda **WAJIB** update Google OAuth settings:

#### A. Buka Google Cloud Console
1. Masuk ke https://console.cloud.google.com
2. Pilih project Anda
3. Menu: **APIs & Services** → **Credentials**
4. Klik OAuth 2.0 Client ID Anda

#### B. Update Authorized JavaScript Origins
```
Hapus: http://localhost:8000
Tambah: https://graciasclinic.web.id
```

#### C. Update Authorized Redirect URIs
```
Hapus: http://localhost:8000/auth/callback
Tambah: https://graciasclinic.web.id/auth/callback
```

#### D. Save Changes
⚠️ **PENTING**: Perubahan Google OAuth butuh waktu 5-10 menit untuk aktif.

---

## 🔧 Environment Configuration

### File `.env` Sudah Dikonfigurasi Untuk Production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://graciasclinic.web.id

SESSION_DOMAIN=.graciasclinic.web.id
SESSION_SECURE_COOKIE=true

GOOGLE_REDIRECT_URI=https://graciasclinic.web.id/auth/callback
```

### Yang Perlu Anda Ubah di Server:
```env
# Database (sesuaikan dengan server hosting)
DB_HOST=127.0.0.1
DB_DATABASE=nama_database_di_hosting
DB_USERNAME=username_database
DB_PASSWORD=password_database_yang_kuat

# Email (gunakan email domain atau Gmail)
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@graciasclinic.web.id
```

---

## 📦 Upload Files ke Server

### 1. Files yang TIDAK Perlu Diupload:
```
❌ /node_modules/
❌ /vendor/
❌ /.git/
❌ /storage/logs/*.log
❌ .env (akan dibuat manual di server)
```

### 2. Upload via FTP/SFTP:
```
✅ /app/
✅ /bootstrap/
✅ /config/
✅ /database/
✅ /public/
✅ /resources/
✅ /routes/
✅ /storage/ (pastikan folder kosong)
✅ composer.json
✅ package.json
✅ artisan
```

---

## 🔐 Setup di Server (SSH)

### 1. Connect via SSH
```bash
ssh username@graciasclinic.web.id
cd public_html  # atau folder project Anda
```

### 2. Install Dependencies
```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies
npm install

# Build assets untuk production
npm run build
```

### 3. Setup Environment
```bash
# Copy .env.example ke .env
cp .env.example .env

# Edit .env (gunakan nano atau vi)
nano .env
```

Isi dengan konfigurasi production:
- Database credentials dari hosting
- Email credentials
- Google OAuth (CLIENT_ID & SECRET yang sama)
- APP_KEY yang sama dari localhost

### 4. Generate Application Key (jika belum ada)
```bash
php artisan key:generate
```

### 5. Setup Database
```bash
# Run migrations
php artisan migrate --force

# Seed database (optional)
php artisan db:seed --force
```

### 6. Setup Storage & Cache
```bash
# Create symbolic link untuk storage
php artisan storage:link

# Clear & rebuild cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Set Permissions
```bash
# Set ownership (sesuaikan dengan user server Anda)
sudo chown -R www-data:www-data storage bootstrap/cache

# Set permissions
chmod -R 775 storage bootstrap/cache
```

---

## 🌐 Web Server Configuration

### A. Apache (.htaccess)

File `public/.htaccess` sudah ada dari Laravel. Pastikan:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**PENTING**: Document Root harus mengarah ke folder `public/`:
```
Document Root: /home/user/public_html/public
```

### B. Nginx

Jika menggunakan Nginx, tambahkan config:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name graciasclinic.web.id www.graciasclinic.web.id;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name graciasclinic.web.id www.graciasclinic.web.id;
    root /var/www/graciasclinic.web.id/public;

    # SSL Configuration
    ssl_certificate /path/to/ssl/certificate.crt;
    ssl_certificate_key /path/to/ssl/private.key;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

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

---

## 🔒 SSL Certificate (HTTPS)

### Option 1: Let's Encrypt (GRATIS)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache

# Generate SSL
sudo certbot --apache -d graciasclinic.web.id -d www.graciasclinic.web.id
```

### Option 2: SSL dari Hosting Provider
- Login ke panel hosting (cPanel/Plesk)
- Menu SSL/TLS
- Aktifkan AutoSSL atau upload SSL certificate

---

## ✅ Post-Deployment Checklist

### 1. Test Aplikasi
- [ ] Homepage loading: https://graciasclinic.web.id
- [ ] Login dengan email
- [ ] Login dengan Google OAuth
- [ ] Create reservasi
- [ ] Admin dashboard
- [ ] Email notifications terkirim

### 2. Test SSL/HTTPS
- [ ] HTTPS redirect dari HTTP
- [ ] No mixed content warnings
- [ ] Green padlock di browser

### 3. Performance Check
- [ ] Assets loading (CSS/JS)
- [ ] Images loading
- [ ] Database queries optimized (check logs)
- [ ] Cache berfungsi

### 4. Security Check
```bash
# Pastikan .env tidak bisa diakses
curl https://graciasclinic.web.id/.env
# Harus return 404 atau 403

# Pastikan debug mode OFF
# Error page harus generic, bukan stack trace
```

---

## 🐛 Troubleshooting

### Error: "500 Internal Server Error"
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Common fixes:
php artisan config:clear
php artisan cache:clear
chmod -R 775 storage bootstrap/cache
```

### Google OAuth Error: "redirect_uri_mismatch"
- Pastikan sudah update di Google Cloud Console
- Tunggu 5-10 menit untuk propagasi
- Clear browser cache
- Check `.env` GOOGLE_REDIRECT_URI

### Email Tidak Terkirim
```bash
# Test email via tinker
php artisan tinker
Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check MAIL_* config di .env
# Pastikan port 587 tidak diblok oleh firewall
```

### CSS/JS Tidak Loading
```bash
# Rebuild assets
npm run build

# Clear cache
php artisan view:clear

# Check public/build/ folder exists
ls -la public/build/
```

---

## 📊 Monitoring & Maintenance

### 1. Setup Cron Jobs
```bash
# Edit crontab
crontab -e

# Tambahkan:
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### 2. Backup Database (Daily)
```bash
# Create backup script
nano /home/user/backup-db.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u username -p'password' database_name > /backups/db_$DATE.sql
find /backups/ -type f -name "*.sql" -mtime +7 -delete
```

```bash
chmod +x /home/user/backup-db.sh

# Add to crontab (daily at 2 AM)
0 2 * * * /home/user/backup-db.sh
```

### 3. Monitor Logs
```bash
# Laravel logs
tail -f storage/logs/laravel.log

# Web server logs (Apache)
tail -f /var/log/apache2/error.log

# Web server logs (Nginx)
tail -f /var/log/nginx/error.log
```

---

## 🚀 Performance Optimization

### 1. OPcache (PHP)
Edit `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
```

### 2. Laravel Optimization
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Enable Gzip Compression (Apache)
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

---

## 📞 Support

**Developer**: Dhika Mahesa Saputra  
**Email**: dhikamahesa45@gmail.com  
**Website**: https://graciasclinic.web.id

---

**Last Updated**: November 16, 2025  
**Version**: 1.0.0 Production Ready
