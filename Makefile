build:
	docker compose build --no-cache

up:
	docker-compose -f docker-compose.yml up --build -d

down:
	docker-compose -f docker-compose.yml down

remove:
	docker compose down --remove-orphans

app_bash:
	#docker-compose -f docker-compose.yml exec -u www-data php bash
	docker-compose -f docker-compose.yml exec php bash


