MLM
===
Framework: [Laravel](http://laravel.com/docs)

Setup:
------

1. Clone to whereever you like working from
2. Make config files to `application/config/local/` based on `application/config/`
    1. For example: database.php - Database settings
    2. If in a subdirectory of webserver also overwrite url in application.php 
3. `php artisan migrate:install`
4. `php artisan migrate`
5. Make account, use the database to turn it into admin
6. ???
7. Profit!