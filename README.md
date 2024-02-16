
## Installation
```bash
make build
```
```bash
make up
```
Заходим в контейнер :
```bash
make app_bash
```
В нутри контейнера
```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
unittest
```
php bin/phpunit
```
Примеры запросов в http.test

[http://localhost:8080/](http://localhost:8080/)