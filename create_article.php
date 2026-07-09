<?php
require_once 'db.php';

$pdo = getDB();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $cat     = (int)($_POST['categorie'] ?? 0);

    if ($titre === '')  $errors[] = 'Le titre est obligatoire.';
    if ($contenu === '') $errors[] = 'Le contenu est obligatoire.';
    if ($cat <= 0)      $errors[] = 'Veuillez choisir une catégorie.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO Article (titre, contenu, categorie) VALUES (?, ?, ?)");
        $stmt->execute([$titre, $contenu, $cat]);
        header('Location: admin_articles.php?success=created');
        exit;
    }
}

$categories = $pdo->query("SELECT * FROM Categorie ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel Article — MGLSI News</title>
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
        <h2>Nouvel Article</h2>
        <a href="admin_articles.php" class="btn btn-secondary">← Retour</a>
    </div>

    <?php foreach ($errors as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" id="titre" name="titre"
                       value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
                       placeholder="Titre de l'article">
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= (isset($_POST['categorie']) && $_POST['categorie'] == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea id="contenu" name="contenu" placeholder="Contenu de l'article..."><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Publier</button>
                <a href="admin_articles.php" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<footer>
    <p>&copy; 2024 MGLSI News — Tous droits réservés</p>
</footer>
</body>
</html>
