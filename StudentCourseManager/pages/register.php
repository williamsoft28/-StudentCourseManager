<?php
require_once '../includes/db.php';
require_once '../includes/header.php';

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom_complet'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mdp = $_POST['mot_de_passe'] ?? '';
    $niveau = trim($_POST['niveau'] ?? '');

    // Validation
    if (empty($nom) || empty($email) || empty($mdp) || empty($niveau)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Format de l'email invalide.";
    } elseif (strlen($mdp) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérifier si email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM students WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $erreur = "Cet email est déjà utilisé.";
        } else {
            // Enregistrement sécurisé
            $hash = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO students (nom_complet, email, mot_de_passe, niveau) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $email, $hash, $niveau]);
            $succes = "Compte créé avec succès ! <a href='login.php'>Se connecter</a>";
        }
    }
}
?>

<h2>Créer un compte</h2>

<?php if ($erreur): ?>
    <div class="alert-error"><?= htmlspecialchars($erreur) ?></div>
<?php endif; ?>

<?php if ($succes): ?>
    <div class="alert-success"><?= $succes ?></div>
<?php endif; ?>

<form method="POST">
    <label>Nom complet</label>
    <input type="text" name="nom_complet" value="<?= htmlspecialchars($_POST['nom_complet'] ?? '') ?>">

    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">

    <label>Mot de passe</label>
    <input type="password" name="mot_de_passe">

    <label>Niveau</label>
    <select name="niveau">
        <option value="">-- Choisir --</option>
        <option value="L1">L1</option>
        <option value="L2">L2</option>
        <option value="L3">L3</option>
    </select>

    <button type="submit">Créer mon compte</button>
</form>

<p>Déjà un compte ? <a href="login.php">Se connecter</a></p>

<?php require_once '../includes/footer.php'; ?>