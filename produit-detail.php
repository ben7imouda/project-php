<?php
// Démarrage de la session pour le panier
session_start();

// Inclusions nécessaires
include 'includes/db.php';
include 'includes/functions.php';

// Récupération de l'ID depuis l'URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Si l'ID n'est pas valide → redirection vers produits
if ($id <= 0) {
    redirect('produits.php');
}

// Récupération du produit
$produit = getProduitById($pdo, $id);

// Si produit non trouvé → message + redirection soft
if (!$produit) {
    $erreur = "Le produit demandé est introuvable.";
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item"><a href="produits.php">Produits</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php echo $produit ? htmlspecialchars($produit['nom']) : 'Produit inconnu'; ?>
            </li>
        </ol>
    </nav>

    <?php if (isset($erreur)): ?>
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($erreur); ?>
            <br><br>
            <a href="produits.php" class="btn btn-outline-primary">← Retour à la liste</a>
        </div>
    <?php elseif ($produit): ?>
        <div class="row">
            <!-- Colonne image -->
            <div class="col-md-5">
                <?php
                $image = !empty($produit['image']) ? 'assets/img/' . $produit['image'] : 'https://via.placeholder.com/400x300/e9ecef/6c757d?text=Pas+d%27image';
                ?>
                <img src="<?php echo htmlspecialchars($image); ?>" 
                     alt="<?php echo htmlspecialchars($produit['nom']); ?>"
                     class="img-fluid rounded shadow-sm"
                     onerror="this.src='https://via.placeholder.com/400x300/f8d7da/721c24?text=Image+indisponible'">
            </div>

            <!-- Colonne infos -->
            <div class="col-md-7">
                <h1 class="display-5"><?php echo htmlspecialchars($produit['nom']); ?></h1>
                <p class="lead text-success font-weight-bold"><?php echo formatPrix($produit['prix']); ?></p>

                <?php if ($produit['stock'] > 0): ?>
                    <span class="badge badge-success mb-3">En stock (<?php echo $produit['stock']; ?> unités)</span>
                <?php else: ?>
                    <span class="badge badge-danger mb-3">Rupture de stock</span>
                <?php endif; ?>

                <div class="mt-4">
                    <h5>Description</h5>
                    <p><?php echo nl2br(htmlspecialchars($produit['description'])); ?></p>
                </div>

                <!-- Boutons d'action -->
                <div class="mt-4">
                    <?php if ($produit['stock'] > 0): ?>
                        <a href="panier.php?ajout=<?php echo $produit['id']; ?>" 
                           class="btn btn-achat btn-lg btn-block">
                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-lg btn-block" disabled>
                            <i class="fas fa-times"></i> Indisponible
                        </button>
                    <?php endif; ?>

                    <a href="produits.php" class="btn btn-outline-secondary btn-block mt-2">
                        ← Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <!-- Section technique (simulée, en dur pour le projet scolaire) -->
        <div class="row mt-5">
            <div class="col">
                <h4>Caractéristiques techniques</h4>
                <table class="table table-sm table-bordered">
                    <tbody>
                        <tr><th>Écran</th><td>15.6 pouces Full HD (1920x1080)</td></tr>
                        <tr><th>Processeur</th><td>AMD Ryzen 7 5800H / Intel Core i7-1260P (selon modèle)</td></tr>
                        <tr><th>Mémoire RAM</th><td>16 Go DDR4</td></tr>
                        <tr><th>Stockage</th><td>512 Go SSD NVMe</td></tr>
                        <tr><th>Carte graphique</th><td>NVIDIA GeForce RTX 3050 (4 Go)</td></tr>
                        <tr><th>Batterie</th><td>Jusqu'à 6h d'autonomie</td></tr>
                    </tbody>
                </table>
                <p class="text-muted small">
                    <i class="fas fa-info-circle"></i> Les spécifications peuvent varier selon la configuration choisie.
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>