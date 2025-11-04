<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About The Project

This is a Laravel application that uses scheduled jobs to perform tasks.

## Getting Started

### Prerequisites

* PHP >= 8.2
* Composer
* Node.js
* NPM

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/your_username/your_project.git
   ```
2. Install PHP dependencies
   ```sh
   composer install
   ```
3. Install NPM packages
   ```sh
   npm install
   ```
4. Create a copy of your .env file
   ```sh
   cp .env.example .env
   ```
5. Generate an app encryption key
   ```sh
   php artisan key:generate
   ```
6. Create an empty database and add your database credentials in your .env file
7. Run the database migrations
   ```sh
   php artisan migrate
   ```

## Running the Application

To run the application, you can use the following command:

```sh
php artisan serve
```

## Setting up the Scheduler

To set up the scheduler, you will need to add the following cron entry to your server.

```sh
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Running the Queue Worker

To run the queue worker, you can use the following command:

```sh
php artisan queue:work
```

You can also specify the queue connection and the queue name.

```sh
php artisan queue:work redis --queue=high,default
```

You can also run the queue worker in the background using a process monitor like Supervisor.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
