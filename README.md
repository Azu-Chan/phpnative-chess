# Jeu d'échecs PHP natif

## Environnement

Ce projet fonctionne au sein d'un environnement PHP 8.

Pour le développement, j'ai utilisé laragon & PHP 8.1.10

Placer l'arboréscence dans le dossier www de votre serveur web ou dans un répertoure où l'exécutable PHP est accessible.


## Fichiers / Répertoires

* **config/autoload.php :** Fichier servant à gérer le chargement automatique de classes pour les points d'entrée.
* **controller/ :** Différents controlleurs d'API.
* **model/pieces :** Modèles pour les pièces spécifiques du jeu d'échecs.
* **model/players :** Modèles pour joueurs du jeu d'échecs.
* **model/Board.php :** Modèle principal pour gérer le plateau et la partie.
* **model/Piece.php :** Modèle abstrait pour les pièces. 
* **model/Player.php :** Modèle abstrait pour les joueurs. 
* **resources/ :** css et javascript. 
* **index.html :** Vue principale. 
* **README.md :** Ce fichier. 

## Fonctionnalités

* Jeu globalement fonctionnel
* Réset d'une partie
* Affichage du joueur dont c'est le tour
* Affichage de la pièce sélectionnée
* Prévisualisation du déplacement
* Affichage de la somme des valeurs des pièces pour chaque joueur
* Affichage des pièces capturées par les joueurs
* Affichage d'un historique des coups de jeu, roques et victoire en cas de roi pris

## TODO

* Tests unitaires
* Implémenter la promotion de pion
* Implémenter les vérifications d'échec au roi
* Améliorer l'ux/ui
* Mettre un timer