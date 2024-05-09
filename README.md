# CURSA traceability backend

## Table of contents
* [General info](#general-informations)
* [Technologies](#technologies)
* [Setup](#setup-laravel)

## General informations
This is the backend for the CURSA traceability project for the wood supply chain created in Laravel.

## Technologies
The technologies used for this project are:
* PHP version: 8.1
* Laravel version: 10.10
* Docker version: 4.30.0

## Setup Laravel
After downloading the project you need to create the [.env file](#env-file)
```
$ cp .env.example .env
```
Then you need to generate the porject key
```
$ php artisan key:generate
```
Once you runned the prevoius commands you can run a migration.<br>
This will fill your database with all the necessary tables
```
$ php artisan migrate
```

## env file
