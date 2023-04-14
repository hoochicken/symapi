# Setup

## 1. Docker starten

~~~
docker-compose up
~~~

## 2. Create Database

E. g. via [postgres-admin](http://pgaalpha5.localhost)<br />
Create the following:

| #        | value              |
|----------|--------------------|
| host     | postgres_container |
| port     | 5432               |
| username | alpha5             |

Alternatively login into docker container and create db via cmd.

~~~
# login via docker container id
docker exec -it [dockerContainerId] bash

# OR login via docker-compose service name
docker-compose exec symapi bash

# will create db according to settings in config/packages/doctrine.yaml
bin/console doctrine:database:create
~~~

## 3. Create additional Database User for Symfony

| #          | value      |
|------------|------------|
| user       | symfony    |
| password   | changeme   |
| privileges | all rights |

## 4. Create Tables via migrations

~~~
bin/console doctrine:migrations:migrate
~~~

## 5. Load Fixtures

~~~
# load fixtures
bin/console doctrine:fixtures:load
~~~

## 6. Checkup

~~~
# phpunit in console
php vendor/phpunit/phpunit/phpunit
~~~

* Go to <http://symapi.localhost/> in your browser, should display a json with word list.
* Go to <http://symapi.localhost/test> in your browser, should display a json with word list.bin

# doctrine

~~~
php bin/console config:dump-reference doctrine
php bin/console debug:config doctrine
php bin/console cache:clear
php bin/console doctrine:cache:clear-metadata 
php bin/console doctrine:cache:clear-query  
php bin/console doctrine:cache:clear-result
php bin/console doctrine:database:create
php bin/console make:entity
~~~

# Run

**Api**
~~~
docker-compose up
~~~


**App**
~~~
docker build -t vueapp .
docker run -v ${PWD}:/app -v /app/node_modules -p 8083:8080 --rm vueapp
docker run -v ${PWD}:/app -v /app/node_modules -p 8083:8080 vueapp # ????
~~~

~~~
docker build -t vueapp:dev .
npm run serve
~~~

=> http://localhost:3000/

# Tests

~~~
# phpunit in console
php vendor/phpunit/phpunit/phpunit

# api tests
composer run test:api

# concept create new test
php vendor/bin/codecept generate:cest api CreateUser
~~~


# Fixtures

~~~
# load fixtures
php bin/console doctrine:fixtures:load
~~~

# Doctrine reminder

~~~
php bin/console doctrine:database:create
php bin/console make:entity
php bin/console make:migration
php bin/console doctrine:migrations:migrate
~~~
