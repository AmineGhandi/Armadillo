
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
<img src="https://i.postimg.cc/8fvqt3Zz/armadillofull-inverted.png" alt="License">
</p>

## Features

- Authentification
- Modification de vos informations si connecter
- CRUD utilisateurs
- Side bar dynamic selon le rôle de l'utilisateur
- Export en PDF ou excel
- Envoyer des emails pour un ou plusiur utilisateur
- Impression de cheque (vide ou plein)

# Comment le faire fonctionner :

 - Créer le fichier .env en copiant .env.example
 - Changer le nom de la base de données dans le fichier .env
 - Exécuter les commandes

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