<?php
require_once 'db.php';

$pdo = getDB();
$id  = (int)($_GET['id'] ?? 0);
$ref = $_GET['ref'] ?? '';

if ($id > 0) {
    $stmt = $pdo->prepare("DELETE FROM Article WHERE id = ?");
    $stmt->execute([$id]);
}

if ($ref === 'index') {
    header('Location: index.php?success=deleted');
} else {
    header('Location: admin_articles.php?success=deleted');
}
exit;
