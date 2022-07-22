# blog-php

* Pour lancer le serveur PHP depuis la racine du projet => php -S localhost:8000 -t public

* Avant chaque commit faire un :
    * vendor/bin/phpcbf --standard=PSR12 src
    * vendor/bin/phpstan analyse src --level 0
        * corriger les erreurs et passer au level suivant --level 1
        * ainsi de suite jusqu'au level 8
