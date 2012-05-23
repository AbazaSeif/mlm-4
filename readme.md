MLM
===
Framework: [Laravel](http://laravel.com/docs)

Setup:
------

1. Clone to whereever you like working from
2. Set up a vhost entry in apache (unless files are in root of webserver)
    For example in the apache/conf/extra/httpd-vhosts.conf file:
    ```
	NameVirtualHost *:80 ## UNCOMMENT THIS LINE
	
    <VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs"
		ServerName localhost
	</VirtualHost>
	
	<VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs/mlm"
		ServerName mlm.dev
	</VirtualHost>
    ```
3. Make config files to `application/config/local/` based on `application/config/`
    1. application.php - Overwrite url
    2. database.php - Database settings
4. `php artisan migrate:install --env=local`
5. `php artisan migrate --env=local`
6. Make account, use the database to turn it into admin
7. ???
8. Profit!