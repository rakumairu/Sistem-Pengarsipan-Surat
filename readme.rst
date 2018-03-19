###################
Initial Setup
###################
Ubah konfigurasi :
C:\xampp\apache\conf\extra\httpd-vhost.conf
<VirtualHost *:80>
	DocumentRoot "D:htdocs/surat"
	ServerName surat.localhost
	<Directory "D:/htdocs/surat">
		DirectoryIndex index.php
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost>

C:\Windows\System32\drivers\etc
127.0.0.1	surat.localhost
