# GitHub Actions CI/CD Setup Guide

## 📋 Overview

Workflow otomatis ini akan:
- ✅ Build dan compile assets (Vite)
- ✅ Install dependencies (Composer & NPM)
- ✅ Deploy ke VPS production
- ✅ Run migrations otomatis
- ✅ Clear & cache Laravel config
- ✅ Restart web server

**Trigger:** Setiap push ke branch `main` atau manual trigger

---

## 🔐 Setup GitHub Secrets

Anda harus menambahkan secrets di GitHub repository untuk koneksi SSH ke VPS:

### 1. Buka GitHub Repository Settings

```
https://github.com/dhika-mahesa-s/gracias-clinic/settings/secrets/actions
```

### 2. Tambahkan Secrets Berikut:

| Secret Name | Value | Deskripsi |
|------------|-------|-----------|
| `VPS_HOST` | `graciasclinic.web.id` | Domain/IP VPS Anda |
| `VPS_USERNAME` | `dhikamahesa` | Username SSH (atau `root`) |
| `VPS_SSH_KEY` | `[SSH Private Key]` | Private key untuk SSH |
| `VPS_PORT` | `22` | SSH Port (default 22) |

---

## 🔑 Generate SSH Key untuk GitHub Actions

### Opsi 1: Buat SSH Key Baru (Recommended)

Jalankan di **VPS Anda**:

```bash
# Generate SSH key khusus untuk GitHub Actions
ssh-keygen -t ed25519 -C "github-actions-gracias-clinic" -f ~/.ssh/github_actions_key -N ""

# Tampilkan public key
cat ~/.ssh/github_actions_key.pub

# Tampilkan private key (untuk GitHub Secret)
cat ~/.ssh/github_actions_key
```

**Tambahkan public key ke authorized_keys:**

```bash
cat ~/.ssh/github_actions_key.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
```

**Copy private key** dan paste ke GitHub Secret `VPS_SSH_KEY`.

### Opsi 2: Gunakan SSH Key yang Ada

Jika sudah punya SSH key:

```bash
# Lihat public key
cat ~/.ssh/id_rsa.pub

# Lihat private key (untuk GitHub Secret)
cat ~/.ssh/id_rsa
```

Copy **private key** ke GitHub Secret `VPS_SSH_KEY`.

---

## 📝 Setup di VPS

### 1. Pastikan Git Repository Terkoneksi

```bash
cd /var/www/graciasclinic.web.id/gracias-clinic

# Cek remote repository
git remote -v

# Jika belum ada, tambahkan
git remote add origin https://github.com/dhika-mahesa-s/gracias-clinic.git

# Set branch tracking
git branch --set-upstream-to=origin/main main
```

### 2. Setup Git Credentials (untuk HTTPS)

```bash
# Simpan credentials
git config --global credential.helper store

# Pull sekali untuk save credentials
git pull origin main
# Masukkan GitHub username & Personal Access Token
```

**Buat GitHub Personal Access Token:**
1. Buka: https://github.com/settings/tokens
2. Generate new token (classic)
3. Pilih scope: `repo` (Full control of private repositories)
4. Copy token dan gunakan sebagai password saat `git pull`

### 3. Set Permissions

```bash
# Set ownership
sudo chown -R dhikamahesa:www-data /var/www/graciasclinic.web.id/gracias-clinic

# Set permissions
sudo chmod -R 775 /var/www/graciasclinic.web.id/gracias-clinic/storage
sudo chmod -R 775 /var/www/graciasclinic.web.id/gracias-clinic/bootstrap/cache

# Tambahkan user ke www-data group
sudo usermod -aG www-data dhikamahesa
```

### 4. Allow Sudo Restart (Optional)

Jika workflow perlu restart web server tanpa password:

```bash
sudo visudo
```

Tambahkan di bagian bawah:

```
dhikamahesa ALL=(ALL) NOPASSWD: /bin/systemctl restart apache2
dhikamahesa ALL=(ALL) NOPASSWD: /bin/systemctl restart nginx
```

