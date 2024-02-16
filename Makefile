build:
	docker-compose -f dev-docker-compose.yml build --no-cache

up:
	docker-compose -f dev-docker-compose.yml up --build -d

down:
	docker-compose -f dev-docker-compose.yml down

remove:
	docker-compose -f dev-docker-compose.yml down --remove-orphans

app_bash:
	#docker-compose -f docker-compose.yml exec -u www-data php bash
	docker-compose -f dev-docker-compose.yml exec php bash


