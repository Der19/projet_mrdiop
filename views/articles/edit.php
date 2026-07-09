<div class="container">
    <div class="admin-header">
        <h2>Modifier l'Article #<?= $id ?></h2>
        <a href="index.php?controller=article&action=admin" class="btn btn-secondary">← Retour</a>
    </div>

    <?php foreach ($errors as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label>Titre</label>
                <input type="text" name="titre" value="<?= htmlspecialchars($article['titre']) ?>">
            </div>
            <div class="form-group">
                <label>Catégorie</label>
                <select name="categorie">
                    <option value="">-- Choisir --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $article['categorie'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Contenu</label>
                <textarea name="contenu"><?= htmlspecialchars($article['contenu']) ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="index.php?controller=article&action=admin" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
