<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$student_id = $_SESSION['student_id'];

// Récupérer les cours inscrits avec les détails
$stmt = $pdo->prepare("
    SELECT c.titre, c.enseignant, c.niveau, c.volume_horaire, c.statut, r.created_at
    FROM registrations r
    JOIN courses c ON r.course_id = c.id
    WHERE r.student_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$student_id]);
$inscriptions = $stmt->fetchAll();

$succes = htmlspecialchars($_GET['succes'] ?? '');
?>

<h2>📋 Mes inscriptions</h2>

<?php if ($succes): ?>
    <div class="alert-success"><?= $succes ?></div>
<?php endif; ?>

<?php if (empty($inscriptions)): ?>
    <div class="alert-error">
        Vous n'êtes inscrit à aucun cours. 
        <a href="courses.php">Voir les cours disponibles</a>
    </div>
<?php else: ?>
    <p>Vous êtes inscrit à <strong><?= count($inscriptions) ?></strong> cours.</p>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Enseignant</th>
                <th>Niveau</th>
                <th>Volume horaire</th>
                <th>Statut</th>
                <th>Date d'inscription</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inscriptions as $i): ?>
                <tr>
                    <td><?= htmlspecialchars($i['titre']) ?></td>
                    <td><?= htmlspecialchars($i['enseignant']) ?></td>
                    <td><?= htmlspecialchars($i['niveau']) ?></td>
                    <td><?= htmlspecialchars($i['volume_horaire']) ?>h</td>
                    <td>
                        <?php if ($i['statut'] === 'actif'): ?>
                            <span style="color:green;">✔ Actif</span>
                        <?php else: ?>
                            <span style="color:red;">✖ Inactif</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($i['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>