#!/bin/bash

##############################################################################
# Email System Quick Fix Script - Gracias Clinic VPS
# File: email-fix-vps.sh
# Usage: bash email-fix-vps.sh
##############################################################################

echo "========================================"
echo "  Email System Diagnostic & Fix Tool"
echo "  Gracias Clinic VPS"
echo "========================================"
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Project path (adjust if needed)
PROJECT_PATH="/var/www/graciasclinic.web.id"

if [ ! -d "$PROJECT_PATH" ]; then
    echo -e "${RED}Error: Project directory not found: $PROJECT_PATH${NC}"
    echo "Please edit this script and set correct PROJECT_PATH"
    exit 1
fi

cd $PROJECT_PATH

echo -e "${YELLOW}Step 1: Checking .env configuration...${NC}"
echo "----------------------------------------"

# Check MAIL configuration
echo -n "MAIL_MAILER: "
grep "^MAIL_MAILER=" .env | cut -d'=' -f2
echo -n "MAIL_HOST: "
grep "^MAIL_HOST=" .env | cut -d'=' -f2
echo -n "MAIL_PORT: "
grep "^MAIL_PORT=" .env | cut -d'=' -f2
echo -n "MAIL_USERNAME: "
grep "^MAIL_USERNAME=" .env | cut -d'=' -f2
echo -n "MAIL_ENCRYPTION: "
grep "^MAIL_ENCRYPTION=" .env | cut -d'=' -f2
echo -n "QUEUE_CONNECTION: "
grep "^QUEUE_CONNECTION=" .env | cut -d'=' -f2

echo ""
echo -e "${YELLOW}Step 2: Testing SMTP connection...${NC}"
echo "----------------------------------------"

# Test telnet to Gmail SMTP
timeout 5 bash -c "</dev/tcp/smtp.gmail.com/587" 2>/dev/null
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ SMTP connection successful (port 587 reachable)${NC}"
else
    echo -e "${RED}✗ SMTP connection failed (port 587 blocked)${NC}"
    echo "  Possible solutions:"
    echo "  1. sudo ufw allow out 587/tcp"
    echo "  2. Contact VPS provider"
fi

echo ""
echo -e "${YELLOW}Step 3: Checking firewall...${NC}"
echo "----------------------------------------"

# Check UFW status
if command -v ufw &> /dev/null; then
    UFW_STATUS=$(sudo ufw status | grep "Status:" | awk '{print $2}')
    echo "UFW Status: $UFW_STATUS"
    
    if [ "$UFW_STATUS" == "active" ]; then
        echo "Checking port 587..."
        sudo ufw status | grep "587"
        
        read -p "Allow outbound SMTP (port 587)? (y/n) " -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]; then
            sudo ufw allow out 587/tcp
            echo -e "${GREEN}✓ Port 587 allowed${NC}"
        fi
    fi
else
    echo "UFW not installed"
fi

echo ""
echo -e "${YELLOW}Step 4: Checking queue configuration...${NC}"
echo "----------------------------------------"

QUEUE_CONN=$(grep "^QUEUE_CONNECTION=" .env | cut -d'=' -f2)
echo "Current queue connection: $QUEUE_CONN"

