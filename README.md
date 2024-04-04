# Test Technique Back Lemon Interactive
Ce *repository* représente le code de test Symfony pour Lemon Interactive.\
Ce fichier README va détailler les choix que j'ai faits.

# Comment utiliser l'application?

## Installation
- Cloner le repo github
- Copier le fichier *.env*, renommer la copie en *.env.local* et le paramétrer (modifier le APP_ENV de prod à dev dans le ".env.local")
- Lancer la commande `composer install` 
  - Installe les packages back
- Lancer la commande `yarn install`
  - Installe les packages front
- Lancer la commande `symfony console d:d:c`
  - Doctrine Dabase Create : Crée la base de données avec les informations données dans le fichier *.env.local*
- Lancer la commande `symfony console d:m:m`
  - Doctrine Migrations Migrate : Permet de lancer les scripts de migration, qui donneront la structure finale à la base de données
- Lancer la commande `symfony console d:f:l`
  - Doctrine Fixtures Load : Permet de charger un jeu de données, réalisé avec *Faker*, pour populer le site avec des data
- Lancer la commande `symfony server:start`
- Lancer la commande `yarn watch`
- Se connecter sur localhost:8000

## Utilisation
La plupart du site nécessitant un compte, afin de pouvoir intéragir avec les événements, il est recommandé de rapidement en créer un. Une navbar permet d'avoir accès aux formulaires d'inscription et de connexion. \
Une fois que vous avez créé un compte, vous avez la possibilité de vous inscrire à des événements existants ou d'en créer de nouveaux. Une fois connecté, la page d'accueil du site vous permet de vous inscrire aux événements.\
La barre de navigation vous donne également accès aux pages "Créer un événement" et "Mes événements".

### Créer un événement
Cette page permet de:
- Choisir le titre de l'événement
- Décrire l'événement
- Spécifier la localisation 
- Indiquer la date de début et de fin de l'événement

### Mes événements
Cette page vous permet de:
- Consulter la liste des événements auxquels vous êtes inscrit.
- Consulter la liste des événements que vous avez créés.
- Mettre à jour les événements que vous avez créés.
- Supprimer les événements que vous avez créés.

# Choix de conception
## Les Fixtures
Les fixtures ont été créées à l'aide de la librairie Faker.\
J'ai choisi de créer:
- 5 Comptes utilisateurs 
- 10 événements

Les champs sont complets, opérationnels et cohérents (pas de date de fin antérieure à la date de début, adresse e-mail unique, etc).

## La page inscription / connexion
L'authentification est gérée par le composant Security.\

J'ai choisi d'utiliser l'adresse mail comme identifiant unique pour l'utilisateur.\
Celui-ci doit également indiquer son nom, son prénom ainsi que son mot de passe afin de pouvoir créer son compte.

Le mot de passe doit comporter:
 - Plus de 8 caractères
 - Au moins une majuscule
 - Un caractère spécial
 - Un chiffre

L'utilisateur se connecte en indiquant son adresse mail (identifiant unique) et son mot de passe.

N.B: L'utilisateur peut se déconnecter à tout moment via le bouton "déconnexion" situé à droite de la navbar.

## Les événements
Les événements sont:
- Disponibles sur la page d'acceuil (y compris pour les utilisateurs non connectés).
- Affichés sous forme de grille
- Classés par date et heure dans l'ordre chronologique
- Un filtre permet de choisir un intervalle de date afin d'affiner l'affichage.

Il me semblait cohérent d'inscrire automatiquement l'utilisateur à l'événement qu'il créé.\
J'ai cependant laissé la possibilité au créateur de l'événement de pouvoir se désinscrire.

## Fonctionnalités
Un utilisateur authentifié peut:
- Créer un événement
- Modifier ou supprimer l'événement créé
- S'inscrire / se désinscrire d'un événement

En revanche, un utilisateur non connecté ne pourra pas accéder aux pages "Créer un événement" et "Mes événements". En dehors de la connexion, ces fonctionnalités sont désactivées.

## Tests Unitaires
J'ai réalisé deux tests unitaires:
- Vérification de la création de l'entité User
- Vérification de la création de l'entité Event

## Style et Responsive

Le framework Bootstrap permet de gérer le style ainsi que le responsive du projet.

## Les services
Les fonctionnalités métiers (logiques) de inscription / desinscription /  création / modification / suppression /  d'événements ont été placées dans les services appropriés.

## Ergonomie
Le site est très intuitif, tout est indiqué clairement et accessible en quelques clics.

# Remerciements
Je tiens à vous remercier d'avoir pris le temps d'étudier ma candidature et ce repository.
