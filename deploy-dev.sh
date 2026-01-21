#!/bin/bash
set -e

APP_DIR="/srv/apps/wordpress/dev"
BRANCH="dev"

echo "===== Deploying DEV ====="
cd $APP_DIR

git fetch origin
git checkout $BRANCH
git pull origin $BRANCH

echo "→ Fixing permissions (themes ONLY)"
chmod -R u+rwX,go+rX wp-content/themes

echo "→ Restarting containers"
docker-compose down
docker-compose up -d

echo "✅ DEV deployment complete"
