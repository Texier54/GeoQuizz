# GeoQuizz

GeoQuizz est un jeu disponible sur ordinateur, tablette et téléphone. Le principe est simple : une photo est proposée au joueur, il doit indiquer la position de ce qu'elle représente sur une carte d'une ville.

Trello : https://trello.com/b/uOqYzi1V/geoquizz

## Commencer

Ces instructions vous permettront d'obtenir une copie du projet opérationnel sur votre machine locale à des fins de développement et de test. Voir déploiement pour les notes sur la façon de déployer le projet sur un système actif.

### Prérequis
```
* Web server avec un URL rewriting
* PHP 7.0+
* Composer installer globallement
* Docker installer
* NodeJS/npm installer
```

### Installation

```
* Clone le depot git — git clone https://github.com/Texier54/GeoQuizz
* Importation de la BDD /sql/geoquizz.sql
* Remplissage de la BDD /sql/geoquizz_data.sql
* Configuration du fichier de la BDD ./src/conf/geoquizz.db.conf.ini
* Modifier le ficher /etc/hosts an y ajoutant : 127.0.0.1 api.geoquizz.local backoffice.local
* Faire un : docker-compose up
* Suivi d'un : docker-compose start
* Dans ./src composer install
* Dans ./public npm install
* Dans ./public npm run dev
```
* Pour acceder au backoffice il faudra aller au lien : **backoffice.local:10081**

* Pour acceder au jeu il faudra aller au lien **localhost:XXXX**, dependant de ce que votre npm run dev vous dis, normalement c'est le port **8080**

* La BDD Adminer se trouve à l'addresse **api.geoquizz.local:8090**

## Fait avec

### Backoffice :
* [Slim PHP](https://www.slimframework.com/) framework
* [Slim Twig](https://twig.symfony.com/) templating engine avec debug
* [Eloquent ORM](https://laravel.com/docs/5.0/eloquent)
* [Slim CSRF](https://github.com/slimphp/Slim-Csrf) avec twig
* [Respect Validator](https://github.com/Respect/Validation) 
* [Bootstrap CSS](https://github.com/twbs/bootstrap) framework 

### Jeu :
* [vuejs](https://github.com/vuejs) javascript framework
  * [vue](https://github.com/vuejs/vue)
  * [vue-router](https://github.com/vuejs/vue-router)
  * [vuex](https://github.com/vuejs/vuex)
* [Axios](https://github.com/axios/axios)
* [Leaflet](https://github.com/Leaflet/Leaflet) javascript library 
* [Bulma CSS](https://github.com/jgthms/bulma) framwork

## Autheurs

* [Baptiste Texier](https://github.com/texier54)
* [Islam Elshobokshy](https://github.com/elshobokshy)
* [Charles Montrouge](https://github.com/Charles974)
* [Jordan Sautron](https://github.com/Voytsu)
