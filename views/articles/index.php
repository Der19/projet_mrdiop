<header>
    <div class="masthead-line">
        <hr><h1>MGLSI News</h1><hr>
    </div>
    <p>Restez informé de l'actualité</p>
</header>

<div class="categories-bar">
    <a href="index.php?controller=article&action=index" class="cat-btn <?= $catId === 0 ? 'active' : '' ?>">Toutes</a>
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?controller=article&action=index&cat=<?= $cat['id'] ?>"
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
                        <span class="card-date"><?= date('d/m/Y', strtotime($article['dateCreation'])) ?></span>
                        <div class="card-actions">
                            <a href="index.php?controller=article&action=edit&id=<?= $article['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmDelete(
                                    'index.php?controller=article&action=delete&id=<?= $article['id'] ?>&ref=index',
                                    'Supprimer &quot;<?= htmlspecialchars(addslashes($article['titre'])) ?>&quot; ?'
                                )">Supprimer</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