---

## 🚀 Cara Menggunakan

### Automatic Deployment

Setiap kali Anda push ke branch `main`, deployment otomatis berjalan:

```bash
# Di local (Windows)
git add .
git commit -m "Update feature"
git push origin main

# GitHub Actions akan otomatis deploy ke VPS
```

### Manual Deployment

Trigger manual di GitHub:
1. Buka: `https://github.com/dhika-mahesa-s/gracias-clinic/actions`
2. Pilih workflow "Deploy to VPS"
3. Klik "Run workflow" → pilih branch → "Run workflow"

---

## 📊 Monitoring Deployment

### Lihat Status Deployment

1. Buka: `https://github.com/dhika-mahesa-s/gracias-clinic/actions`
2. Klik workflow run terbaru
3. Lihat logs untuk setiap step

### Cek Deployment di VPS

```bash
# Lihat git log
cd /var/www/graciasclinic.web.id/gracias-clinic
git log -1

# Cek Laravel logs
tail -50 storage/logs/laravel.log
```

---

## 🔧 Troubleshooting

### Error: Permission Denied (publickey)

**Solusi:**
- Pastikan SSH key sudah ditambahkan ke `~/.ssh/authorized_keys` di VPS
- Pastikan private key di GitHub Secret `VPS_SSH_KEY` benar
- Cek permissions: `chmod 700 ~/.ssh` dan `chmod 600 ~/.ssh/authorized_keys`

### Error: Git Pull Failed

**Solusi:**
```bash
cd /var/www/graciasclinic.web.id/gracias-clinic
git reset --hard origin/main
git pull origin main
```

### Error: Composer Install Failed

**Solusi:**
```bash
# Update Composer
composer self-update

# Clear cache
composer clear-cache

# Install ulang
composer install --no-interaction --prefer-dist --optimize-autoloader
```

### Error: NPM Build Failed

**Solusi:**
```bash
# Update Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Clear cache
npm cache clean --force
rm -rf node_modules package-lock.json

# Install ulang
npm install
npm run build
```

### Error: Permission Denied on Storage

**Solusi:**
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

---

## 🎯 Workflow Customization

### Disable Automatic Migration

Edit `.github/workflows/deploy.yml`, comment baris ini:

```yaml
# php artisan migrate --force
```

### Add Queue Restart

Tambahkan di bagian script:

```yaml
# Restart queue workers
php artisan queue:restart
```

### Add Database Backup

Tambahkan sebelum migration:

```yaml
# Backup database
php artisan backup:run --only-db
```

---

## 📚 Best Practices

1. ✅ **Selalu test di local** sebelum push ke main
2. ✅ **Gunakan branch** untuk development, merge ke main setelah testing
3. ✅ **Monitor logs** setiap deployment
4. ✅ **Backup database** sebelum migration besar
5. ✅ **Set APP_DEBUG=false** di production
6. ✅ **Gunakan queue** untuk email (background job)

---

## 🔒 Security Tips

1. ✅ Jangan commit `.env` file
2. ✅ Gunakan SSH key khusus untuk CI/CD (bukan personal key)
3. ✅ Rotate SSH key secara berkala
4. ✅ Enable GitHub 2FA
5. ✅ Restrict GitHub Actions ke branch main only
6. ✅ Set proper file permissions di VPS

---

## 📞 Support

Jika ada masalah:
1. Cek GitHub Actions logs
2. Cek Laravel logs: `storage/logs/laravel.log`
3. Cek web server logs: `/var/log/apache2/error.log` atau `/var/log/nginx/error.log`

---

## 🎉 Deployment Flow

```
Local Changes → Git Push → GitHub Actions → SSH to VPS → Pull Code → Install Dependencies → Build Assets → Run Migrations → Clear Cache → Restart Server → ✅ LIVE
```

**Estimated deployment time:** 2-5 menit

---

**Created:** November 26, 2025
**Project:** Gracias Aesthetic Clinic
**Author:** GitHub Actions CI/CD Setup
