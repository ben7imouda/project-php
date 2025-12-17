<?php
/**
 * Fichier contenant les fonctions utiles pour le site PC-Express
 * Projet réalisé par les élèves de la classe WebDev'25
 * - Dupont L., Martin A., Leroy C., Simon T.
 */

// Démarrage de la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Calcule le nombre total d'articles dans le panier
 * @return int nombre d'articles (somme des quantités)
 */
function nbArticlesPanier() {
    if (isset($_SESSION['panier']) && is_array($_SESSION['panier'])) {
        return array_sum($_SESSION['panier']);
    }
    return 0;
}

/**
 * Récupère un produit depuis son ID
 * @param PDO $pdo Instance de connexion à la BDD
 * @param int $id ID du produit
 * @return array|null Tableau du produit ou null si non trouvé
 */
function getProduitById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère tous les produits (utile pour la page produits)
 * @param PDO $pdo
 * @return array Liste des produits
 */
function getAllProduits($pdo) {
    $stmt = $pdo->query("SELECT * FROM produits ORDER BY nom ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Formate un prix en euros (ex : 899.99 → "899,99 €")
 * @param float $prix
 * @return string
 */
function formatPrix($prix) {
    return number_format($prix, 2, ',', ' ') . ' €';
}

/**
 * Vérifie si une chaîne est vide ou contient seulement des espaces
 * Similaire à empty(), mais plus strict pour les formulaires
 * @param string $str
 * @return bool
 */
function estVide($str) {
    return !isset($str) || trim($str) === '';
}

/**
 * Redirection simple (évite les "headers already sent")
 * Attention : à appeler AVANT tout affichage HTML
 * @param string $url Chemin relatif ou absolu
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Récupère le total du panier (prix calculé dynamiquement)
 * @param PDO $pdo
 * @return float
 */
function getTotalPanier($pdo) {
    $total = 0.0;
    if (!empty($_SESSION['panier']) && is_array($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $id => $quantite) {
            $produit = getProduitById($pdo, $id);
            if ($produit) {
                $total += $produit['prix'] * $quantite;
            }
        }
    }
    return $total;
}

/**
 * Génère une chaîne aléatoire (ex : pour numéro de commande)
 * @param int $longueur
 * @return string
 */
function genererReferenceCommande($longueur = 8) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $ref = '';
    for ($i = 0; $i < $longueur; $i++) {
        $ref .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return 'CMD-' . $ref;
}

/**
 * Vérifie si l'utilisateur est connecté (admin uniquement pour le moment)
 * @return bool
 */
function estAdminConnecte() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}

/**
 * Déconnexion admin
 */
function deconnecterAdmin() {
    unset($_SESSION['admin']);
    session_destroy(); // ou juste unset selon les choix (ici destructif, typique élève 😅)
}

?>