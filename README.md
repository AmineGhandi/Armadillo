
<p align="center"><img src="https://i.postimg.cc/8fvqt3Zz/armadillofull-inverted.png" alt="License"></a></p>


## Features

- Authentification
- Modification de vos informations si connecter
- CRUD utilisateurs
- Side bar dynamic selon le rôle de l'utilisateur
- Export en PDF ou excel
- Envoyer des emails pour un ou plusieurs utilisateur
- Impression de cheque (vide ou plein)

# Comment le faire fonctionner :

 - Modifier le fichier .env par votre propre gmail et mot de passe
 - Changer le nom de la base de données dans le fichier .env
 - Exécuter les commandes suivantes dans le chemin du projet :

 ```sh
    Composer install
 ```
 ```sh
    Npm install
 ```
 ```sh
    Php artisan key:generate
 ```
 ```sh
    Php artisan migrate
```
```sh
    Php artisan serve
```
 - copier le link et BOOM ! 