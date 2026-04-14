#!/bin/bash
set -e

APP_DIR=~/online_exam
TARGET_DIR=$APP_DIR/current

echo "Cleaning old deployment..."
rm -rf $TARGET_DIR
mkdir -p $TARGET_DIR

echo "Unzipping artifact..."
unzip $APP_DIR/app.zip -d $TARGET_DIR

echo "Copying .env..."
cp $APP_DIR/.env $TARGET_DIR/.env

echo "Restoring persistent storage..."
rm -rf $TARGET_DIR/storage
cp -r $APP_DIR/storage $TARGET_DIR/storage

cd $TARGET_DIR

echo "Fixing permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "Running artisan commands..."
php artisan optimize:clear
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment complete!"
