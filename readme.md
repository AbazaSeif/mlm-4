MLM
===
Framework: [Laravel](http://laravel.com/docs)

Setup:
------

1. Clone to whereever you like working from
2. Set up a vhost entry in apache (unless files are in root of webserver)
    For example:
    ```
    <VirtualHost *:80>
    	ServerAdmin postmaster@mlm.dev
    	DocumentRoot "C:/xampp/htdocs/mlm"
    	ServerName mlm.dev
    	ServerAlias www.mlm.dev
    	ErrorLog "logs/mlm.dev-error.log"
    	CustomLog "logs/mlm.dev-access.log" combined
	</VirtualHost>
    ```
3. Make config files to `application/config/local/` based on `application/config/`
    1. application.php - Overwrite url
    2. database.php - Database settings
4. `php artisan migrate:install`
5. `php artisan migrate`
6. Make account, use the database to turn it into admin
7. ???
8. Profit!