reload:
	docker-compose exec php-fpm kill -USR2 1
	docker-compose exec nginx nginx -s reload

lint:
	docker exec bowling_kata_pop-backend_php ./vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --allow-risky=yes --dry-run

# 🐳 Docker Compose
build:
	docker compose build

start:
	docker compose up -d
	make deps

deps:
	docker exec bowling_kata_pop-backend_php composer install
	docker exec bowling_kata_pop-backend_php npm install

rebuild:
	docker-compose build --pull --force-rm --no-cache
	make start
	make deps

ping-mysql:
	docker exec bowling_kata_pop-mysql mysqladmin --user=root --password= --host "127.0.0.1" ping --silent

composer-up:
	docker exec bowling_kata_pop-backend_php composer up
