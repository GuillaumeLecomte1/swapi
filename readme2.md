## Star Wars API Documentation avec Swagger.io
Bienvenue sur le projet de documentation de l'API Star Wars, une interface de programmation immersive qui vous permet d'explorer l'univers de Star Wars. Ce projet utilise Swagger.io pour documenter les endpoints de l'API SWAPI, offrant un accès facile aux données de Star Wars via une interface utilisateur graphique intuitive.

## Technologies Utilisées
Framework : Laravel
Base de données : MySQL
Documentation API : Swagger.io
API de données : SWAPI (Star Wars API)

## Installation
Pour démarrer avec ce projet, suivez ces étapes :

Clonez le dépôt sur votre machine locale.
Configurez votre environnement de base de données MySQL en créant une base de données et en ajustant les paramètres de connexion dans le fichier .env de Laravel.
Exécutez composer install pour installer les dépendances PHP.
Lancez les migrations de la base de données avec php artisan migrate pour préparer la structure de données.
Importez les données de Star Wars en utilisant les seeders Laravel ou en exécutant votre propre script d'importation.
Démarrez le serveur de développement avec php artisan serve.
Accédez à l'interface de documentation Swagger à l'adresse affichée dans votre terminal.

## Utilisation
La documentation Swagger vous permet d'interagir avec l'API de manière visuelle. Vous pouvez :

Explorer les différents endpoints disponibles.
Voir les détails des requêtes et des réponses attendues.
Tester directement les requêtes à partir de l'interface.

## Le Modèle de Maturité de Richardson
Le modèle de maturité de Richardson décrit les étapes pour créer une API RESTful. Il comporte quatre niveaux, du niveau 0 au niveau 3, chaque niveau introduisant de nouvelles contraintes pour augmenter la maturité de l'API.

## Comment Nous Avons Respecté le Modèle de Richardson
Niveau 0 : L'API SWAPI, étant une source de données unique, sert de point d'entrée unique (URI) pour toutes les interactions, conformément au niveau 0 du modèle.
Niveau 1 : Nous avons structuré l'API autour des ressources de Star Wars (par exemple, personnages, planètes), chaque ressource ayant son propre URI.
Niveau 2 : Nous utilisons les méthodes HTTP (GET, POST, DELETE) pour définir les opérations sur les ressources, en adéquation avec les principes REST.
Niveau 3 : Enfin, nous avons implémenté HATEOAS pour permettre une navigation auto-découverte de l'API, guidant les utilisateurs vers des ressources connexes à travers des hyperliens.

## Contribution
Votre contribution est la bienvenue ! Veuillez suivre les directives de contribution pour soumettre des bugs, des demandes de fonctionnalités ou des pull requests.

## Licence
Ce projet est sous licence [Insérer le type de licence]. Voir le fichier LICENSE pour plus de détails.