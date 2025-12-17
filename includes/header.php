<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC-Express — Ordinateurs portables haut de gamme</title>
    <!-- Bootstrap 4.6 (CDN stable) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Favicon (students often forget — but this one didn’t ) -->
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
</head>
<body>

<!-- 🔝 Top bar (subtle, pro touch) -->
<div class="bg-primary text-white small py-1 d-none d-md-block">
    <div class="container d-flex justify-content-between">
        <span>✈️ Livraison offerte dès 99 €</span>
        <span>Tél. : <strong>05 00 00 00 01</strong> (9h–18h)</span>
    </div>
</div>

<!-- 🎯 Main header -->
<header class="bg-white shadow-sm sticky-top">
    <div class="container py-2">
        <div class="d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a href="index.php" class="d-flex align-items-center text-dark text-decoration-none">
                <div class="bg-primary text-white rounded px-2 py-1 mr-2"><strong>PC</strong></div>
                <span class="h4 mb-0 font-weight-bold" style="letter-spacing: -0.5px;">Express</span>
            </a>

            <!-- Search bar (compact, realistic for students) -->
            <div class="d-none d-lg-block w-50">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Rechercher un laptop (ex: gaming, ultrabook)" aria-label="Recherche">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Actions (Panier + Contact) -->
            <div class="d-flex align-items-center">
                <a href="contact.php" class="text-muted mx-2 mx-lg-3" title="Besoin d'aide ?">
                    <i class="fas fa-headset fa-lg"></i>
                </a>
                <a href="panier.php" class="btn btn-outline-dark position-relative" title="Votre panier">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" class="badge badge-danger badge-pill" style="position: absolute; top: -8px; right: -8px; font-size: 0.7em;">
                        <?php
                        // Simple & safe: use function if available, fallback otherwise
                        if (function_exists('nbArticlesPanier')) {
                            echo nbArticlesPanier();
                        } else {
                            echo isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0;
                        }
                        ?>
                    </span>
                </a>
            </div>
        </div>

        <!-- 📱 Mobile: simplified search -->
        <div class="d-lg-none mt-2">
            <div class="input-group input-group-sm">
                <input type="text" class="form-control" placeholder="Rechercher...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation (clean, centered, modern) -->
    <nav class="bg-light py-2">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'font-weight-bold text-primary' : 'text-dark'; ?>" 
                       href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'produits.php' ? 'font-weight-bold text-primary' : 'text-dark'; ?>" 
                       href="produits.php">Ordinateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) === 'contact.php' ? 'font-weight-bold text-primary' : 'text-dark'; ?>" 
                       href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </nav>
</header>