# ZAHOSPITAL ADMIN

Hospital Registration App - Final Project Database System 2022

![](https://user-images.githubusercontent.com/85225804/205470436-2541935e-e9bc-4af0-b886-bd921d568917.png)

## Installation

Clone Repository:

```sh
git clone https://github.com/FahrezaIsnanto/zahospitaladm.git zahospitaladm
cd zahospitaladm
```

Install PHP dependencies:

```sh
composer install
```

Install NPM dependencies:

```sh
npm ci
```

Build assets:

```sh
npm run dev
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Run database migrations:

```sh
php artisan migrate
```

Run database seeder:

```sh
php artisan db:seed
```

Run the dev server

```sh
php artisan serve
```

Run the dev server (with sail)

```sh
sail up -d
```

Visit ZAHOSPITAL ADMIN in your browser, and login with:

- **Username:** zahosadm
- **Password:** testadm
