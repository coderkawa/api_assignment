# Project Title

Car Safety Ratings API

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Installing

Clone the git repo

```
git clone git@github.com:coderkawa/api_assignment.git
```

Run composer install

```
composer install
```

Copy the .env.example file to .env in the application root directory

```
sudo cp .env.example .env
```

Generate the laravel application key

```
php artisan key:generate
```

Add the following line to the .env file (application root directory)

```
NHTSA_API_URL=https://one.nhtsa.gov/webapi/api/SafetyRatings/
```

Configure the apache/nginx document root to point to the public directory in the application root folder

Restart apache/nginx

Run the following commands in the application root directory

```
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
```


## Built With

* [PHP 7.0.22]
* [Laravel 5.5]

## Development Enviroment
* [Ubuntu 16.04]
* [Apache 2.4.18]
* [Sublime 3]
