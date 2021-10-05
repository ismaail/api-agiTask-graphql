.PHONY: up start stop down reboot artisan migrate seed composer tests fix-permissions ide-helper cache-clear nginx-reload

# Set dir of Makefile to a variable to use later
MAKEPATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PWD := $(dir $(MAKEPATH))
CONTAINER_FPM := "api-agitask_fpm"
CONTAINER_NGINX := "api-agitask_web"
UID := 1000
COMPOSE_PROJECT_NAME := "api-agitasks"

up:
	docker-compose -p $(COMPOSE_PROJECT_NAME) up -d

start:
	docker-compose -p $(COMPOSE_PROJECT_NAME) start

stop:
	docker-compose -p $(COMPOSE_PROJECT_NAME) stop

down:
	docker-compose -p $(COMPOSE_PROJECT_NAME) down

reboot:
	docker-compose -p $(COMPOSE_PROJECT_NAME) down && docker-compose -p $(COMPOSE_PROJECT_NAME) up -d

cmd=""
artisan:
	docker exec -it \
		-u $(UID) \
		$(CONTAINER_FPM) \
		php artisan $(cmd) -vvv \
		2>/dev/null || true

migrate:
	docker exec -it \
		-u $(UID) \
		$(CONTAINER_FPM) \
		php artisan migrate --step \
		2>/dev/null || true

migrate-fresh:
	docker exec -it \
			-u $(UID) \
			$(CONTAINER_FPM) \
			php artisan migrate:fresh \
			2>/dev/null || true

seed:
	docker exec -it \
		-u $(UID) \
		$(CONTAINER_FPM) \
		php artisan db:seed \
		2>/dev/null || true

cmd=""
composer:
	docker exec -it \
		-u $(UID) \
		-e XDEBUG_MODE=off \
		$(CONTAINER_FPM) \
		composer $(cmd) \
		2>/dev/null || true

tests:
	docker exec -it \
		-u $(UID) \
		$(CONTAINER_FPM) \
		php ./bin/phpunit --do-not-cache-result \
		2>/dev/null || true

fix-permissions:
	docker exec -it $(CONTAINER_FPM) chown -R 1000:100 ./bootstrap 2>/dev/null || true && \
	docker exec -it $(CONTAINER_FPM) chown -R 1000:100 ./storage/logs 2>/dev/null || true && \
	docker exec -i $(CONTAINER_FPM) find ./vendor -type d -exec chmod 755 {} \; 2>/dev/null || true && \
	docker exec -i $(CONTAINER_FPM) find ./vendor -type f -exec chmod 644 {} \; 2>/dev/null || true

ide-helper:
	docker exec -it -u $(UID) $(CONTAINER_FPM) php artisan ide-helper:generate 2>/dev/null || true && \
	docker exec -it -u $(UID) $(CONTAINER_FPM) php artisan ide-helper:models --nowrite 2>/dev/null || true

cache-clear:
	docker exec -it -u $(UID) $(CONTAINER_FPM) php artisan cache:clear 2>/dev/null || true && \
	docker exec -it -u $(UID) $(CONTAINER_FPM) php artisan config:clear 2>/dev/null || true && \
	docker exec -it -u $(UID) $(CONTAINER_FPM) php artisan view:clear 2>/dev/null || true
#	docker exec -it -u $(UID) $(CONTAINER_FPM) php cachetool.phar opcache:reset 2>/dev/null || true

nginx-reload:
	docker kill -s HUP $(CONTAINER_NGINX) 2>/dev/null || true

fpm-reload:
	docker exec -it $(CONTAINER_FPM) kill -USR2 1
