#!/bin/bash
set -e

APP_DIR="/srv/apps/wordpress/dev"
BRANCH="dev"

echo "===== Deploying DEV ====="
cd $APP_DIR

git fetch origin
git checkout $BRANCH
git pull origin $BRANCH

echo "→ Fixing permissions (uploads only)"
chown -R www-data:www-data wp-content/uploads
find wp-content/uploads -type d -exec chmod 775 {} \;
find wp-content/uploads -type f -exec chmod 664 {} \;
echo "→ Restarting containers"
docker compose down
docker compose up -d

echo "✅ DEV deployment complete"
