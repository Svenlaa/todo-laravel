# todo-laravel

##### A simple todo app built in laravel

## Stack

- PHP 8
- Laravel (Blade, Breeze)
- Eloquent ORM
- MySQL
- Tailwind

## Requirements

- php 8
- composer
- node 16
- pnpm

## Run locally

1. Populate the .env file
2. Run the MySQL database
3. Run ```composer install && pnpm i``` to install dependencies
4. Run ```php artisan migrate``` to get the Database into the right shape
5. You need two terminals to run the front-end and the back-end.

**Terminal One**

```shell
php artisan serve
```

**Terminal Two**

```shell
pnpm dev
```

### Credits

Developed by [Svenlaa](https://Svenlaa.com) during an internship at [Bandwerk](https://bandwerk.nl).
