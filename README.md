### Prérequis

Pour faire fonctionner le code, vous aurez besoin de la configurartion minimale suivante

````bash
PHP 7.4.2
MariaDB 10.4.10
Apache 2
Prise en charge du HTTPS
OpenSSL
````

## Installation

Pour installer les paquets nécessaires, lancez la commande suivante
````bash
composer install
npm i
````
### Fichier .env local
Dupliquez le fichier .env, puis renommez le .env.copy vers .env.local et compléter avec les informations de votre système (infos : base de données, login, password etc...)

Exemple (à personnaliser en fonction de votre configuration):
````bash
Avant : 
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

Après :
DATABASE_URL="mysql://monUser:monPassword@127.0.0.1:3306/maBd?serverVersion=mariadb-10.4.10"
````

### Création de la base de données
Création de la base de données qui sera utilisée pour l'application
````bash
php bin/console doctrine:database:create
````
Ou
````bash
composer run create-db
````

### Exécution des migrations nécessaires
Pour mettre à jour la base de données qui sera utilisée dans votre environnement de développement
````bash
php bin/console doctrine:migrations:migrate
````
Ou
````bash
composer run migrate
````

### Fixtures
Des jeux de fausses données sont ou seront configurées pour faciliter le développement de l'application.
Pour les utiliser, il vous suffira tout simplement lancer l'une des commandes suivantes.
````bash
php bin/console doctrine:fixtures:load
````
Ou
````bash
composer run load-data
````
### Génération des clés SSL:

Pour générer les clés SSL, il faut éxécuter la commande suivante
````bash
php bin/console lexik:jwt:generate-keypair
````
Elle générera les clés de la manière suivante

config/jwt/private.pem
config/jwt/public.pem
### Deuxième possibilité pour générer les clés SSL :
Étapes à suivre pour (windows)
````bash
mkdir config\jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
````
 
Étapes à suivre pour (Linux / Mac)
````bash
mkdir -p config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
````

### Génération du token
Pour générer un token, il vous faut ppaler la route login_chek
````bash
curl -X POST -H "Content-Type: application/json" http://localhost:8000/api/login_check -d '{"username":"adresse-email@movie-catolog.fr","password":"mot-de-pass-de-test"}'
````
### Exemple de token
Exemple de token généré
````bash
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MTY5NDU5NDgsImV4cCI6MTYxNjk0OTU0OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiai5kdWJvaXNAbW92aWUtY2F0YWxvZy5mciJ9.GUK53DbDA3c-Seu1aLCtWI8ogFqP6XtK9ybDmvWZPg4fUndtJm8z1GrZN-thzdvtmwtlonYB5Ffre4sYGw17BreaU8QqCf1SQjVx34wv6ACjBO6QmShwRSsywF3Era1cq62623RVv_wZIc3BNMq4jL_6p5QeVsqA_HQp6Ktne20bj3Y9noxH14_T5xzQXMCrQj9DjNMT8XuBJjOuc0B-ZCMlKypk79JKxL__tKLYSowpnbCsEowGV9PkoHH8rK-Zibl9AiyzuIIQ113JuVKZ6qnXve-nWCar6zrFVmNPWkGDXKOSL0EA6e6r_fUj-itSJxG83M8bCYvanM2JOm0V0xYckw43nlSGK2qG7gC2qtFVw0-UhFtSzvwQ9AiC9Qihi-Yqfoj7XVaC9Y5sY1kmryGJ7aOfutXrKI3w-TIkPiaFTQm9pv4ZRdwY_VL3SZ_6Q0QtF99vvjgyRVLS2G2uhpVDWU6FnpZI3SZro60QUfd1GlBYLRhoXiWxsK1Qfgysc5zDwUuyKX7uYWSlgLVLlSTtFceNkLk7uG0xn49OZVDAIeUQsZh5VDDaO2FaI42b1a-O-ax3_fa7cIoksux7doxBxBnhMMePUEKNlavMXBVLYrroMaymHS3dTN0XO7YPsOx6BzDkA3uROq0A9T2gM6gYHBt5RW6k8RugNfJRZAA"
}
````

### Utilisation d'un token
Pour utiliser le token généré, il faut configurer le type d'authorisation suivant
````bash
Authorization: Bearer {token}

## Installation
Trois nouvelles branches
````bash
Branche recette
Branche test
````