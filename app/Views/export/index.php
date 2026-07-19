<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exporter les donnees</title>
</head>
<body>
    <h2>Exporter les donnees</h2>

    <?php if ($tables === []): ?>
        <p>Aucune table disponible.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Table</th>
                    <th>CSV</th>
                    <th>Excel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tables as $table): ?>
                    <tr>
                        <td><?= esc($table) ?></td>
                        <td><a href="/admin/export/<?= rawurlencode($table) ?>/csv">Exporter CSV</a></td>
                        <td><a href="/admin/export/<?= rawurlencode($table) ?>/excel">Exporter Excel</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="/admin/dashboard">Retour au tableau de bord</a></p>
</body>
</html>
