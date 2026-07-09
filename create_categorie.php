<?php
require_once 'db.php';

$pdo = getDB();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libelle = trim($_POST['libelle'] ?? '');

    if ($libelle === '') {
        $errors[] = 'Le libellé est obligatoire.';
    } elseif (strlen($libelle) > 20) {
        $errors[] = 'Le libellé ne doit pas dépasser 20 caractères.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO Categorie (libelle) VALUES (?)");
        $stmt->execute([$libelle]);
        header('Location: admin_categories.php?success=created');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Catégorie — MGLSI News</title>
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
    <div class="admin-header">
        <h2>Nouvelle Catégorie</h2>
        <a href="admin_categories.php" class="btn btn-secondary">← Retour</a>
    </div>

    <?php foreach ($errors as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label for="libelle">Libellé <small style="color:#aaa;">(max 20 caractères)</small></label>
                <input type="text" id="libelle" name="libelle" maxlength="20"
                       value="<?= htmlspecialchars($_POST['libelle'] ?? '') ?>"
                       placeholder="Ex: Technologie">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Créer</button>
                <a href="admin_categories.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2024 MGLSI News — Tous droits réservés</p>
</footer>
</body>
</html>
