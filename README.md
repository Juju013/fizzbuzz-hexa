This is the repository for LeBonCoin backend technical test.

## Subject :

````
    Exercise: Write a simple fizz-buzz REST server.
    
    "The original fizz-buzz consists in writing all numbers from 1 to 100, and just replacing all multiples of 3 by ""fizz"", all multiples of 5 by ""buzz"", and all multiples of 15 by ""fizzbuzz"".
    
    The output would look like this: ""1,2,fizz,4,buzz,fizz,7,8,fizz,buzz,11,fizz,13,14,fizzbuzz,16,...""."
    
    Your goal is to implement a web server that will expose a REST API endpoint that:
    
    Accepts five parameters: three integers int1, int2 and limit, and two strings str1 and str2.
    Returns a list of strings with numbers from 1 to limit, where: all multiples of int1 are replaced by str1, all multiples of int2 are replaced by str2, all multiples of int1 and int2 are replaced by str1str2.
    
    
    The server needs to be:
    
    Ready for production
    Easy to maintain by other developers
    
    
    Bonus: add a statistics endpoint allowing users to know what the most frequent request has been. This endpoint should:
    
    Accept no parameter
    Return the parameters corresponding to the most used request, as well as the number of hits for this request"
````

## Requirements :

- docker : https://www.docker.com
- composer: https://getcomposer.org

## Installation

```
cd docker
docker-compose up --build -d
cd ../symfony 
composer install
```

The web app should be accessible at **localhost:8088**

And the database with :
- **user**: root
- **password**: root
- **domain**: 127.0.0.1
- **port**: 3306
- **database**: fizzbuzz

To run the test, in the php-fpm container, run the following command:

```
php bin/phpunit
```

## Documentation

### GET - /api/fizzbuzz

Params:
 - int1 (integer)
 - int2 (integer)
 - str1 (string)
 - str2 (string)
 - limit (string)

The return format is JSON.

Example for `GET` `/api/fizzbuzz?int1=3&int2=5&limit=20&str1=fizz-&str2=buzz`
```
{
    "code": 200,
    "data": "12fizz-4buzzfizz-78fizz-buzz11fizz-1314fizz-buzz1617fizz-19buzz"
}
```


### GET - /api/stats

Return the route the most used with its params. (excluding the route `/api/stats`)

The return format is JSON.

Example for `GET` `/api/stats`
```
{
    "code": 200,
    "data": {
        "route": "/api/fizzbuzz",
        "method": "GET",
        "queries": {
            "int1": "3",
            "int2": "5",
            "limit": "20",
            "str1": "fizz",
            "str2": "buzz"
        },
        "score": 1
    }
}
```