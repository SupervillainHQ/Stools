#!/usr/bin/env bash
#

update-alternatives --set editor /usr/bin/vim.basic

apt-get update
apt-get upgrade -y

# alternate nodejs install, fixing some problems with NodeJs v.4.2.6 on Ubuntu 16.04 (see https://stackoverflow.com/questions/46360567/error-npm-is-known-not-to-run-on-node-js-v4-2-6)
curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -

# mongo (https://docs.mongodb.com/manual/tutorial/install-mongodb-on-ubuntu/)
wget -qO - https://www.mongodb.org/static/pgp/server-4.4.asc | sudo apt-key add -
echo "deb [ arch=amd64,arm64 ] https://repo.mongodb.org/apt/ubuntu bionic/mongodb-org/4.4 multiverse" | sudo tee /etc/apt/sources.list.d/mongodb-org-4.4.list
apt-get update

# php specific version
add-apt-repository -y ppa:ondrej/php

apt-get install -y php7.4 php7.4-psr php7.4-phalcon php7.4-cli php7.4-curl php7.4-gd php7.4-intl php7.4-mbstring php7.4-xml php7.4-xsl php7.4-zip php7.4-xdebug
apt-get install -y php7.4-mongodb
apt-get install -y php7.4-sqlite3
apt-get install -y php-msgpack php-gettext php-redis

apt-get install -y redis-server
apt-get install -y mongodb-org
apt-get install -y gettext nodejs zip

systemctl enable mongod

service mongod restart

#unlink /etc/apache2/sites-enabled/000-default.conf
ln -fs /opt/wsTools/vagrant/php7.4-cli.ini /etc/php/7.4/cli/php.ini

# phpunit
wget https://phar.phpunit.de/phpunit.phar -O /usr/local/bin/phpunit
chown root:root /usr/local/bin/phpunit
chmod +x /usr/local/bin/phpunit

# codecept
wget https://codeception.com/codecept.phar -O /usr/local/bin/codecept
chown root:root /usr/local/bin/codecept
chmod +x /usr/local/bin/codecept

# download & install composer
curl -sS http://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chown root:root /usr/local/bin/composer
chmod +x /usr/local/bin/composer