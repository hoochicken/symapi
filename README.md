# Symfony API

## Setup

1. Docker starten
~~~
docker-compose up
~~~

2. Create Database

E. g. via [postgres-admin](http://pgaalpha5.localhost)<br />
Create the following:

| #        | value              |
|----------|--------------------|
| host     | postgres_container |
| port     | 5432               |
| username | alpha5             |
| username | alpha5             |

# doctrine

~~~
php bin/console config:dump-reference doctrine
php bin/console debug:config doctrine
php bin/console cache:clear
php bin/console doctrine:cache:clear-metadata 
php bin/console doctrine:cache:clear-query  
php bin/console doctrine:cache:clear-result
php bin/console doctrine:database:create
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
