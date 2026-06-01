<?php
session_start();
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/header.php';

$recherche = trim($_GET['recherche'] ?? '');

if (!empty($recherche)) {
    $stmt = $pdo->prepare("
        SELECT * FROM courses 
        WHERE (titre LIKE ? OR enseignant LIKE ?)
    ");
    $terme = '%' . $recherche . '%';
    $stmt->execute([$terme, $terme]);
} else {
    $stmt = $pdo->query("SELECT * FROM courses");
}

$cours = $stmt->fetchAll();
?>

<h2>📚 Cours disponibles</h2>

<!-- Formulaire de recherche -->
<form method="GET" style="margin-bottom: 20px; display:flex; gap:10px;">
    <input 
        type="text" 
        name="recherche" 
        placeholder="Rechercher par titre ou enseignant..." 
        value="<?= htmlspecialchars($recherche) ?>"
        style="width:auto; flex:1;"
    >
    <button type="submit">🔍 Rechercher</button>
    <?php if (!empty($recherche)): ?>
        <a href="courses.php" style="padding:8px 15px; background:#ccc; border-radius:4px; text-decoration:none;">✖ Effacer</a>
    <?php endif; ?>
</form>

<?php if (!empty($recherche)): ?>
    <p>Résultats pour : <strong><?= htmlspecialchars($recherche) ?></strong></p>
<?php endif; ?>

<?php if (empty($cours)): ?>
    <div class="alert-error">Aucun cours trouvé.</div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Enseignant</th>
                <th>Niveau</th>
                <th>Volume horaire</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cours as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['titre']) ?></td>
                    <td><?= htmlspecialchars($c['enseignant']) ?></td>
                    <td><?= htmlspecialchars($c['niveau']) ?></td>
                    <td><?= htmlspecialchars($c['volume_horaire']) ?>h</td>
                    <td>
                        <?php if ($c['statut'] === 'actif'): ?>
                            <span style="color:green;">✔ Actif</span>
                        <?php else: ?>
                            <span style="color:red;">✖ Inactif</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($c['statut'] === 'actif'): ?>
                            <a href="enroll.php?course_id=<?= $c['id'] ?>">
                                <button>S'inscrire</button>
                            </a>
                        <?php else: ?>
                            <span style="color:#999;">Non disponible</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>