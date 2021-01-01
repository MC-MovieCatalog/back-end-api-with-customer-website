### Prérequis

Pour faire fonctionner le code, vous aurez besoin de la configurartion minimale suivante

````bash
PHP 7.4.2
MariaDB 10.4.10
Apache 2
Prise en charge du HTTPS
````

## Installation

Pour installer les paquets nécessaires, lancez la commande suivante
````bash
composer install
````
### Fichier .env local
Dupliquez le fichier .env, puis renommez le .env.copy vers .env.locl et compléter avec les informations de votre système (infos : base de données, login, password etc...)

Exemple (à personnaliser en fonction de votre configuration):
````bash
Avant : 
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

Après : 
DATABASE_URL=mysql://monUser:monPassword@127.0.0.1:3306/maBd
````

### Création de la base de données
Pour créer la base de données configurée dans votre .env.local vous devez au préalable mettre à exécution votre serveur de base de données 
Puis depuis la racine de votre projet, lancez un terminal et exécutez la commande suivante
````bash
composer run create-db
````

### Création d'une migration
Si vous avez besoin d'une nouvelle migration après la création ou modification d'une entité
````bash
composer run make-migration
````

### Mettre à jour la base de données
Suite à une migration, vous pouvez exécuter la commande suivante pour mettre à jour la base de données
````bash
composer run migrate
````

### Fixtures
Des jeux de fausses données sont ou seront configurées pour faciliter le développement de l'application.
Pour les utiliser, il vous suffira tout simplement lancer la commande suivante.
````bash
composer run load-data
````