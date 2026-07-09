<?php
require_once 'db.php';

$pdo = getDB();
$errors = [];

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: admin_categories.php');
    exit;
}

$cat = $pdo->prepare("SELECT * FROM Categorie WHERE id = ?");
$cat->execute([$id]);
$cat = $cat->fetch(PDO::FETCH_ASSOC);

if (!$cat) {
    header('Location: admin_categories.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libelle = trim($_POST['libelle'] ?? '');

    if ($libelle === '') {
        $errors[] = 'Le libellé est obligatoire.';
    } elseif (strlen($libelle) > 20) {
        $errors[] = 'Le libellé ne doit pas dépasser 20 caractères.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE Categorie SET libelle = ? WHERE id = ?");
        $stmt->execute([$libelle, $id]);
        header('Location: admin_categories.php?success=updated');
        exit;
    }

    $cat['libelle'] = $libelle;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la Catégorie — MGLSI News</title>
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
        <h2>Modifier la Catégorie #<?= $id ?></h2>
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
                       value="<?= htmlspecialchars($cat['libelle']) ?>">
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
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
