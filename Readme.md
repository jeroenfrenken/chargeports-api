# Chargeports Api

## Setting up Project

### Running application locally
`docker-compose up -d`

This command will start the docker containers. And you can access the application on http://localhost:80

### Running commands 

`docker exec -it chargeports_app bash`

This will start a shell session into the php container where you can do composer related commands. And access the php bin/console commands from symfony

### Install composer dependencies

In the docker container execute 

`composer install`

### Running Migrations

In the docker container execute 

`php bin/console doctrine:migrations:migrate`

Say `yes`

### Running Fixtures
This will load a couple of thousand chargers in the database

In the docker container execute

`php bin/console doctrine:fixtures:load`

Say `yes`

### Access OpenApi UI

You can view the api documentation under `http://localhost/api/doc`

## Development

- Please create OpenApi documentation for each api call
- Create a new branch off master and create a pull request before merging master
- Use latest PHP 7.4 functionality 

## Debugging

### bad gateway error
PHP has crashed. Execute `composer install` in the docker container this will also trigger the cache clear command and 
this will show the error. 
