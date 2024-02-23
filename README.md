Demo Application

Requirements
------------

  * PHP 8.2.0 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][2].
  * composer

Usage
-----

```
$ cd demo-crud/
$ composer install
$ php bin/console doctrine:migrations:migrate
$ php -S localhost:8000 -t public/
```

Available endpoint

GET http://localhost:8000/users
GET http://localhost:8000/users/:id
POST http://localhost:8000/users
```
{
    "email": "test@test.com",
    "first_name": "first_name1",
    "last_name": "last_name",
    "phone": "phone"
}
```

PUT http://localhost:8000/users/:id
```
{
    "email": "test@test.com",
    "first_name": "first_name1",
    "last_name": "last_name",
    "phone": "phone"
}
```

DELETE http://localhost:8000/users/:id
