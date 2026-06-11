#!/bin/bash
set -e

APP_DIR="/srv/apps/wordpress/prod"
BRANCH="live"

echo "===== Deploying prod ====="
cd $APP_DIR

git fetch origin
git checkout $BRANCH
git pull origin $BRANCH

#checking deploy
echo "→ Restarting containers"
docker-compose down
docker-compose up -d

echo " PROD deployment complete"
