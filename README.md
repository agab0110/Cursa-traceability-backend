# CURSA traceability backend

## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)

## General informations
This is the backend for the CURSA traceability project for the wood supply chain created in Laravel.

## Technologies
The technologies used for this project are:
* PHP version: 8.1
* Laravel version: 10.10
* Docker version: 4.30.0

## Setup
After downloading the project you need to create the [.env file](#.env-file)
```
$ cp .env.example .env
```
Then you need to generate the porject key
```
$ php artisan key:generate
```
Once you runned the prevoius commands you can run a migration.
This will fill your database with all the necessary tables
```
$ php artisan migrate
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## .env-file
