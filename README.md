
# Devolon Shopping Cart

copy example env to env and set needed config
```
cp .env .env.local 
```


#
    
### Deployment
```
make install
```

#### Run Test
```
make test
```

#### Database (MariaDB)

To create Databases:
```
docker-compose run --rm php-fpm bin/console doctrine:database:create
docker-compose run --rm php-fpm bin/console doctrine:schema:update -f
```

run fixtures ( add fake data to DB if needed ) 

```
docker-compose run --rm php-fpm bin/console doctrine:fixtures:load

docker-compose run --rm php-fpm bin/console doctrine:fixtures:load --append --group x
```

#### PHP (PHP-FPM)

Composer is included

```
docker-compose run --rm php-fpm composer 
or 
make composer
```

#