# Checkout for code & pepper


## Build

git clone repo and then

```
composer install
```

## Test

```
php bin/phpunit
```

## Run

1. create vhost pointing to ***/public*** directory as DocumentRoot

OR

2. Move into your new project and start the server:
```
php bin/console server:run
``` 

As it is Symfony based project you will find more details here: https://symfony.com/doc/current/setup.html

## Database

It's based on SQLite database located in **/var/codepepper.db**

## Endpoints

**POST /checkout**

Body: list of Skus
```
[ "TSHIRT0012", "TSHIRT0012", "CARTOYR0200" ]
```

**POST /product**

To keep it simply decided to handle pricing rules by simply sending current state of Product as pricing rules are just element of Product entity:
```
{
	"sku": "TSHIRT0012", 
	"price": 100,
	"rules": [
		{
			"name": "Buy 3 Get 4th For Free",
			"action_name": "BuyXGetOne",
			"discount_amount": null,
			"discount_step": 3
		}
	]
}
```

* **action_name** is just name of class implementing DiscountInterface, located in **\src\Discount**

* additional [Postman](https://www.getpostman.com/) Collection in **\documentation** dir for testing purpose

## Develop

Made 2 simple pricing rules, located in **src\Discount**. If you need additional rules with more complex logic just put there new implementation of DiscountInterface
