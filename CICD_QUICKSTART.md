# 🚀 GitHub Actions CI/CD - Quick Start

Setup CI/CD untuk auto-deploy ke VPS dalam 5 langkah mudah!

---

## 📋 Prerequisites

- ✅ GitHub repository sudah ada
- ✅ VPS sudah running dengan SSH access
- ✅ Project Laravel sudah deploy manual di VPS
- ✅ Git, PHP, Composer, Node.js terinstall di VPS

---

## ⚡ Quick Setup (5 Langkah)

### 1️⃣ Generate SSH Key di VPS

Login ke VPS dan jalankan:

```bash
cd /var/www/graciasclinic.web.id/gracias-clinic
bash tools/setup-github-ssh.sh
```

**Output:** Script akan generate SSH key dan menampilkan:
- ✅ Public key (auto ditambahkan ke authorized_keys)
- ✅ Private key (copy untuk GitHub Secret)

### 2️⃣ Setup VPS Permissions

Masih di VPS, jalankan:

```bash
bash tools/setup-vps-cicd.sh
```

**Script ini akan:**
- ✅ Setup git repository
- ✅ Set file permissions
- ✅ Check dependencies
- ✅ Setup sudo (optional)

### 3️⃣ Tambahkan GitHub Secrets

Buka repository settings:
```
https://github.com/dhika-mahesa-s/gracias-clinic/settings/secrets/actions
```

Klik **"New repository secret"** dan tambahkan:

| Name | Value | Contoh |
|------|-------|--------|
| `VPS_HOST` | Domain/IP VPS | `graciasclinic.web.id` |
| `VPS_USERNAME` | SSH username | `dhikamahesa` |
| `VPS_PORT` | SSH port | `22` |
| `VPS_SSH_KEY` | Private key dari step 1 | `-----BEGIN OPENSSH PRIVATE KEY-----...` |

### 4️⃣ Push Workflow ke GitHub

Di local (Windows):

```powershell
# Add workflow files
git add .github/workflows/deploy.yml
git add CICD_SETUP.md
git add tools/

# Commit
git commit -m "Add GitHub Actions CI/CD workflow"

# Push
git push origin main
```

### 5️⃣ Test Deployment

Cek hasil deployment:
```
https://github.com/dhika-mahesa-s/gracias-clinic/actions
```

Seharusnya workflow "Deploy to VPS" berjalan otomatis! 🎉

---

## ✅ Verifikasi Setup

### Cek di GitHub Actions

```
https://github.com/dhika-mahesa-s/gracias-clinic/actions
```

- ✅ Workflow berjalan tanpa error
- ✅ Semua steps hijau (✓)
- ✅ Deployment selesai dalam 2-5 menit

### Cek di VPS

```bash
# Login VPS
ssh dhikamahesa@graciasclinic.web.id

# Masuk ke project
cd /var/www/graciasclinic.web.id/gracias-clinic

# Cek git log (harus ada commit terbaru)
git log -1

# Cek Laravel logs
tail -50 storage/logs/laravel.log

# Test website
curl -I https://graciasclinic.web.id
```

---

## 🎯 Usage

### Auto Deployment (Recommended)

Setiap push ke `main` akan auto-deploy:

```powershell
# Di local
git add .
git commit -m "Update feature"
git push origin main

# GitHub Actions akan auto-deploy ke VPS! 🚀
```

### Manual Deployment

Trigger manual di GitHub:
1. Buka: https://github.com/dhika-mahesa-s/gracias-clinic/actions
2. Klik "Deploy to VPS"
3. Klik "Run workflow" → "Run workflow"

---

## 🔧 Common Issues

### ❌ Error: Permission denied (publickey)

**Solusi:**
```bash
# Di VPS, cek authorized_keys
cat ~/.ssh/authorized_keys

# Pastikan public key ada
# Pastikan private key di GitHub Secret benar
```

### ❌ Error: Git pull failed

**Solusi:**
```bash
# Di VPS, setup git credentials
git config --global credential.helper store
git pull origin main
# Masukkan username & Personal Access Token
```

Buat token di: https://github.com/settings/tokens

### ❌ Error: npm run build failed

**Solusi:**
```bash
# Di VPS, update Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Clear cache
rm -rf node_modules package-lock.json
npm install
```

---

## 📚 Full Documentation

Baca dokumentasi lengkap: **CICD_SETUP.md**

---

## 🎉 That's It!

Sekarang setiap kali Anda push code, GitHub Actions akan otomatis:
1. ✅ Build assets
2. ✅ Install dependencies
3. ✅ Deploy ke VPS
4. ✅ Run migrations
5. ✅ Clear cache
6. ✅ Restart server

**Deployment time:** 2-5 menit ⚡

---

**Happy Deploying! 🚀**
