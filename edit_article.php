<?php
require_once 'db.php';

$pdo = getDB();
$errors = [];

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: admin_articles.php');
    exit;
}

$article = $pdo->prepare("SELECT * FROM Article WHERE id = ?");
$article->execute([$id]);
$article = $article->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header('Location: admin_articles.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $cat     = (int)($_POST['categorie'] ?? 0);

    if ($titre === '')  $errors[] = 'Le titre est obligatoire.';
    if ($contenu === '') $errors[] = 'Le contenu est obligatoire.';
    if ($cat <= 0)      $errors[] = 'Veuillez choisir une catégorie.';

    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE Article
            SET titre = ?, contenu = ?, categorie = ?, dateModification = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$titre, $contenu, $cat, $id]);
        header('Location: admin_articles.php?success=updated');
        exit;
    }

    $article['titre']    = $titre;
    $article['contenu']  = $contenu;
    $article['categorie'] = $cat;
}

$categories = $pdo->query("SELECT * FROM Categorie ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'Article — MGLSI News</title>
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
        <h2>Modifier l'Article #<?= $id ?></h2>
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
                       value="<?= htmlspecialchars($article['titre']) ?>">
            </div>
            <div class="form-group">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= $article['categorie'] == $cat['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="contenu">Contenu</label>
                <textarea id="contenu" name="contenu"><?= htmlspecialchars($article['contenu']) ?></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
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
