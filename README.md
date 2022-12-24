# LeBonCoin
TP EVAL SYMFONY

# Setup
Suivre les marches suivantes : 

## Installer les dépendances composer ##

```
composer install
```

  Commande alternatives en fonction de comment est installé composer `php composer.phar install`.

## Connecter la base de donnée ##

Connecter la base de donnée via le fichier .env ou créer un fichier .env.local
Prendre la configuration associé a votre BDD parmis 

```
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=14&charset=utf8"
```

Run la commande `php bin/console doctrine:create:database`
/!\ Vérifier les fichiers migrations le dernier à jour est le fichier 'Version20221224152258.php' exécutez celui-ci sinon,

effectué la commande `php bin/console doctrine:migrations:diff`,

ensuite `php bin/console doctrine:migrations:migrate`

## Démarrer le serveur symfony ##

Vous pouvez utiliser Nginx ou Apache, mais le serveur Web local de Symfony
fonctionne encore mieux.

Pour installer le serveur web local Symfony, suivez
Instructions "Télécharger le client Symfony" trouvées
ici : https://symfony.com/download - il vous suffit de le faire
une fois sur votre système.

Ensuite, pour démarrer le serveur Web, ouvrez un terminal, déplacez-vous dans le
projet et exécutez :

```
symfony serve
```

Alternatif
```
symfony server:start -d (-d optionnel mais permet de récupérer la main sur le terminal)
```

## OPTIONEL WEBPACK ENCORE ##

Je me sers de ce TP afin d'expérimenter plus d'outils de symfony d'ou la présence de WebPack Encore, ou bien Symfony TURBO.

/!\ Fortement conseiller d'installer et de run webpack pour une utilisation optimal

Assurez-vous d'avoir du [yarn](https://yarnpkg.com/lang/en/)
ou `npm` installé (`npm` est fourni avec Node), puis exécutez :

```
yarn install
yarn encore dev --watch

# ou
npm install
npm run watch
```

## Remplir sa base de donnée ## 

Des fixtures avec Faker accompagne le TP, si toutes les dépendances ont été installé et la BDD connecté et configurer il suffit d'éxécuter la commande : 

```
php bin/console doctrine:fixtures:load
```

- Pour la connection sur l'application avec un utilisateur généré avec les fixtures, les identifiants sont de type :
Username : exempleNomFaker
Password : exempleNomFaker
