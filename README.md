
# Devolon Shopping Cart
#### Tl;dr
We use the Chain of Responsibility to handle checkout requests in this project.

#


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

### TODO
- Complete README
- Add Documents
- Add DELETE methods
- Create Workflow for Checkouts
- Create docker-compose for test env
- Add user and Checkout entities and persist Request
- Add tests for ProductDiscountApi, DiscountApi and etc
- Add factory for creating entity objects in DataFixture and use them in tests
- Refactor to return hash ids instead of ids for security reasons
