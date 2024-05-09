# CURSA traceability backend

## Table of contents
* [General info](#general-informations)
* [Technologies](#technologies)
* [Setup Laravel](#setup-laravel)
* [Setup Docker](#setup-docker)

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
## Setup Docker
First thing to do is to download **Docker deskop**, you can download it from here: https://www.docker.com/products/docker-desktop/. <br>
<br>
If you already have Docker installed on you computer than check if your version is the latest, if not then you need to upgrade it.

After this you need to install a WSL. This will require the creation of an account with username and password.<br>
Please **remember** the password because you will need it.
```
$ wsl --install
```
After the installation you need to add your WSL user to the Docker group
```
$ sudo usermod -aG docker $USER
```

## env file
