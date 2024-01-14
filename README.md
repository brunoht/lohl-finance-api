# README

## Websocket Server

Inicie a fila:

```shell
sail artisan queue:work
```
Inicie o servider webosckets

```shell
sail artisan websockets:serve
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

## DEV Commands

It's possible to prepare dev file to be executable:

```shell
chmod +x dev
```

Now, you can run dev command as:

```shell
bash dev [command]
```

```shell
sh dev [command]
```

```shell
./dev [command]
```

### Available Commands

```shell
bash dev up 
```

```shell
bash dev down 
```

```shell
bash dev restart 
```

```shell
bash dev logs 
```
