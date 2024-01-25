# Lohl Finance API

Lohl Finance's backend service. Serves the REST API and Websocket.

Developed using **[Laravel](https://laravel.com/) + [Websockets](https://beyondco.de/docs/laravel-websockets/getting-started/introduction)**.

## Dev Environment

> The following commands must be executed from a Linux Terminal. On Windows,
run it by using WSL terminal.

### Start containers

```shell
bash dev up
```

### Websocket Server

Starts the queue:

```shell
bash dev sail "artisan queue:work"
```

Starts webosckets' server

```shell
bash dev sail "artisan websockets:serve"
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
bash dev up
```

---

Finishes container

```shell
bash dev down
```

---

Restarts container

```shell
bash dev restart
```

---

Shows a container's real-time log

```shell
bash dev logs
```

---

Starts the container shell CLI

```shell
bash dev exec
```

---

Sail

```shell
bash dev sail "command"
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
bash dev sail "--help"
```
