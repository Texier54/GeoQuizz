# GeoQuizz

GeoQuizz est un jeu disponible sur ordinateur, tablette et téléphone. Le principe est simple : une photo est proposée au joueur, il doit indiquer la position de ce qu'elle représente sur une carte d'une ville.

## Commencer

Ces instructions vous permettront d'obtenir une copie du projet opérationnel sur votre machine locale à des fins de développement et de test. Voir déploiement pour les notes sur la façon de déployer le projet sur un système actif.

### Prérequis

Nécéssite Composer

### Installation

Récupération du projet

```
Clone le depot git — git clone https://github.com/Texier54/GeoQuizzh
```

```
Importation de la BDD /sql/geoquizz.sql
```

```
Configuration du fichier src/conf/geoquizz.db.conf.ini
```

```
docker-compose up
```

```
docker-compose start
```

```
Dans /src composer install
```

```
Dans /public npm run dev
```

## Fait avec

* [Slim](https://www.slimframework.com/) - Framework PhP
* [Eloquent](https://laravel.com/docs/5.0/eloquent) - ORM
* [Twig](https://twig.symfony.com/) - Template engine for PHP

## Autheurs

* **Baptiste Texier** - *Lancement* - [Github](https://github.com/texier54)
* **Islam Elshobokshy** - [Github](https://github.com/elshobokshy)
* **Charles Montrouge** - [Github](https://github.com/Charles974)
* **Jordan Sautron** - [Github](https://github.com/Voytsu)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details


