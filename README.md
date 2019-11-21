# DOCKER

```
If you have knowledge, use docker with configs
and images as you want.

If don't, you can follow these instructions.
```

All files below need to be in same folder.
One folder named htdocs need to be created too.

## docker-compose.yml

```
version: '3'

services:
  appserver:
    image: periscuelo/node-vue-cli
    restart: always
    working_dir: /data/app/
    command: bash -c "ncu -u && npm i || true && vue ui"
    stdin_open: true
    tty: true
    environment:
    CHOKIDAR_USEPOLLING: 'true'
    CHOKIDAR_INTERVAL: 300
    ports:
      - 8000:8000
    volumes:
      - ./htdocs/test_tewone:/data/app
      - /data/app/node_modules
    depends_on:
      - apiserver
  apiserver:
    image: periscuelo/php-apache-ssl
    restart: always
    stdin_open: true
    tty: true
    ports:
      - 8080:80
      - 443:443
    volumes:
      - ./htdocs:/var/www/html
      - ./php.ini:/usr/local/etc/php/php.ini
      - ./vhost.conf:/etc/apache2/sites-available/000-default.conf
    depends_on:
      - db
  db:
    image: mysql
    command: --default-authentication-plugin=mysql_native_password
    restart: always
    stdin_open: true
    tty: true
    ports:
      - 3306:3306
    environment:
    MYSQL_ROOT_PASSWORD: root
    volumes:
      - ./my.cnf:/etc/mysql/conf.d/my.cnf #this line only needed in dockertoolbox
      - ../mysql:/var/lib/mysql
```

## php.ini

Here comes a PHP config as you need

```
max_execution_time = 32000
post_max_size = 60M
upload_max_filesize = 60M
date.timezone = America/Sao_Paulo
```

## vhost.conf

```
# Vhosts for Laravel.
# Change myproject to your respective folder name
# And uncomment the virtualhost below removing the '#'.
<VirtualHost *:80>
  ServerName localhost
  DocumentRoot /var/www/html/test_tewone/api/public
  <Directory /var/www/html/test_tewone/api/public/>
      AllowOverride All
      Require all granted
  </Directory>
</VirtualHost>

```

## my.cnf

Only if you use dockertoolbox, you need of this file in read-only mode

```
[mysqld]
innodb_use_native_aio=0
```

## Observations

Inside htdocs folder, do the `$ git clone` of project.
After, in this folder with all these files ans the folder htdocs, you need run a command:

`$ docker-compose up -d`

You should connect in the PHP container for install the API like will be explained below.
If you need more help with `docker`, the `docker` docummentation can help you.

[https://docs.docker.com/](https://docs.docker.com/)

[https://hub.docker.com/r/periscuelo/php-apache-ssl](https://hub.docker.com/r/periscuelo/php-apache-ssl)

[https://hub.docker.com/r/periscuelo/node-vue-cli](https://hub.docker.com/r/periscuelo/node-vue-cli)

# API

## Install
```
Inside docker api folder use:
composer install
composer global require phpunit/phpunit
```

## Unit Tests

After install, run command below

`phpunit`
