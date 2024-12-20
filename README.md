# Guide d'installation du projet WordPress

Suivez les étapes ci-dessous pour installer et exécuter ce projet WordPress sur votre appareil local :

## Prérequis

- Assurez-vous d'avoir installé un environnement de serveur local tel que **XAMPP** ou **WAMP** sur votre système.

---

## Étapes d'installation

1. **Installer XAMPP ou WAMP**  
   - Téléchargez et installez [XAMPP](https://www.apachefriends.org/index.html) ou [WAMP](http://www.wampserver.com/) selon votre préférence.  
   - Démarrez les services Apache et MySQL.

2. **Configurer la base de données**  
   - Ouvrez votre outil de gestion de base de données préféré (par exemple, phpMyAdmin).  
   - Exécutez le fichier SQL `wordpress.sql` inclus dans ce projet pour créer la base de données.

3. **Déplacer les fichiers du projet**  
   - Copiez tout le dossier du projet dans :  
     - `htdocs` (pour XAMPP)  
     - `www` (pour WAMP)

4. **Accéder au projet**  
   - Ouvrez votre navigateur et accédez à `http://localhost/{nom-du-dossier-du-projet}`.  
     *(Remplacez `{nom-du-dossier-du-projet}` par le nom réel de votre dossier de projet.)*

5. **Se connecter au panneau d'administration**  
   - Utilisez les identifiants suivants pour vous connecter :  
     - **Nom d'utilisateur :** `root`  
     - **Mot de passe :** `root`

6. **Profitez de la boutique**  
   - Vous avez maintenant un accès complet à la boutique WordPress. Explorez et personnalisez selon vos besoins !

---

## Remarques

- Assurez-vous que vos versions de PHP et MySQL sont compatibles avec WordPress.  
- En cas de problème, vérifiez le fichier `wp-config.php` pour confirmer les détails de connexion à la base de données.

---

