# Projet de Fin d'Études : Système de Réservation

## 🌟 Aperçu du Projet

Ce projet est un **Système de Réservation Complet** développé dans le cadre d'un projet de fin d'études. Il est conçu pour permettre aux utilisateurs de gérer et d'effectuer des réservations en ligne de manière simple et efficace. Le système comprend une interface utilisateur pour les réservations et un tableau de bord administrateur pour la gestion.

## 🛠️ Technologies Utilisées

Le projet est construit sur une pile technologique standard pour le développement web :

| Catégorie | Technologie | Rôle |
| :--- | :--- | :--- |
| **Backend** | PHP | Logique métier, gestion des sessions et des requêtes. |
| **Base de Données** | MySQL | Stockage des données utilisateurs, des réservations et des informations du système. |
| **Frontend** | HTML5, CSS3 | Structure et style des pages web. |
| **Scripting** | JavaScript | Interactivité côté client. |

## ✨ Fonctionnalités Clés

Le système offre les fonctionnalités principales suivantes :

*   **Gestion des Utilisateurs :** Inscription (`signup.php`), connexion (`login.php`) et déconnexion (`logout.php`) sécurisées.
*   **Système de Réservation :** Les utilisateurs peuvent effectuer de nouvelles réservations (`booking.php`, `reserv.php`).
*   **Tableau de Bord Administrateur :** Interface dédiée (`dashbord.php`) pour la gestion des clients (`client.php`), l'ajout d'éléments (`add.php`) et la suppression (`delete.php`).
*   **Base de Données :** Le schéma de base de données est fourni (`hallane(4).sql`) pour une configuration rapide.
*   **Interface Utilisateur :** Pages stylisées avec des fichiers CSS (`style.css`, `arab.css`) et des scripts JavaScript (`js/main.js`).

## 🚀 Installation et Démarrage

Suivez ces étapes pour configurer et exécuter le projet localement.

### Prérequis

Vous devez avoir un environnement de serveur web local (comme XAMPP, WAMP ou MAMP) avec **PHP** et **MySQL** installés.

### 1. Cloner le Dépôt

```bash
git clone https://github.com/votre-nom-utilisateur/projet-fin-etude-booking.git
cd projet-fin-etude-booking
```

### 2. Configuration de la Base de Données

1.  Créez une nouvelle base de données MySQL (par exemple, `hallane`).
2.  Importez le fichier `hallane(4).sql` dans votre nouvelle base de données.
3.  Ouvrez le fichier `db.php` et mettez à jour les informations de connexion à la base de données si nécessaire :

    ```php
    <?php
    $servername = "localhost";
    $username = "root"; // Votre nom d'utilisateur MySQL
    $password = ""; // Votre mot de passe MySQL
    $dbname = "hallane"; // Le nom de votre base de données

    // Créer la connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
    ```

### 3. Exécution du Projet

1.  Placez le dossier `projet-fin-etude-booking` dans le répertoire racine de votre serveur web (par exemple, `htdocs` pour XAMPP).
2.  Démarrez votre serveur web (Apache) et votre serveur de base de données (MySQL).
3.  Accédez au projet via votre navigateur :

    ```
    http://localhost/projet-fin-etude-booking/
    ```

## 📝 Utilisation

*   **Page d'Accueil (`index.php`) :** Point d'entrée du système.
*   **Inscription (`signup.php`) :** Pour créer un nouveau compte utilisateur.
*   **Connexion (`login.php`) :** Pour accéder à l'espace utilisateur.
*   **Tableau de Bord Admin (`dashbord.php`) :** Accessible après connexion avec un compte administrateur.

## 🤝 Contribution

Ce projet a été développé dans le cadre d'un projet de fin d'études. Les contributions ne sont généralement pas acceptées pour ce type de dépôt, mais si vous trouvez un problème ou avez une suggestion, veuillez ouvrir une *issue*.

## 📄 Licence

Ce projet est sous licence **MIT**. Voir le fichier `LICENSE` (si existant) pour plus de détails.
