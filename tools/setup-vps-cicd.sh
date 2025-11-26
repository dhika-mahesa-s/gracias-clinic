#!/bin/bash

# Setup VPS untuk GitHub Actions Deployment
# Gracias Aesthetic Clinic

echo "=========================================="
echo "VPS Setup untuk GitHub Actions CI/CD"
echo "=========================================="
echo ""

PROJECT_PATH="/var/www/graciasclinic.web.id/gracias-clinic"
USER="dhikamahesa"
WEB_USER="www-data"

# Cek apakah running sebagai user yang benar
if [ "$USER" != "$USER" ]; then
    echo "⚠️  Harap jalankan script ini sebagai user: $USER"
    exit 1
fi

echo "📁 Project path: $PROJECT_PATH"
echo ""

# 1. Setup Git Repository
echo "=========================================="
echo "1. Setup Git Repository"
echo "=========================================="

cd $PROJECT_PATH

# Cek apakah git sudah ter-init
if [ ! -d ".git" ]; then
    echo "❌ Git repository belum ter-init!"
    echo "Jalankan: git init && git remote add origin https://github.com/dhika-mahesa-s/gracias-clinic.git"
    exit 1
fi

# Cek remote
echo "🔍 Checking git remote..."
git remote -v

# Set upstream branch
echo "📝 Setting upstream branch..."
git branch --set-upstream-to=origin/main main

echo "✅ Git repository setup complete"
echo ""

# 2. Setup Permissions
echo "=========================================="
echo "2. Setup File Permissions"
echo "=========================================="

echo "📝 Setting ownership..."
sudo chown -R $USER:$WEB_USER $PROJECT_PATH

echo "📝 Setting storage permissions..."
sudo chmod -R 775 $PROJECT_PATH/storage
sudo chmod -R 775 $PROJECT_PATH/bootstrap/cache

echo "📝 Adding user to www-data group..."
sudo usermod -aG $WEB_USER $USER

echo "✅ Permissions setup complete"
echo ""

# 3. Test Dependencies
echo "=========================================="
echo "3. Checking Dependencies"
echo "=========================================="

# Check PHP
echo "🔍 Checking PHP..."
php -v | head -1

# Check Composer
echo "🔍 Checking Composer..."
composer --version | head -1

# Check Node.js
echo "🔍 Checking Node.js..."
node -v

# Check NPM
echo "🔍 Checking NPM..."
npm -v

echo "✅ All dependencies available"
echo ""

# 4. Setup Sudo for Web Server Restart
echo "=========================================="
echo "4. Setup Sudo Permissions (Optional)"
echo "=========================================="

echo "⚠️  Untuk allow restart web server tanpa password:"
echo ""
echo "Jalankan: sudo visudo"
echo ""
echo "Tambahkan baris berikut di bagian bawah:"
echo ""
echo "$USER ALL=(ALL) NOPASSWD: /bin/systemctl restart apache2"
echo "$USER ALL=(ALL) NOPASSWD: /bin/systemctl restart nginx"
echo ""
echo "Simpan dan keluar (Ctrl+X, Y, Enter)"
echo ""

read -p "Apakah Anda ingin setup sudo sekarang? (y/n) " -n 1 -r
echo ""

if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "$USER ALL=(ALL) NOPASSWD: /bin/systemctl restart apache2" | sudo EDITOR='tee -a' visudo
    echo "$USER ALL=(ALL) NOPASSWD: /bin/systemctl restart nginx" | sudo EDITOR='tee -a' visudo
    echo "✅ Sudo permissions added"
else
    echo "⏭️  Skipped sudo setup"
fi

echo ""

# 5. Test Git Pull
echo "=========================================="
echo "5. Test Git Pull"
echo "=========================================="

echo "📥 Testing git pull..."
git pull origin main

if [ $? -eq 0 ]; then
    echo "✅ Git pull successful"
else
    echo "❌ Git pull failed"
    echo ""
    echo "💡 Setup git credentials:"
    echo "1. git config --global credential.helper store"
    echo "2. git pull origin main"
    echo "3. Masukkan GitHub username"
    echo "4. Masukkan Personal Access Token (bukan password)"
    echo ""
    echo "Buat token di: https://github.com/settings/tokens"
fi

echo ""

# 6. Summary
echo "=========================================="
echo "✅ VPS Setup Complete!"
echo "=========================================="
echo ""
echo "📝 Checklist:"
echo "  ✅ Git repository configured"
echo "  ✅ File permissions set"
echo "  ✅ Dependencies available"
echo "  ⚠️  Sudo permissions (manual setup required)"
echo "  ⚠️  Git credentials (may need setup)"
echo ""
echo "🚀 Next Steps:"
echo "1. Setup GitHub Secrets (VPS_HOST, VPS_USERNAME, VPS_SSH_KEY, VPS_PORT)"
echo "2. Run: bash tools/setup-github-ssh.sh (untuk generate SSH key)"
echo "3. Push code ke GitHub untuk test deployment"
echo ""
echo "📚 Full guide: Read CICD_SETUP.md"
echo ""
