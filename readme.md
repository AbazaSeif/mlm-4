MLM
===
Framework: [Laravel](http://laravel.com/docs)

Setup:
------

0. Read up on [Laravel documentation about installation](http://laravel.com/docs/install) (includes requirements for server)
1. Clone to whereever you like working from
2. Set up a vhost entry in apache (unless files are in root of webserver)
    For example in the apache/conf/extra/httpd-vhosts.conf file (based on xampp):
    ```
	NameVirtualHost *:80 ## UNCOMMENT THIS LINE
	
    <VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs"
		ServerName localhost
	</VirtualHost>
	
	<VirtualHost *:80>
		DocumentRoot "C:/xampp/htdocs/mlm/public"
		ServerName mlm.dev
	</VirtualHost>
    ```
3. Make config files to `application/config/local/` based on `application/config/` (remember what was mentioned in the laravel installation docs here, if your copy isn't hosted on *.dev address or localhost, add yourself in `/paths.php`)
    1. application.php - Overwrite url
    2. database.php - Database settings
    3. openid.php - Openid settings
4. Install database to keep track of migrations: `php artisan migrate:install --env=local`
5. `php artisan migrate --env=local`
6. Make an account, use the database to turn it into admin
7. ???
8. Profit!