composer-env-file:
	@if [ ! -f .env.local ]; then echo '' > .env.local; fi

reload: composer-env-file
	docker-compose exec php-fpm kill -USR2 1
	docker-compose exec nginx nginx -s reload

lint:
	docker exec -u root bowling_kata_pop-backend_php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --allow-risky=yes --dry-run

# 🐳 Docker Compose
.PHONY: start
start: CMD=up --build -d

up:
	docker compose up

.PHONY: stop
stop: CMD=stop

.PHONY: destroy
destroy: CMD=down

.PHONY: build
build: start deps

rebuild: composer-env-file
	docker-compose build --pull --force-rm --no-cache
	make start
	make deps

.PHONY: doco
doco start stop destroy: composer-env-file
	UID=${shell id -u} GID=${shell id -g} docker-compose $(CMD)

deps:
	docker exec -u root bowling_kata_pop-backend_php composer install
	docker exec -u root bowling_kata_pop-backend_php npm install

ping-mysql:
	docker exec -u root bowling_kata_pop-mysql mysqladmin --user=root --password= --host "127.0.0.1" ping --silent

composer-up:
	docker exec -u root bowling_kata_pop-backend_php composer up

.PHONY: test
test:
	docker exec -u root bowling_kata_pop-backend_php ./vendor/bin/phpunit