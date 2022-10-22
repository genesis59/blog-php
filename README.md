# blog-php [![Codacy Badge](https://app.codacy.com/project/badge/Grade/6694f1f2931640cb9b3ddb1feafa8867)](https://www.codacy.com/gh/genesis59/blog-php/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=genesis59/blog-php&amp;utm_campaign=Badge_Grade)
## Environnement de développement
### Prérequis
* git https://git-scm.com/downloads
* composer https://getcomposer.org/
* PHP 8
### Installation du projet
1. Cloner le projet à l'aide de la commande git clone
***
2. Variables d'environnement
   * Créer un fichier .env à la racine du dossier source
   * Copier le contenu du fichier .env-distrib dans le fichier .env
   * Remplacer << nom de la variable >> par sa valeur
***
3. Installer les dépendances PHP :
    ```bash
    composer install
    ```
***
4. Installation de la base de données
   * Les scripts se trouve dans le répertoire sql
   * Exécuter le script database.sql
   * Puis exécuter le script fixtures.sql
   * Le mot de passe des utilisateurs est par défaut "testtest"
***
5. Pour lancer le serveur PHP depuis la racine du projet
   ```bash
   php -S localhost:8000 -t public
   ```
<p>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img style="border:0;width:88px;height:31px"
            src="http://jigsaw.w3.org/css-validator/images/vcss"
            alt="CSS Valide !" />
    </a>
   <a href="http://jigsaw.w3.org/css-validator/check/referer">
       <img style="border:0;width:88px;height:31px"
           src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
           alt="CSS Valide !" />
    </a>
</p>