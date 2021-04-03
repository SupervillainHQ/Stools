#!/usr/bin/env bash
#

update-alternatives --set editor /usr/bin/vim.basic

apt-get update
apt-get upgrade -y

# mongo (https://docs.mongodb.com/manual/tutorial/install-mongodb-on-ubuntu/)
wget -qO - https://www.mongodb.org/static/pgp/server-4.4.asc | sudo apt-key add -
echo "deb [ arch=amd64,arm64 ] https://repo.mongodb.org/apt/ubuntu bionic/mongodb-org/4.4 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.4.list
apt-get update

# php specific version
add-apt-repository -y ppa:ondrej/php

#apt-get install -y apache2
apt-get install -y php7.4 php7.4-psr php7.4-phalcon php7.4-cli php7.4-curl php7.4-gd php7.4-intl php7.4-mbstring php7.4-xml php7.4-xsl php7.4-zip php7.4-xdebug
#apt-get install -y  php7.4-fpm
#apt-get install -y php7.4-mysql
apt-get install -y php7.4-mongodb
apt-get install -y php-msgpack php-gettext php-redis

apt-get install -y redis-server
apt-get install -y mongodb-org

#a2enmod actions alias proxy_fcgi

#service php7.4-fpm restart
#service apache2 restart

#unlink /etc/apache2/sites-enabled/000-default.conf
#ln -fs /var/www/andkrup.dk/vagrant/apache.conf /etc/apache2/sites-enabled/andkrup.dk.conf
#ln -fs /var/www/andkrup.dk/vagrant/php7.4-fpm.ini /etc/php/7.4/fpm/php.ini
ln -fs /var/www/andkrup.dk/vagrant/php7.4-cli.ini /etc/php/7.4/cli/php.ini

# phpunit
wget https://phar.phpunit.de/phpunit.phar -O /usr/local/bin/phpunit
chown root:root /usr/local/bin/phpunit
chmod +x /usr/local/bin/phpunit

# download & install composer
curl -sS http://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chown root:root /usr/local/bin/composer
chmod +x /usr/local/bin/composer