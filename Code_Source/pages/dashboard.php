<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

// Compter les inscriptions de l'étudiant
$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM registrations WHERE student_id = ?");
$stmt->execute([$_SESSION['student_id']]);
$total = $stmt->fetch()['total'];
?>

<h2>Bienvenue, <?= htmlspecialchars($_SESSION['student_nom']) ?> 👋</h2>
<p>Vous êtes connecté à votre espace étudiant.</p>

<div style="display:flex; gap:20px; margin-top:20px;">
    <div style="background:#2c3e50; color:white; padding:20px; border-radius:8px; text-align:center; flex:1;">
        <h3><?= $total ?></h3>
        <p>Cours inscrits</p>
    </div>
    <div style="background:#27ae60; color:white; padding:20px; border-radius:8px; text-align:center; flex:1;">
        <a href="courses.php" style="color:white; text-decoration:none;">
            <h3>📚</h3>
            <p>Voir les cours</p>
        </a>
    </div>
    <div style="background:#2980b9; color:white; padding:20px; border-radius:8px; text-align:center; flex:1;">
        <a href="my_registrations.php" style="color:white; text-decoration:none;">
            <h3>📋</h3>
            <p>Mes inscriptions</p>
        </a>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>