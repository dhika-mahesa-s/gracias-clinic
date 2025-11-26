#!/bin/bash

# Setup SSH Key untuk GitHub Actions CI/CD
# Gracias Aesthetic Clinic

echo "=========================================="
echo "GitHub Actions SSH Key Setup"
echo "=========================================="
echo ""

# Generate SSH Key
echo "🔑 Generating SSH key untuk GitHub Actions..."
ssh-keygen -t ed25519 -C "github-actions-gracias-clinic" -f ~/.ssh/github_actions_key -N ""

if [ $? -eq 0 ]; then
    echo "✅ SSH key berhasil dibuat!"
else
    echo "❌ Gagal membuat SSH key"
    exit 1
fi

echo ""
echo "=========================================="
echo "📋 PUBLIC KEY (Tambahkan ke authorized_keys)"
echo "=========================================="
cat ~/.ssh/github_actions_key.pub
echo ""

# Tambahkan ke authorized_keys
echo "📝 Menambahkan public key ke authorized_keys..."
cat ~/.ssh/github_actions_key.pub >> ~/.ssh/authorized_keys
chmod 600 ~/.ssh/authorized_keys
chmod 700 ~/.ssh
echo "✅ Public key ditambahkan ke authorized_keys"

echo ""
echo "=========================================="
echo "🔐 PRIVATE KEY (Copy ke GitHub Secret VPS_SSH_KEY)"
echo "=========================================="
echo "IMPORTANT: Copy seluruh isi private key di bawah ini"
echo "Paste ke GitHub Repository Settings > Secrets > VPS_SSH_KEY"
echo ""
cat ~/.ssh/github_actions_key
echo ""

echo ""
echo "=========================================="
echo "📝 GitHub Secrets yang Harus Ditambahkan"
echo "=========================================="
echo ""
echo "Buka: https://github.com/dhika-mahesa-s/gracias-clinic/settings/secrets/actions"
echo ""
echo "Tambahkan secrets berikut:"
echo ""
echo "1. VPS_HOST = graciasclinic.web.id"
echo "2. VPS_USERNAME = dhikamahesa (atau root)"
echo "3. VPS_PORT = 22"
echo "4. VPS_SSH_KEY = [Copy private key di atas]"
echo ""

echo "=========================================="
echo "✅ Setup Selesai!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Copy private key di atas"
echo "2. Paste ke GitHub Secret VPS_SSH_KEY"
echo "3. Tambahkan secrets lainnya (VPS_HOST, VPS_USERNAME, VPS_PORT)"
echo "4. Push code ke GitHub untuk test deployment"
echo ""
