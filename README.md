﻿# blog-php

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ed734bcf50f64a4cb8051a5477378ff1)](https://app.codacy.com/gh/genesis59/blog-php?utm_source=github.com&utm_medium=referral&utm_content=genesis59/blog-php&utm_campaign=Badge_Grade_Settings)




## Installation du projet

1. Cloner le projet
2. Variables d'environnement
   * Créer un fichier .env à la racine du dossier source
   * Copier le contenu du fichier .env-distrib dans le fichier .env
   * Remplacer << nom de la variable >> par sa valeur
3. Installer les dépendances PHP :
    ```bash
    composer install
    ```
4. Pour lancer le serveur PHP depuis la racine du projet => php -S localhost:8000 -t public

## Tests statiques

* Avant chaque commit faire un :
    * vendor/bin/phpcbf --standard=PSR12 src
    * vendor/bin/phpstan analyse src --level 0
        * corriger les erreurs et passer au level suivant --level 1
        * ainsi de suite jusqu'au level 8

