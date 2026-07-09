<?php
require_once 'db.php';

$pdo = getDB();
$id  = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    // Vérifie qu'aucun article n'utilise cette catégorie
    $check = $pdo->prepare("SELECT COUNT(*) FROM Article WHERE categorie = ?");
    $check->execute([$id]);
    if ($check->fetchColumn() == 0) {
        $stmt = $pdo->prepare("DELETE FROM Categorie WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header('Location: admin_categories.php?success=deleted');
exit;
