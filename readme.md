Deploy:

```$xslt
composer install
```
Update data in .env file
```
php artisan migration
php artisan db:seed
php artisan storage:link
```
