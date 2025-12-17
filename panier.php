<?php
// ✅ Démarrage de la session — DOIT être la TOUTE PREMIÈRE chose (pas d'espace avant !)
session_start();

// Inclusions (après session_start !)
include 'includes/db.php';
include 'includes/functions.php';

// ===== LOGIQUE : Gestion du panier =====
$message = '';

// ➕ Ajout d'un produit
if (isset($_GET['ajout'])) {
    $id = (int)$_GET['ajout'];
    $produit = getProduitById($pdo, $id);
    if ($produit) {
        // Incrémente la quantité (ou initialise à 1)
        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id]++;
        } else {
            $_SESSION['panier'][$id] = 1;
        }
        $message = '<div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> <strong>' . htmlspecialchars($produit['nom']) . '</strong> ajouté au panier !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span>&times;</span>
            </button>
        </div>';
    } else {
        $message = '<div class="alert alert-warning">Produit non trouvé.</div>';
    }
}

// ➖ Suppression d'un produit
if (isset($_GET['supp'])) {
    $id = (int)$_GET['supp'];
    unset($_SESSION['panier'][$id]);
    // Redirection propre (évite le re-submit si refresh)
    header("Location: panier.php");
    exit();
}

// ===== AFFICHAGE =====
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-shopping-cart text-primary"></i> Votre panier</h2>
        <a href="produits.php" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-laptop"></i> Continuer vos achats
        </a>
    </div>

    <?php if ($message): ?>
        <?= $message ?>
    <?php endif; ?>

    <?php if (empty($_SESSION['panier']) || count($_SESSION['panier']) === 0): ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-basket text-muted" style="font-size: 4rem;"></i>
            <h4 class="mt-3">Votre panier est vide.</h4>
            <p class="text-muted">Ajoutez des laptops pour commencer vos achats.</p>
            <a href="produits.php" class="btn btn-primary btn-lg mt-3">
                <i class="fas fa-plus"></i> Voir les produits
            </a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Produit</th>
                        <th class="text-right">Prix</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-right">Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalGeneral = 0;
                    foreach ($_SESSION['panier'] as $id => $quantite):
                        $produit = getProduitById($pdo, $id);
                        if (!$produit) continue;

                        $totalLigne = $produit['prix'] * $quantite;
                        $totalGeneral += $totalLigne;
                    ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($produit['nom']) ?></strong><br>
                            <small class="text-muted"><?= substr(htmlspecialchars($produit['description']), 0, 60) ?>...</small>
                        </td>
                        <td class="text-right"><?= formatPrix($produit['prix']) ?></td>
                        <td class="text-center"><?= $quantite ?></td>
                        <td class="text-right font-weight-bold"><?= formatPrix($totalLigne) ?></td>
                        <td class="text-right">
                            <a href="?supp=<?= $id ?>" class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Supprimer cet article ?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold">
                        <td colspan="3" class="text-right">Total :</td>
                        <td class="text-right"><?= formatPrix($totalGeneral) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-right mt-4">
            <button class="btn btn-success btn-lg" disabled>
                <i class="fas fa-credit-card"></i> Passer la commande
            </button>
            <small class="d-block text-muted mt-2">
                <i class="fas fa-lock"></i> Paiement sécurisé — Aucune donnée bancaire collectée (projet pédagogique)
            </small>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>