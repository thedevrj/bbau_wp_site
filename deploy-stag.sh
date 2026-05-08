#!/bin/bash
set -e

APP_DIR="/srv/apps/wordpress/stag"
BRANCH="stag"

echo "===== Deploying stag ====="
cd $APP_DIR

git fetch origin
git checkout $BRANCH
git pull origin $BRANCH

#checking deploy
echo "→ Restarting containers"
docker-compose down
docker-compose up -d

echo "STAG deployment complete"
