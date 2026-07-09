<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'MGLSI News') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav>
    <a href="index.php" class="logo">MGLSI News</a>
    <div class="nav-links">
        <a href="index.php?controller=article&action=index">Accueil</a>
        <a href="index.php?controller=article&action=admin">Gérer Articles</a>
        <a href="index.php?controller=categorie&action=index">Gérer Catégories</a>
    </div>
</nav>
