# StudentCourseManager

## Configuration et installation

1. Copier le dossier `Code_Source` dans le répertoire `www` de WAMP.
2. Ouvrir `phpMyAdmin` ou un outil MySQL équivalent.
3. Importer le fichier SQL `database.sql` pour créer la base de données et les tables.
   - La base de données créée est `student_course_manager`.
4. Vérifier les paramètres de connexion dans `includes/db.php` :
   - hôte : `localhost`
   - base de données : `student_course_manager`
   - utilisateur : `root`
   - mot de passe : `""` (vide) sur une installation WAMP standard
5. Si vos informations MySQL sont différentes, modifiez-les dans `includes/db.php`.

## Accès à l’application

- Ouvrir un navigateur et aller sur :
  `http://localhost/student_manage/-StudentCourseManager/Code_Source/`
- Utiliser les pages suivantes :
  - `pages/register.php` pour créer un compte étudiant
  - `pages/login.php` pour se connecter
  - `pages/dashboard.php` pour accéder au tableau de bord
  - `pages/courses.php` pour voir les cours disponibles
  - `pages/my_registrations.php` pour consulter les inscriptions

## Structure du projet

- `includes/db.php` : connexion à la base de données
- `includes/auth.php` : gestion de l’authentification
- `includes/header.php` et `includes/footer.php` : en-tête et pied de page communs
- `database.sql` : création de la base de données, des tables et des données de test

## Notes

- Le projet utilise PDO pour la connexion MySQL.
- Assurez-vous que le serveur Apache et le service MySQL sont démarrés dans WAMP.
- Si vous avez un autre nom de base de données, adaptez `includes/db.php` et importez votre fichier SQL correctement.
