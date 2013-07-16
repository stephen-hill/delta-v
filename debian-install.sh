apt-get install php5-cgi mysql-server apache2 php5-memcache php5-mysql libapache2-mod-fcgid
a2enmod actions fcgid cgid rewrite
cp apache2-site /etc/apache2/sites-available/delta-v
a2dissite default
a2ensite delta-v