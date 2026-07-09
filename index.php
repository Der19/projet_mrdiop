<?php
require_once 'db.php';

$pdo = getDB();

// Récupérer toutes les catégories
$categories = $pdo->query("SELECT * FROM Categorie ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);

// Filtre par catégorie
$catId = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

if ($catId > 0) {
    $stmt = $pdo->prepare("
        SELECT a.*, c.libelle AS categorie_nom
        FROM Article a
        JOIN Categorie c ON a.categorie = c.id
        WHERE a.categorie = ?
        ORDER BY a.dateCreation DESC
    ");
    $stmt->execute([$catId]);
} else {
    $stmt = $pdo->query("
        SELECT a.*, c.libelle AS categorie_nom
        FROM Article a
        JOIN Categorie c ON a.categorie = c.id
        ORDER BY a.dateCreation DESC
    ");
}
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MGLSI News</title>
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

<header>
    <h1>MGLSI News</h1>
    <p>Restez informé de l'actualité</p>
</header>

<div class="categories-bar">
    <a href="index.php" class="cat-btn <?= $catId === 0 ? 'active' : '' ?>">Toutes</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?cat=<?= $cat['id'] ?>"
           class="cat-btn <?= $catId === (int)$cat['id'] ? 'active' : '' ?>">
            <?= htmlspecialchars($cat['libelle']) ?>
        </a>
    <?php endforeach; ?>
</div>

<div class="container">
    <?php if (empty($articles)): ?>
        <div class="empty">
            <div class="icon">📰</div>
            <p>Aucun article dans cette catégorie.</p>
        </div>
    <?php else: ?>
        <div class="articles-grid">
            <?php foreach ($articles as $article): ?>
                <div class="article-card">
                    <span class="card-badge"><?= htmlspecialchars($article['categorie_nom']) ?></span>
                    <div class="card-body">
                        <h2><?= htmlspecialchars($article['titre']) ?></h2>
                        <p><?= htmlspecialchars($article['contenu']) ?></p>
                    </div>
                    <div class="card-footer">
                        <span class="card-date">
                            <?= date('d/m/Y', strtotime($article['dateCreation'])) ?>
                        </span>
                        <div class="card-actions">
                            <a href="edit_article.php?id=<?= $article['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $article['id'] ?>, '<?= htmlspecialchars(addslashes($article['titre'])) ?>')">Supprimer</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal confirmation suppression -->
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
    document.getElementById('deleteLink').href = 'delete_article.php?id=' + id + '&ref=index';
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
