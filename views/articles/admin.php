<div class="container">
    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="admin-header">
        <h2>Gestion des Articles</h2>
        <a href="index.php?controller=article&action=create" class="btn btn-primary">+ Nouvel Article</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($articles)): ?>
                <tr><td colspan="5" style="text-align:center;padding:40px;color:#aaa;">Aucun article.</td></tr>
            <?php else: ?>
                <?php foreach ($articles as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['titre']) ?></td>
                        <td><span class="badge"><?= htmlspecialchars($a['categorie_nom']) ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($a['dateCreation'])) ?></td>
                        <td>
                            <a href="index.php?controller=article&action=edit&id=<?= $a['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <button class="btn btn-danger btn-sm"
                                onclick="confirmDelete(
                                    'index.php?controller=article&action=delete&id=<?= $a['id'] ?>',
                                    'Supprimer &quot;<?= htmlspecialchars(addslashes($a['titre'])) ?>&quot; ?'
                                )">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
