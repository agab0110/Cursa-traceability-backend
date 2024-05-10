# CURSA traceability backend

## Table of contents
* [1 General info](#1-general-informations)
* [2 Technologies](#2-technologies)
* [3 Setups](#3-setups)
    * [3.1 Setup php.ini](#31-setup-phpini)
    * [3.2 Setup Laravel](#32-setup-laravel)
    * [3.3 Setup Docker](#33-setup-docker)
    * [3.4 Setup .env file](#34-env-file)
* [4 Useful commands](#4-useful-commands)
    * [4.1 How to Use Laravel Tinker](#41-how-to-use-laravel-tinker)

## 1 General informations
This is the backend for the CURSA traceability project for the wood supply chain created in Laravel.

## 2 Technologies
The technologies used for this project are:
* PHP version: 8.1
* Laravel version: 10.10
* Docker version: 4.30.0

## 3 Setups

## 3.1 Setup php.ini
The php.ini file is a special file for PHP. It is where you declare changes to your PHP settings. You can find it in your PHP directory<br>
Here we can find the extensions used by PHP, you should find them at line 915.<br>
For our project we need the following extentions:
* curl
* fileinfo
* mbstring
* openssl
* pdo_mysql
* sodium

If you have these extensions commented please remove the ; before them to activate them

## 3.2 Setup Laravel
After downloading the project you need to create the [.env file](#34-env-file):
```
cp .env.example .env
```
Then you need to generate the project key:
```
php artisan key:generate
```

Open .env file and change *DB_HOST* to *mysql*

After that you need to install the dependencies from the composer.json:
```
composer install
```

## 3.3 Setup Docker
First thing to do is to download **Docker deskop**, you can download it from here: https://www.docker.com/products/docker-desktop/. <br>
<br>
If you already have Docker installed on you computer check if your version is the latest, if not then you need to upgrade it.

Open Docker desktop for the next phase.

After this you need to install a WSL. This will require the creation of an account with username and password.<br>
Please **remember** the password because you will need it for the sudo command.
In your Windows poweshell or CMD run:
```
wsl --install
```
After the installation you need to add your WSL user to the Docker group.<br>
Open a WSL terminal and run:
```
sudo usermod -aG docker $USER
```
To see if the operation was successful you can run from your WSL terminal:
```
groups
```
And if you see **docker** in the output than you can continue.<br>
<br>
Always remaining in the WSL terminal you can also check the status of docker with:
```
docker info
```
After all this you can create the Docker container.<br>
Open a WSL terminal in your Laravel project and run:
```
./vendor/bin/sail up
```
Then you need to run migrations using:
```
./vendor/bin/sail artisan migrate
```

## 3.4 .env file
The .env file is a configuration file that allows developers to define environment-specific configuration variables such as database credentials, API keys, and other settings without hardcoding them into the application code.<br>
It is created when creating a new Laravel project or when you [setup](#32-setup-laravel) an existing one.


The foundamental things we need are:
* APP_KEY: generated when you create the project or setup an existing one
* DB_CONNECTION: usually *mysql* but depends on the used database
* DB_HOST: it is *localhost* on default
* DB_PORT: the port to database connection  
* DB_DATABASE: the database name
* DB_USERNAME: the username used for the database connection
* DB_PASSWORD: the password used for the database connection
* MAIL_MAILER: the type of server used to send emails (default smtp)
* MAIL_HOST: the host used to send emails
* MAIL_PORT: the port used to send emails
* MAIL_USERNAME: the username of your mail host
* MAIL_PASSWORD: the password of your mail host
* MAIL_FROM_ADDRESS: the address shown when emails arrive
* MAIL_FROM_NAME: the name shown when emails arrive

**NOTICE**
The setup for the emails usually comes from your email host

## 4 Useful commands
To display the list of the possible creations:
```
php artisan make -h
```
A Model is a PHP class which rappresent a database table.<br>
To create a Model:
```
php artisan migrate make:model <model name>
```
A Controller is a PHP class responsable for handling incoming requests, processing data and providing appropriate responses.<br>
To create a Controller:
```
php artisan migrate make:controller <controller name>
```
A Migration is a PHP class used to manage changes to the structure of a database schema.<br>
To create a Migration:
```
php artisan migrate make:migration <migration name>
```
To run a Migration:
```
php artisan migrate
```
A Factory is a PHP class that is used to create fake data or Model instance for use in testing.<br>
Those classes are used with [Laravel Tinker Shell](#41-how-to-use-laravel-tinker).<br>
To create a Factory
```
php artisan make:factory <factory name>
```
A Request is a PHP class that encapsulates an HTTP request, providing methods for accessing and validating the request data.<br>
To create a request:
```
php artisan make:request <request name>
```
A seeder is a PHP class that can be used to insert some data into the database.<br>
A seeder works for **one and only one** class.<br>
To create a seeder:
```
php artisan make:seeder <seeder name>
```
To use the seeder:
```
php artisan db:seed --class=<Seeder Class Name>  
```
Usually each model corresponds to a migration, so we can create a model with -m flag to generate the corresponding migration:
```
php artisan migrate make:model <model name> -m
```
If you want to add a corresponding controller and migration:
```
php artisan migrate make:model <model name> -mc
```
If you want to create a Model with the corrisponding Factory:
```
php artisan make:model <model name> -f
```

### 4.1 How to use Laravel Tinker
Laravel Tinker provides an interactive shell that allows developers to interact with their Laravel application using Laravel's Eloquent ORM (Object-Relational Mapping) and other components.

To enter Laravel Tinker shell:
```
php artisan tinker
```
To create a Model instance:
```
$user = User::Factory()->create();
```
To create more than one Model instance:
```
$user = User::Factory()->count(number)->create();
```
