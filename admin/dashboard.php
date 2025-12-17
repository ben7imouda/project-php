<?php
$products = require_once __DIR__ . '/../includes/products.php';
?>
<div class="alert alert-success">
    ✅ Le fichier <code>products.php</code> a été chargé avec succès ! Il contient <?php echo count($products); ?> produit(s).
</div>

<h2>Liste des appareils :</h2>
<ul>
<?php foreach ($products as $p): ?>
    <li>
        <strong><?= htmlspecialchars($p['name']) ?></strong> — 
        <?= number_format($p['price'], 2, ',', ' ') ?> € — 
        <?= $p['in_stock'] ? 'Disponible' : 'Indisponible' ?>
    </li>
<?php endforeach; ?>
</ul>
<a href="index.php" class="btn btn-primary mt-3">Retour à l'accueil</a>