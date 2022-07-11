include .env

build:
	make stop_services
	make build
	docker-compose -f docker-compose.yml up -d
	docker exec -d $(CONTAINER_PREFIX)_php composer install
	docker exec -d $(CONTAINER_PREFIX)_php chmod -R 777 storage
	docker exec -d $(CONTAINER_PREFIX)_php [ ! -f .env ] \
		&& docker exec -d $(CONTAINER_PREFIX)_php cp -n .env.example .env \
		&& docker exec -d $(CONTAINER_PREFIX)_php php artisan key:generate
	make stop

up:
	make stop_services
	docker-compose -f docker-compose.yml up

stop:
	docker-compose -f docker-compose.yml stop
	make start_services

down:
	docker-compose -f docker-compose.yml down
	make start_services

ex:
	docker exec -it $(CONTAINER_PREFIX)_php /bin/sh

start_services:
	sudo service redis-server start || true
	sudo service postgresql start || true
	sudo service nginx start || true

stop_services:
	sudo service redis-server stop || true
	sudo service postgresql stop || true
	sudo service nginx stop || true

delete_postgresql:
	sudo chmod +rwx posgresql
	sudo rm -rf postgresql

.PHONY: build up stop down ex start_services stop_services delete_postgresql