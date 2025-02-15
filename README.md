# LUMEN API BOILERPLATE
A lumen application with docker containers for php, mysql and nginx. Using migration and seeders. User basic routes with JWT configurations and Bearer token for protected routes.

# INSTALL DOCKER, BUILD AND RUN CONTAINERS
 With docker installed on your machine, run the docker build command
```
docker compose build app && docker compose up -d 
```

# INSTALL APPLICATION dependencies
```
docker compose exec app rm -rf vendor composer.lock && docker compose exec app composer install
``` 

# HOW TO RUN MIGRATIONs AND SEEDERS
```
docker compose exec app php artisan migrate:refresh --seed
```

# HOW TO RUN API
If the containers were setup properly, we should be able to see the base url at
[a link] (http://localhost:8000/)

# RUN UNIT TESTS
Before running test update the TEST_TOKEN in the .env
```
docker compose exec app php vendor/bin/phpunit
```

# CHECK RUNNING CONTAINERS
```
docker ps
```

# HOW TO STOP DOCKER CONTAINERS 
```
docker compose down
```

# HOW TO FIND IP in use
```
docker inspect -f '{{.Name}} - {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' $(docker ps -aq)
```

# Swagger Documentation using swagger editor
I am using ngrok to tunnel the local IP, so visit 
[a link] (https://ngrok.com/) signup and install engine on your machine, Lastly please add authtoken to machine

Use the command 
```
ngrok http http://localhost:8080
```

to create the tunnel so the swagger editor can receive response from the public url provided by ngrok
Open the ./openapi.yaml file and change public url under servers > url to the public url provider by ngrok

visit the link below
[a link] (https://editor.swagger.io/)
Then load up /openapi.yaml

# Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/lumen-framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/lumen)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

> **Note:** In the years since releasing Lumen, PHP has made a variety of wonderful performance improvements. For this reason, along with the availability of [Laravel Octane](https://laravel.com/docs/octane), we no longer recommend that you begin new projects with Lumen. Instead, we recommend always beginning new projects with [Laravel](https://laravel.com).

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
