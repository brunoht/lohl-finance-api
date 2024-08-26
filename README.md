# Lohl Finance API

Lohl Finance's backend service. Serves the REST API and Websocket.

Developed using **[Laravel](https://laravel.com/) + [Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction)**.

## Requisites

### Linux
- Linux Ubuntu 20 or superior
- Docker
- Docker Composer

### Windows

- WSL2
- Ubuntu
- Docker Desktop

### VSCode

- Install [REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client) extension

## Install

### Install PHP

```shell
sudo apt update && sudo apt upgrade
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.2-fpm
sudo apt install php8.2-mysql php8.2-mbstring php8.2-xml php8.2-gd php8.2-curl php8.2-cli unzip
```

### Install Composer

```shell
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

### Environment 

```shell
cp .env.example .env
php artisan key:generate
php composer install
chmod +x sail && chmod +x dev
```

### Preparar a rede virtual do Docker

```shell
docker network create -d bridge shared-network
```

## Dev Environment

> The following commands must be executed from a Linux Terminal. On Windows,
run it by using WSL terminal.

### Start containers

```shell
. dev up
```

On the first time, run database migration:

```shell
. sail artisan migrate
. sail artisan jwt:secret
```

### Websocket Server

Starts the queue:

```shell
. sail artisan queue:work
```

Starts webosckets' server

```shell
. sail artisan websockets:serve
```

## Configuring A Shell Alias

By default, Sail commands are invoked using the vendor/bin/sail script that is included with all new Laravel applications:

```shell
./vendor/bin/sail up
```

However, instead of repeatedly typing vendor/bin/sail to execute Sail commands, you may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```shell
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

## All available commands

Starts container:

```shell
. dev up
```

---

Finishes container

```shell
. dev down
```

---

Restarts container

```shell
. dev restart
```

---

Shows a container's real-time log

```shell
. dev logs
```

---

Starts the container shell CLI

```shell
. dev exec
```

---

Sail

```shell
. sail
```

---

## Sail Commands

Under the hood, it uses "Laravel Sail," so all Sail commands can be accessed normally.

```shell
./vendor/bin/sail --help
```

or (if you added sail alias to your terminal) 

```shell
sail --help
```

also, you can call sail from dev cli:

```shell
. sail --help
```
