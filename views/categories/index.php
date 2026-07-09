<div class="container">
    <?php if ($msg): ?>
        <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>

    <div class="admin-header">
        <h2>Gestion des Catégories</h2>
        <a href="index.php?controller=categorie&action=create" class="btn btn-primary">+ Nouvelle Catégorie</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Libellé</th>
                <th>Nb articles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="4" style="text-align:center;padding:40px;color:#aaa;">Aucune catégorie.</td></tr>
            <?php else: ?>
                <?php foreach ($categories as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><?= htmlspecialchars($cat['libelle']) ?></td>
                        <td><span class="badge"><?= $cat['nb_articles'] ?></span></td>
                        <td>
                            <a href="index.php?controller=categorie&action=edit&id=<?= $cat['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <?php if ($cat['nb_articles'] == 0): ?>
                                <button class="btn btn-danger btn-sm"
                                    onclick="confirmDelete(
                                        'index.php?controller=categorie&action=delete&id=<?= $cat['id'] ?>',
                                        'Supprimer la catégorie &quot;<?= htmlspecialchars(addslashes($cat['libelle'])) ?>&quot; ?'
                                    )">Supprimer</button>
                            <?php else: ?>
                                <button class="btn btn-danger btn-sm" disabled style="opacity:0.4;cursor:not-allowed;" title="Des articles utilisent cette catégorie">Supprimer</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
