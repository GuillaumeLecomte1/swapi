## Star Wars API Documentation avec Swagger.io
Bienvenue sur le projet de documentation de l'API Star Wars, une interface de programmation immersive qui vous permet d'explorer l'univers de Star Wars. Ce projet utilise Swagger.io pour documenter les endpoints de l'API SWAPI, offrant un accès facile aux données de Star Wars via une interface utilisateur graphique intuitive.

## Technologies Utilisées
Framework : Laravel
Base de données : MySQL
Documentation API : Swagger.io
API de données : SWAPI (Star Wars API : https://swapi.dev/)

## Installation
Pour démarrer avec ce projet, suivez ces étapes :

Clonez le dépôt sur votre machine locale.
Configurez votre environnement de base de données MySQL en créant une base de données et en ajustant les paramètres de connexion dans le fichier .env de Laravel.
Exécutez composer install pour installer les dépendances PHP.
- composer install
Lancez les migrations de la base de données avec php artisan migrate pour préparer la structure de données.
- php artisan migrate
Importez les données de Star Wars en utilisant les seeders Laravel ou en exécutant votre propre script d'importation.
Démarrez le serveur de développement.
- php artisan serve
Accédez à l'interface de documentation Swagger à l'adresse affichée dans votre terminal.
- http://127.0.0.1:8000/api/documentation

## Utilisation
La documentation Swagger vous permet d'interagir avec l'API de manière visuelle. Vous pouvez :

Explorer les différents endpoints disponibles.
Voir les détails des requêtes et des réponses attendues.
Tester directement les requêtes à partir de l'interface.

## Apprentissage de Laravel

Laravel dispose de la documentation la plus étendue [documentation](https://laravel.com/docs) et la plus approfondie et d'une bibliothèque de tutoriels vidéo de tous les cadres d'application web modernes, ce qui rend le démarrage avec le cadre très facile.

Vous pouvez également essayer le Bootcamp Laravel [Laravel Bootcamp](https://bootcamp.laravel.com) Bootcamp, où vous serez guidé dans la construction d'une application Laravel moderne à partir de zéro.

Si vous n'avez pas envie de lire,[Laracasts](https://laracasts.com) Laracasts peut aider. Laracasts contient plus de 2000 tutoriels vidéo sur une gamme de sujets incluant Laravel, le PHP moderne, le test unitaire et JavaScript. Améliorez vos compétences en explorant notre bibliothèque vidéo complète.

## Le Modèle de Maturité de Richardson
Le modèle de maturité de Richardson décrit les étapes pour créer une API RESTful. Il comporte quatre niveaux, du niveau 0 au niveau 3, chaque niveau introduisant de nouvelles contraintes pour augmenter la maturité de l'API.

## Comment Nous Avons Respecté le Modèle de Richardson
  Niveau 0 : L'API SWAPI, étant une source de données unique, sert de point d'entrée unique (URI) pour toutes les interactions, conformément au niveau 0 du modèle.

  Niveau 1 : Nous avons structuré l'API autour des ressources de Star Wars (par exemple, personnages, planètes), chaque ressource ayant son propre URI.

  Niveau 2 : Nous utilisons les méthodes HTTP (GET, POST, DELETE) pour définir les opérations sur les ressources, en adéquation avec les principes REST.
  
  Niveau 3 : Enfin, nous avons implémenté HATEOAS pour permettre une navigation auto-découverte de l'API, guidant les utilisateurs vers des ressources connexes à travers des hyperliens.

## Contribution
Votre contribution est la bienvenue ! Veuillez suivre les directives de contribution pour soumettre des bugs, des demandes de fonctionnalités ou des pull requests.