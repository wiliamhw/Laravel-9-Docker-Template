# Laravel 9 Docker Template
Laravel 9 Docker template using PHP 8.1.6, nginx, redis, and Postgres SQL 14.4.

## Features
* [Docker](https://www.docker.com/)
* [Dockerfile and docker compose V3 with Alpine](https://hub.docker.com/_/alpine)
* [Nginx](https://www.nginx.com)
* [Laravel 9](https://laravel.com/)
* [Postgres 14.4](https://www.postgresql.org/)
* [PHP 8.1.6](https://www.php.net/)
* [PHPStan](https://phpstan.org/)
* [PHP Mess Detector](https://phpmd.org/)
* [PHP Copy/Paste Detector](https://github.com/sebastianbergmann/phpcpd)
* [PHP Coding Standard Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)
* [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)
* [Laravel Telescope](https://laravel.com/docs/9.x/telescope)
* [Prettier](https://prettier.io/)
* [Prettier plugin for PHP](https://github.com/prettier/plugin-php)
* [Github Action](https://github.com/wiliamhw/Laravel-9-Docker-Template/tree/main/.github/workflows)
  * [Static Analysis & Automated Test](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/.github/workflows/build.yml)
  * [Code Formatter](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/.github/workflows/code-check.yml)
* [Makefile](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/Makefile)
* [API Error Handler](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/src/app/Exceptions/Traits/HandleApiExceptions.php)

## Getting Started
### Prerequisites
- Using UNIX-based system.
- Download and Install [Docker](https://docs.docker.com/engine/install/).

### Installation
#### 0. Clone this project

#### 1. Create `.env` file from `.env.example` in root directory
The given configuration will be used by Docker to build the containers.  

If you change `NGINX_PORT` to other than port 8000 or `PHP_PORT` to other than port 9000,
you need to adjust `listen` and `fastcgi_pass` in nginx configuration at 
[`/nginx/default.conf`](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/nginx/default.conf).

For example, if you change `NGINX_PORT` to port 8005 or `PHP_PORT` to port 9005, the
[`/nginx/default.conf`](https://github.com/wiliamhw/Laravel-9-Docker-Template/blob/main/nginx/default.conf) will be filled
like this:
```
server {
	listen 8005;
	...
    
	location ~ \.php$ {
		try_files $uri =404;
		fastcgi_split_path_info ^(.+\.php)(\.+)$;
		fastcgi_pass php:9005;
		...
	}
	...
}
```

#### 2. Run command `make build` on your terminal
This command will build Docker Compose containers.

#### 3. Run command `make up` on your terminal
This command will run Docker Compose containers.

#### 4. Run command `make ex` on your terminal
This command will open PHP container terminal.

#### 5. Adjust `.env` file in `/src` directory
The given DB credentials, DB port, and Redis port in `/src/.env` must be equal to the given values in `/.env`.  
You also need to change `DB_HOST` value in `/src/.env` based on this format: `{CONTAINER_PREFIX}_postgres`.  
You can see the value of `CONTAINER_PREFIX` in `/.env` at the project root directory.

#### 6. Go to [http://localhost:8000/](http://localhost:8000/) or any port you assign to `NGINX_PORT` in the root directory `.env` file
This action will open Laravel application in a web browser.  
If you want to open [Laravel Telescope](https://laravel.com/docs/9.x/telescope) page, you can access
[http://localhost:8000/telescope](http://localhost:8000/telescope) or any port you assign to `NGINX_PORT` in the root directory `.env` file.

## Available Commands
To run NPM or composer command, your terminal need to be inside `src` directory in PHP container terminal.  
To do that, you need to open PHP container terminal by running `make ex` on the project root directory.  
Then, in the PHP container terminal, go to `src` directory by running `cd src`.

### Makefile
>Makefile command can be run on the project root directory, where `Makefile` resides in.
* `make build` : build Docker Compose containers
* `make up` : run Docker Compose containers
* `make stop` : stop Docker Compose containers
* `make down` : remove Docker Compose containers
* `make purge` : remove Postgres SQL volume in host.
* `make ex` : open PHP container terminal
* `make analyse` : run static analysis and store the result in `/src/storage/logs/analyse.log`

### Composer
> Your terminal needs to be inside `src` directory in PHP container terminal.
* `composer test` : run Laravel automated test in parallel
* `composer ide-helper` : run [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)

### NPM
> Your terminal needs to be inside `src` directory in PHP container terminal.
* `npm run format` : reformat code using [Prettier](https://prettier.io/)
* `npm run format:check` : check code format using [Prettier](https://prettier.io/)
