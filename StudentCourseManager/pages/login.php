<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/header.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';

    if (empty($email) || empty($mdp)) {
        $erreur = "Veuillez remplir tous les champs.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Format de l'email invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ?");
        $stmt->execute([$email]);
        $student = $stmt->fetch();

        if ($student && password_verify($mdp, $student['mot_de_passe'])) {
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_nom'] = $student['nom_complet'];
            header('Location: dashboard.php');
            exit();
        } else {
            $erreur = "Email ou mot de passe incorrect.";
        }
    }
}
?>

<h2>Connexion</h2>

<?php if ($erreur): ?>
    <div class="alert-error"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<form method="POST">
    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label>Mot de passe</label>
    <input type="password" name="mot_de_passe">

    <button type="submit">Se connecter</button>
</form>

<p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>

<?php require_once '../includes/footer.php'; ?>