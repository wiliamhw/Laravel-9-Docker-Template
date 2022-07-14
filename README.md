# Laravel 9 Docker Template
Laravel 9 Docker template with github workflows.

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

## Getting Started
### Prerequisites
- Using UNIX-based system.
- Download and Install [Docker](https://docs.docker.com/engine/install/).

### Installation
#### 1. Create `.env` file in root directory. 
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
#### 3. Run command `make up` on your terminal
#### 4. On other terminal, run `make ex` to open the PHP container's terminal
#### 5. Adjust `.env` file in `/src` directory
#### 6. Go to [http://localhost:8000/](http://localhost:8000/) or any port you assign to `NGINX_PORT` in the root directory `.env` file

## Available Commands
### Makefile (only available on UNIX-based system)
* `make build` : build Docker Compose containers
* `make up` : run Docker Compose containers
* `make stop` : stop Docker Compose containers
* `make down` : remove Docker Compose containers
* `make purge` : remove Postgres SQL volume in host.
* `make ex` : open PHP container terminal
* `make analyse` : run static analysis and store the result in `/src/storage/logs/analyse.log`

### Composer
* `composer test` : run Laravel automated test in parallel
* `composer ide-helper` : run [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper)

### NPM
* `npm run format` : reformat code using [Prettier](https://prettier.io/)
* `npm run format:check` : check code format using [Prettier](https://prettier.io/)
