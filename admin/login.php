<?php
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Supprimer un produit
if (isset($_GET['remove'])) {
    $id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header('Location: index.php?page=cart');
    exit;
}

// Calcul du total
$products = require_once '../includes/products.php';
$total = 0;
?>

<h2><i class="fas fa-shopping-cart me-2"></i> Votre panier</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <div class="alert alert-info d-flex align-items-center">
        <i class="fas fa-info-circle fa-2x me-3"></i>
        <div>
            Votre panier est vide.<br>
            <a href="index.php?page=home" class="btn btn-outline-primary mt-2">Découvrir nos laptops</a>
        </div>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $id => $item):
                    // Trouver le produit
                    $product = null;
                    foreach ($products as $p) {
                        if ($p['id'] === $id) { $product = $p; break; }
                    }
                    if (!$product) continue;

                    $lineTotal = $item['price'] * $item['quantity'];
                    $total += $lineTotal;
                ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="assets/img/<?= $product['image'] ?>" width="50" class="rounded me-3">
                                <div>
                                    <div><?= htmlspecialchars($product['name']) ?></div>
                                    <small class="text-muted"><?= $product['brand'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?= number_format($item['price'], 2, ',', ' ') ?> €</td>
                        <td>
                            <input type="number" class="form-control form-control-sm update-qty"
                                   value="<?= $item['quantity'] ?>" min="1" max="10"
                                   data-id="<?= $id ?>" style="width:70px;">
                        </td>
                        <td><strong><?= number_format($lineTotal, 2, ',', ' ') ?> €</strong></td>
                        <td>
                            <a href="index.php?page=cart&remove=<?= $id ?>" class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Supprimer cet article ?')">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 p-4 bg-light rounded">
        <h4 class="mb-3 mb-md-0">Total : <span class="text-success"><?= number_format($total, 2, ',', ' ') ?> €</span></h4>
        <div>
            <a href="index.php?page=home" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Continuer mes achats
            </a>
            <a href="index.php?page=checkout" class="btn btn-success">
                <i class="fas fa-check-circle me-1"></i> Valider la commande
            </a>
        </div>
    </div>
<?php endif; ?>

<script>
$(document).on('change', '.update-qty', function() {
    const id = $(this).data('id');
    const qty = $(this).val();
    
    $.post('cart_handler.php', {
        action: 'update',
        id: id,
        quantity: qty
    }, function() {
        location.reload();
    });
});
</script>