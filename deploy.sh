#!/usr/bin/env bash

# ============================================
# Achievers Academy CMS - Deployment Script
# Run from project root: bash deploy.sh
# Override production values when needed, for example:
# WEB_ROOT=/home/account/public_html bash deploy.sh
# ============================================

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SQL_DIR="$PROJECT_DIR/sql"

# Production paths (override these environment variables for the host)
WEB_ROOT="${WEB_ROOT:-/var/www/achievers_cms}"
DB_NAME="${DB_NAME:-achievers_cms}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-}"

GREEN='\033[0;32m'
YELLOW='\033[0;33m'
RED='\033[0;31m'
NC='\033[0m'

echo "🚀 Achievers Academy CMS Deployment Script"
echo "=========================================="
echo "Deploying to: $WEB_ROOT"

echo -e "${YELLOW}Step 1: Preparing directories...${NC}"
mkdir -p "$WEB_ROOT" "$WEB_ROOT/uploads"
chmod 755 "$WEB_ROOT" "$WEB_ROOT/uploads"
echo -e "${GREEN}✓ Directories ready${NC}"

echo -e "${YELLOW}Step 2: Copying website files...${NC}"

# Public PHP entry points and the root router live in the project root.
# Copying only public/ would omit index.php, the admin router and .htaccess.
rsync -av \
    --include='/*.php' \
    --include='/.htaccess' \
    --exclude='*' \
    "$PROJECT_DIR/" "$WEB_ROOT/"

# Copy every runtime directory used by the application. SQL, Git metadata and
# development files are deliberately excluded from the public document root.
for runtime_dir in admin assets includes uploads public; do
    if [ -d "$PROJECT_DIR/$runtime_dir" ]; then
        rsync -av "$PROJECT_DIR/$runtime_dir/" "$WEB_ROOT/$runtime_dir/"
    fi
done

echo -e "${GREEN}✓ Website, admin area and routing files copied${NC}"

echo -e "${YELLOW}Step 3: Setting permissions...${NC}"
find "$WEB_ROOT" -type d -exec chmod 755 {} \;
find "$WEB_ROOT" -type f -exec chmod 644 {} \;
chmod 755 "$WEB_ROOT/uploads"
echo -e "${GREEN}✓ Permissions set${NC}"

echo -e "${YELLOW}Step 4: Database setup (optional)${NC}"
read -r -p "Import database schema and seed data? (y/n): " -n 1 REPLY
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
if [ -f "$WEB_ROOT/includes/db.php" ]; then
    echo "Database config file found."
else
    echo -e "${RED}Warning: includes/db.php was not copied to the web root${NC}"
fi

if [ -f "$WEB_ROOT/admin/index.php" ]; then
    echo "Admin dashboard entry point found."
else
    echo -e "${RED}Warning: admin/index.php was not copied to the web root${NC}"
fi

if [ -f "$WEB_ROOT/.htaccess" ]; then
    echo "Root routing file found."
else
    echo -e "${RED}Warning: .htaccess was not copied to the web root${NC}"
fi

echo ""
echo -e "${GREEN}✅ Deployment Complete!${NC}"
echo ""
echo "Next steps:"
echo "1. Edit $WEB_ROOT/includes/db.php with production credentials"
echo "2. Change the CMS administrator password"
echo "3. Point the virtual host or subdomain document root to $WEB_ROOT"
echo "4. Visit: https://yourdomain.com/"
echo "5. Admin: https://yourdomain.com/admin/login.php"
echo ""
echo "Default admin: admin / admin123 (CHANGE IMMEDIATELY)"
