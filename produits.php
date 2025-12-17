<?php
include 'includes/header.php';
include 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM produits");
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Nos laptops en promotion</h2>

    <div class="row">
        <?php if (empty($produits)): ?>
            <div class="col-12">
                <p class="text-muted text-center">Aucun produit disponible pour le moment.</p>
            </div>
        <?php else: ?>
            <?php foreach ($produits as $p): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="assets/img/<?php echo htmlspecialchars($p['image']); ?>" 
                         class="card-img-top" alt="<?php echo htmlspecialchars($p['nom']); ?>" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($p['nom']); ?></h5>
                        <p class="card-text"><?php echo substr(strip_tags($p['description']), 0, 80); ?>...</p>
                        <p class="h5 text-success font-weight-bold"><?php echo number_format($p['prix'], 2, ',', ' '); ?> €</p>
                        <p class="text-muted">Stock : <?php echo $p['stock'] > 0 ? $p['stock'] : '<span class="text-danger">Rupture</span>'; ?></p>
                        <a href="produit-detail.php?id=<?php echo $p['id']; ?>" 
                           class="btn btn-outline-primary btn-sm">Voir détail</a>
                        <?php if ($p['stock'] > 0): ?>
                            <a href="panier.php?ajout=<?php echo $p['id']; ?>" 
                               class="btn btn-achat btn-sm">Ajouter au panier</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>