if [ "$QUEUE_CONN" == "sync" ]; then
    echo -e "${YELLOW}⚠ Queue is set to 'sync' (synchronous)${NC}"
    echo ""
    echo "You have 2 options:"
    echo ""
    echo "Option A: Use database queue (RECOMMENDED)"
    echo "  - Pros: Background processing, better UX, auto-retry"
    echo "  - Cons: Need supervisor setup"
    echo ""
    echo "Option B: Keep sync but remove ShouldQueue"
    echo "  - Pros: Simple, no setup needed"
    echo "  - Cons: Slower UX, no retry mechanism"
    echo ""
    
    read -p "Choose option (A/B/skip): " -n 1 -r
    echo
    
    if [[ $REPLY =~ ^[Aa]$ ]]; then
        # Option A: Database queue
        echo "Setting up database queue..."
        
        # Update .env
        sed -i 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=database/' .env
        echo -e "${GREEN}✓ Updated .env: QUEUE_CONNECTION=database${NC}"
        
        # Create jobs table if not exists
        php artisan queue:table 2>/dev/null
        php artisan migrate --force
        
        echo ""
        echo -e "${YELLOW}Next steps:${NC}"
        echo "1. Install supervisor: sudo apt install supervisor"
        echo "2. Create config: sudo nano /etc/supervisor/conf.d/laravel-worker.conf"
        echo "3. Paste this config:"
        echo ""
        cat << 'EOF'
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
EOF
        echo ""
        echo "4. Start worker:"
        echo "   sudo supervisorctl reread"
        echo "   sudo supervisorctl update"
        echo "   sudo supervisorctl start laravel-worker:*"
        
    elif [[ $REPLY =~ ^[Bb]$ ]]; then
        # Option B: Remove ShouldQueue
        echo "Removing ShouldQueue from CustomVerifyEmail..."
        
        NOTIF_FILE="app/Notifications/CustomVerifyEmail.php"
        
        # Backup original
        cp $NOTIF_FILE ${NOTIF_FILE}.backup
        
        # Remove implements ShouldQueue
        sed -i 's/extends Notification implements ShouldQueue/extends Notification/' $NOTIF_FILE
        
        # Comment use Queueable
        sed -i 's/^    use Queueable;$/    \/\/ use Queueable; \/\/ Removed for sync sending/' $NOTIF_FILE
        
        echo -e "${GREEN}✓ Modified $NOTIF_FILE${NC}"
        echo "  - Removed: implements ShouldQueue"
        echo "  - Commented: use Queueable;"
        echo "  - Backup saved: ${NOTIF_FILE}.backup"
    fi
    
elif [ "$QUEUE_CONN" == "database" ]; then
    echo -e "${GREEN}✓ Database queue configured${NC}"
    
    # Check if supervisor is running
    if command -v supervisorctl &> /dev/null; then
        echo ""
        echo "Checking supervisor status..."
        sudo supervisorctl status | grep laravel
        
        if [ $? -ne 0 ]; then
            echo -e "${YELLOW}⚠ No Laravel worker found in supervisor${NC}"
            echo "Run the setup commands from EMAIL_SYSTEM_DOCUMENTATION.md"
        fi
    else
        echo -e "${YELLOW}⚠ Supervisor not installed${NC}"
        echo "Install: sudo apt install supervisor"
    fi
fi

echo ""
echo -e "${YELLOW}Step 5: Clearing Laravel cache...${NC}"
echo "----------------------------------------"

php artisan config:clear
echo "✓ Config cache cleared"

php artisan cache:clear
echo "✓ Application cache cleared"

php artisan route:clear
echo "✓ Route cache cleared"

php artisan view:clear
echo "✓ View cache cleared"

echo ""
echo -e "${YELLOW}Step 6: Checking permissions...${NC}"
echo "----------------------------------------"

# Fix storage permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
echo -e "${GREEN}✓ Storage permissions fixed${NC}"

echo ""
echo -e "${YELLOW}Step 7: Testing email (optional)...${NC}"
echo "----------------------------------------"

read -p "Test send email now? (y/n) " -n 1 -r
echo

if [[ $REPLY =~ ^[Yy]$ ]]; then
    read -p "Enter test email address: " TEST_EMAIL
    
    if [ ! -z "$TEST_EMAIL" ]; then
        echo "Sending test email to $TEST_EMAIL..."
        
        php artisan tinker --execute="
            use Illuminate\Support\Facades\Mail;
            Mail::raw('This is a test email from Gracias Clinic VPS. Email system is working!', function(\$message) {
                \$message->to('$TEST_EMAIL')
                        ->subject('Test Email - Gracias Clinic VPS');
            });
            echo 'Email sent! Check your inbox (and spam folder).';
        "
    fi
fi

echo ""
echo "========================================"
echo -e "${GREEN}Diagnostic complete!${NC}"
echo "========================================"
echo ""
echo "Next steps:"
echo "1. Check: storage/logs/laravel.log for errors"
echo "2. Monitor: tail -f storage/logs/laravel.log"
echo "3. If still not working, check: EMAIL_SYSTEM_DOCUMENTATION.md"
echo ""
echo "Common issues:"
echo "- Gmail blocking new device → Check Gmail inbox for security alert"
echo "- App Password expired → Regenerate at myaccount.google.com/apppasswords"
echo "- Queue worker not running → sudo supervisorctl status"
echo ""
echo "For detailed troubleshooting, see: EMAIL_SYSTEM_DOCUMENTATION.md"
echo ""
