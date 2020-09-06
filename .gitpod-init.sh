mysql -u root -e "create database laravel"
mysql -u root -e "alter user root@localhost identified by 'root'"
cp src/.env.example src/.env
sed -i "s|APP_URL=|APP_URL=${GITPOD_WORKSPACE_URL}|g" src/.env
sed -i "s|APP_URL=https://|APP_URL=https://8000-|g" src/.env
cd src
composer install
npm install
php artisan key:generate
php artisan migrate --seeder