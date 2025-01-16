# About this project

Backend CRUD transactions  
FE stack: Blade
BE stack: Laravel 11, MySQL

## Requirements

-   MySQL Database
-   PHP 8.2^

## Instalation step

1. Install php dependency `composer install`
2. Configure `.env` setting, copy dari `.env.example` sesuaikan dengan env
3. Generate laravel key `php artisan key:generate`
4. Run database migration `php artisan migrate`
5. Run database seeder `php artisan db:seed`
6. Create sym link as we want to access image from storage `php artisan storage:link`
7. Run queue worker `php artisan queue:work`

The credential from user seeder is `test@example.com` and the password: `password`
