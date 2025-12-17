<?php
session_start();
// Vérif admin (simple — typique élève)
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
$message = '';

if ($_POST) {
    $nom = trim($_POST['nom'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $prix = str_replace(',', '.', $_POST['prix'] ?? '0'); // accepte 899,99 → 899.99
    $stock = (int)($_POST['stock'] ?? 10);

    // ✅ Gestion de l'image
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            // Nouveau nom : timestamp + .ext → évite les doublons
            $image_name = 'laptop_' . time() . '.' . $ext;
            $target = __DIR__ . '/../uploads/' . $image_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // OK, image enregistrée
            } else {
                $message = '<div class="alert alert-danger">❌ Erreur lors de l\'enregistrement de l\'image.</div>';
            }
        } else {
            $message = '<div class="alert alert-warning">⚠️ Format non autorisé (jpg, jpeg, png, webp).</div>';
        }
    }

    // Si pas d'erreur, on insère
    if (!$message) {
        $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, image, stock) 
                               VALUES (?, ?, ?, ?, ?)");
        $ok = $stmt->execute([$nom, $desc, $prix, $image_name, $stock]);

        if ($ok) {
            $message = '<div class="alert alert-success">✅ Produit ajouté avec succès !</div>';
            // Réinitialise le formulaire
            $_POST = [];
        } else {
            $message = '<div class="alert alert-danger">❌ Erreur lors de l\'ajout.</div>';
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<div class="container mt-4">
    <h2><i class="fas fa-plus-circle"></i> Ajouter un nouveau laptop</h2>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Ajouter</li>
        </ol>
    </nav>

    <?php if ($message): ?>
        <?= $message ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nom du laptop *</label>
                    <input type="text" name="nom" class="form-control" 
                           value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Prix (€) *</label>
                        <input type="number" step="0.01" name="prix" class="form-control" 
                               value="<?= htmlspecialchars($_POST['prix'] ?? '') ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control" 
                               value="<?= htmlspecialchars($_POST['stock'] ?? '10') ?>">
                    </div>
                </div>

                <!-- 🎯 CHAMP IMAGE — la partie que tu demandais -->
                <div class="form-group">
                    <label>Image du laptop (jpg, png, webp)</label>
                    <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input" id="imageInput" accept="image/*">
                        <label class="custom-file-label" for="imageInput">Choisir un fichier...</label>
                    </div>
                    <small class="form-text text-muted">
                        Taille max recommandée : 2 Mo | Format : JPG, PNG ou WebP
                    </small>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer le produit
                </button>
                <a href="dashboard.php" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>

<!-- JS pour le nom du fichier uploadé (Bootstrap custom-file) -->
<script>
document.getElementById('imageInput').onchange = function() {
    const fileName = this.files[0] ? this.files[0].name : 'Choisir un fichier...';
    document.querySelector('.custom-file-label').textContent = fileName;
};
</script>

<?php include '../includes/footer.php'; ?>