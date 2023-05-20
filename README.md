## Laravel Test Project

This is a simple RESTful API built with Laravel for managing package registrations.

## Requirements

- PHP >= 8.0
- Composer
- MySQL
- Laravel 10

## Installation
Follow these steps to set up the project:

1. Clone the repository

```
git clone git@github.com:NikaIlir/laravel-test-project.git
```
2. Navigate into the project directory
```
cd laravel-test-project
```
3. Install Composer dependencies
```
composer install
```
4. Rename or copy `.env.example` file to `.env`
```
cp .env.example .env
```
5. Update .env to set your database credentials
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=user_name
DB_PASSWORD=password
```
6. Generate application key
```
php artisan key:generate
```
7. Run the migrations to create the necessary tables in the database
```
php artisan migrate
```
8. Seed the database with test data
```
php artisan db:seed
```

## API Endpoints

- User Registration: `POST /api/register`
- User Login: `POST /api/login`

Authenticated endpoints:
- List of Packages: `GET /api/packages`
- Register to a Package: `POST /api/registration/{package:uuid}`

## Testing
This project uses PHPUnit for testing. You can run the tests with:
```
php artisan test
```
