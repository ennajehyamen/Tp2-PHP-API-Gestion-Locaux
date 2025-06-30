# Tp2-PHP-API-Gestion-Locaux
API de Gestion de locaux et équipements avec base de données
## Description

Ce projet est une API RESTful développée en PHP permettant la gestion des locaux et des équipements associés. Elle utilise une base de données pour stocker les informations et propose des endpoints pour effectuer des opérations CRUD (Créer, Lire, Mettre à jour, Supprimer).

## Fonctionnalités

- Gestion des locaux (ajout, modification, suppression, consultation)
- Gestion des équipements (ajout, modification, suppression, consultation)
- Association des équipements à des locaux
- Recherche et filtrage

## Prérequis

- PHP >= 7.4
- MySQL ou MariaDB
- Serveur web (Apache, Nginx, XAMPP, etc.)

## Installation

1. Cloner le dépôt :
    ```bash
    git clone https://github.com/ennajehyamen/Tp2-PHP-API-Gestion-Locaux.git
    ```
2. Importer le fichier SQL dans votre base de données.
3. Configurer les accès à la base de données dans le fichier de configuration.
4. Démarrer le serveur web.

## Utilisation

Les endpoints principaux sont accessibles via des requêtes HTTP :

- `GET /locaux` : Liste des locaux
- `POST /locaux` : Ajouter un local
- `PUT /locaux/{id}` : Modifier un local
- `DELETE /locaux/{id}` : Supprimer un local
- `GET /equipements` : Liste des équipements
- etc.

## Structure du projet

- `/models` : les requettes vers la base de donnée
- `/config` : Fichiers de configuration
- `/sql` : Scripts de base de données

## Auteur

- Nom : Yamen Najeh

## Licence

Ce projet est sous licence MIT.