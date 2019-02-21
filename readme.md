Deploy:

```$xslt
composer install
```
For production:
```$xslt
composer install --optimize-autoloader --no-dev
```
Update data in .env file

Run:
```
php artisan migrate
php artisan storage:link
php artisan db:seed
php artisan route:cache
php artisan config:cache

```
Bower install:
```
cd public 
bower install
```
