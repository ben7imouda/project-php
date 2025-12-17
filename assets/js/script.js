// PC-Express — script.js
// Version 1.0 — Frontend interactions & UX enhancements
// © 2025 PC-Express — Tous droits réservés

$(document).ready(function() {

    // 1. Effet de survol sur les cartes produits : soulignement visuel et léger décalage
    $('.card').hover(
        function() {
            $(this).addClass('shadow-lg').css('transform', 'translateY(-3px)');
        },
        function() {
            $(this).removeClass('shadow-lg').css('transform', 'translateY(0)');
        }
    );

    // 2. Feedback utilisateur lors de l'ajout au panier
    // Affichage d'un état de chargement pendant 800ms avant redirection
    $('a[href*="panier.php?ajout="]').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);

        btn.html('<i class="fas fa-spinner fa-spin"></i> Ajout en cours...')
           .addClass('disabled btn-secondary')
           .removeClass('btn-achat');

        setTimeout(function() {
            window.location.href = btn.attr('href');
        }, 800);
    });

    // 3. Mise à jour dynamique du badge du panier (pour usage futur en AJAX)
    // Actuellement non utilisé — réservé à une évolution du système
    function updatePanierBadge() {
        var $badge = $('.navbar .badge');
        if ($badge.length) {
            var current = parseInt($badge.text()) || 0;
            $badge.text(current + 1).removeClass('badge-warning').addClass('badge-danger');
        }
    }

    // 4. Validation côté client du formulaire de contact
    // Vérification des champs obligatoires et format minimal de l'email
    $('#form-contact').on('submit', function(e) {
        var nom = $('#nom').val().trim();
        var email = $('#email').val().trim();
        var message = $('#message').val().trim();

        if (nom === '' || email === '' || message === '') {
            e.preventDefault();
            alert('Veuillez remplir tous les champs.');
            return false;
        }

        // Validation basique de l'email (présence de '@' et '.')
        if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
            e.preventDefault();
            alert('Veuillez saisir une adresse email valide.');
            return false;
        }
    });

    // 5. Bouton de retour en haut de page
    // Apparaît après défilement de 300px, avec animation fluide
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('#btn-top').fadeIn();
        } else {
            $('#btn-top').fadeOut();
        }
    });

    $('#btn-top').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 400);
        return false;
    });

    // Initialisation terminée
    console.log('[PC-Express] Script principal chargé — OK');
});