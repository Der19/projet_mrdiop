<?php
require_once 'db.php';

$pdo = getDB();

$msg = '';
if (isset($_GET['success'])) {
    $msg = match($_GET['success']) {
        'created' => 'Article créé avec succès.',
        'updated' => 'Article modifié avec succès.',
        'deleted' => 'Article supprimé avec succès.',
        default    => ''
    };
}

$articles = $pdo->query("
    SELECT a.*, c.libelle AS categorie_nom
    FROM Article a
    JOIN Categorie c ON a.categorie = c.id
    ORDER BY a.dateCreation DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Articles — MGLSI News</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav>
    <a href="index.php" class="logo">MGLSI News</a>
    <div class="nav-links">
        <a href="index.php">Accueil</a>
        <a href="admin_articles.php">Gérer Articles</a>
        <a href="admin_categories.php">Gérer Catégories</a>
    </div>
</nav>

<div class="container">
    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="admin-header">
        <h2>Gestion des Articles</h2>
        <a href="create_article.php" class="btn btn-primary">+ Nouvel Article</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($articles)): ?>
                <tr><td colspan="5" style="text-align:center;padding:40px;color:#aaa;">Aucun article.</td></tr>
            <?php else: ?>
                <?php foreach ($articles as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['titre']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($a['categorie_nom']) ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($a['dateCreation'])) ?></td>
                        <td>
                            <a href="edit_article.php?id=<?= $a['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $a['id'] ?>, '<?= htmlspecialchars(addslashes($a['titre'])) ?>')">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal">
        <h3>Confirmer la suppression</h3>
        <p id="deleteMsg"></p>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeModal()">Annuler</button>
            <a href="#" id="deleteLink" class="btn btn-danger">Supprimer</a>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2024 MGLSI News — Tous droits réservés</p>
</footer>

<script>
function confirmDelete(id, titre) {
    document.getElementById('deleteMsg').textContent = 'Voulez-vous supprimer "' + titre + '" ?';
    document.getElementById('deleteLink').href = 'delete_article.php?id=' + id;
    document.getElementById('deleteModal').classList.add('active');
}
function closeModal() {
    document.getElementById('deleteModal').classList.remove('active');
}
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
</body>
</html>
