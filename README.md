# Ajar Online - Backend Test

This backend test project is intended to show one possible implementation of a simple invoicing system and it serves only demonstrational purposes.

## Getting Started

### Prerequisites

The only thing that you need to run this project on your computer is Docker,
and of course the project itself. Let's clone it.  

```
git clone https://github.com/annokt/ajar-online.git
```

### Installing

After cloning the repository run this command from the root directory:

```
docker-compose up -d
```

And you can access the app on

```
[http://localhost:8080](http://127.0.0.1:8080)
```

If you want to play with the database in the browser you can use the adminer here:

```
[http://localhost:8081](http://127.0.0.1:8081)
```

## Running the tests

```
docker-compose exec php ./vendor/bin/phpunit
```

## Built With

* [Laravel 5.7](https://laravel.com/docs/5.7)

## Authors

* **Tamas Annok** - *Initial work* - [annokt](https://github.com/annokt)

## Acknowledgments

* If you wanna enjoy coding again you must try Laravel! It is clean, it is fun and it is seriously addictive.
