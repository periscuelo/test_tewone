# DOCKER

```
If you have knowledge, use docker with configs
and images as you want.

If don't, you can follow these instructions.
```

All files below need to be in same folder.  
One folder named htdocs need to be created.  
One folder named mysql need to be created too.

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
      - 8080:8080
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
      - 80:80
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
    environment:
      MYSQL_ROOT_PASSWORD: root
    ports:
      - 3306:3306
    volumes:
      - ./my.cnf:/etc/mysql/conf.d/my.cnf #this line only needed in dockertoolbox
      - ./mysql:/var/lib/mysql
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

## .env file

Rename your .env.example to .env  
Generate your APP_KEY to use in .env  
Use the example below

```
APP_NAME=API
APP_ENV=local
APP_KEY=putyourkeyhere
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=America/Sao_Paulo

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=tewone
DB_USERNAME=root
DB_PASSWORD=root
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_general_ci

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## Install
```
Inside docker terminal, in api folder use:
composer install
composer global require phpunit/phpunit
php artisan db:create
php artisan migrate
php artisan db:seed
```

## Unit Tests

After install, run command below

`phpunit`

## URL to Access

`http://localhost`

# APP

## Project setup
```
Inside docker terminal, in app folder use:
npm install
```

### Compiles and hot-reloads for development
```
Inside docker terminal, in app folder use:
npm run serve
```

### Compiles and minifies for production
```
Inside docker terminal, in app folder use:
npm run build
```

## URL to Access Vue UI

`http://localhost:8000`


## URL to Access

`http://localhost:8080`

