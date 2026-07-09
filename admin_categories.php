<?php
require_once 'db.php';

$pdo = getDB();
$msg = '';
if (isset($_GET['success'])) {
    $msg = match($_GET['success']) {
        'created' => 'Catégorie créée avec succès.',
        'updated' => 'Catégorie modifiée avec succès.',
        'deleted' => 'Catégorie supprimée avec succès.',
        default    => ''
    };
}

$categories = $pdo->query("
    SELECT c.*, COUNT(a.id) AS nb_articles
    FROM Categorie c
    LEFT JOIN Article a ON a.categorie = c.id
    GROUP BY c.id
    ORDER BY c.libelle
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Catégories — MGLSI News</title>
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
        <h2>Gestion des Catégories</h2>
        <a href="create_categorie.php" class="btn btn-primary">+ Nouvelle Catégorie</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Libellé</th>
                <th>Nb articles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="4" style="text-align:center;padding:40px;color:#aaa;">Aucune catégorie.</td></tr>
            <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['libelle']) ?></td>
                        <td><span class="badge"><?= $cat['nb_articles'] ?></span></td>
                        <td>
                            <a href="edit_categorie.php?id=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <?php if ($cat['nb_articles'] == 0): ?>
                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $cat['id'] ?>, '<?= htmlspecialchars(addslashes($cat['libelle'])) ?>')">Supprimer</button>
                            <?php else: ?>
                                <button class="btn btn-danger btn-sm" disabled title="Impossible : des articles utilisent cette catégorie" style="opacity:0.5;cursor:not-allowed;">Supprimer</button>
                            <?php endif; ?>
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
function confirmDelete(id, libelle) {
    document.getElementById('deleteMsg').textContent = 'Voulez-vous supprimer la catégorie "' + libelle + '" ?';
    document.getElementById('deleteLink').href = 'delete_categorie.php?id=' + id;
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
