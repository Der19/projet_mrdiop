<div class="container">
    <div class="admin-header">
        <h2>Modifier la Catégorie #<?= $id ?></h2>
        <a href="index.php?controller=categorie&action=index" class="btn btn-secondary">← Retour</a>
    </div>

    <?php foreach ($errors as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label>Libellé <small style="color:#aaa;">(max 20 caractères)</small></label>
                <input type="text" name="libelle" maxlength="20"
                       value="<?= htmlspecialchars($categorie['libelle']) ?>">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="index.php?controller=categorie&action=index" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
