#!/bin/bash

# ============================================
# Achievers Academy CMS - Deployment Script
# Run from project root: bash deploy.sh
# ============================================

set -e

echo "🚀 Achievers Academy CMS Deployment Script"
echo "=========================================="

# Configuration (EDIT THESE)
PROJECT_DIR="$(pwd)"
PUBLIC_DIR="$PROJECT_DIR/public"
ADMIN_DIR="$PROJECT_DIR/admin"
UPLOADS_DIR="$PUBLIC_DIR/uploads"
SQL_DIR="$PROJECT_DIR/sql"

# Production paths (change if needed)
WEB_ROOT="/var/www/achievers_cms"
DB_NAME="achievers_cms"
DB_USER="root"
DB_PASS=""

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${YELLOW}Step 1: Preparing directories...${NC}"

# Create necessary directories
mkdir -p "$UPLOADS_DIR"
chmod 755 "$UPLOADS_DIR"
mkdir -p "$WEB_ROOT"

echo -e "${GREEN}✓ Directories ready${NC}"

echo -e "${YELLOW}Step 2: Copying files to web root...${NC}"

# Copy public files
rsync -av --exclude='.git' --exclude='*.sh' --exclude='sql/' "$PUBLIC_DIR/" "$WEB_ROOT/"

# Copy admin
rsync -av "$ADMIN_DIR/" "$WEB_ROOT/admin/"

# Copy includes
rsync -av "$PROJECT_DIR/includes/" "$WEB_ROOT/includes/"

# Copy .htaccess if exists
if [ -f "$PUBLIC_DIR/.htaccess" ]; then
    cp "$PUBLIC_DIR/.htaccess" "$WEB_ROOT/.htaccess"
fi

echo -e "${GREEN}✓ Files copied${NC}"

echo -e "${YELLOW}Step 3: Setting permissions...${NC}"

# Set permissions
find "$WEB_ROOT" -type d -exec chmod 755 {} \;
find "$WEB_ROOT" -type f -exec chmod 644 {} \;
chmod 755 "$WEB_ROOT/uploads"
chmod 755 "$WEB_ROOT/admin"
chmod +x "$WEB_ROOT/admin/*.php" 2>/dev/null || true

echo -e "${GREEN}✓ Permissions set${NC}"

echo -e "${YELLOW}Step 4: Database setup (optional)${NC}"
read -p "Import database schema and seed data? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "Importing schema..."
    mysql -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$SQL_DIR/schema.sql"
    mysql -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$SQL_DIR/seed_data.sql"
    echo -e "${GREEN}✓ Database imported${NC}"
else
    echo -e "${YELLOW}Skipped database import.${NC}"
fi

echo -e "${YELLOW}Step 5: Final configuration check${NC}"

# Check for db.php
if [ -f "$WEB_ROOT/includes/db.php" ]; then
    echo "Database config file found."
else
    echo -e "${RED}Warning: includes/db.php not found in web root${NC}"
fi

echo ""
echo -e "${GREEN}✅ Deployment Complete!${NC}"
echo ""
echo "Next steps:"
echo "1. Edit $WEB_ROOT/includes/db.php with production credentials"
echo "2. Change admin password in the CMS"
echo "3. Set up a virtual host pointing to $WEB_ROOT"
echo "4. Visit: https://yourdomain.com"
echo "5. Admin: https://yourdomain.com/admin/login.php"
echo ""
echo "Default admin: admin / admin123 (CHANGE IMMEDIATELY)"