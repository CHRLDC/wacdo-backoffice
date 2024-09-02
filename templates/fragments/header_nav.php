<?php

/**
 * header_nav.php
 * Fonctionnalité : Affiche le menu de navigation
 */
?>
<header class="column justify-between">
    <div>
        <h3><?= $headerData['isConnected'] ? 'Bonjour ' . $headerData['firstName'] : ''; ?></h3>
        <p><?= $headerData['isConnected'] ? translate($headerData['role']) : ''; ?></p>
    </div>
    <nav>
        <ul class="column gap64">
            <li><a href="unlogin.php"><input type="button" value="Se déconnecter"></a></li>
            <li><a href="index.php"><input type="button" value="Liste des commandes"></a></li>
            <?php if ($headerData['showNewOrder']): ?>
                <li><a href="display_form_new_order.php"><input type="button" value="Nouvelle commande"></a></li>
            <?php endif; ?>
            <?php if ($headerData['showUserManagement']): ?>
                <li><a href="display_list_users.php"><input type="button" value="Gestion des utilisateurs"></a></li>
            <?php endif; ?>
            <?php if ($headerData['showProductManagement']): ?>
                <li><a href="display_list_product.php"><input type="button" value="Gestion des produits"></a></li>
            <?php endif; ?>
        </ul>

    </nav>
    <div id="cookie-banner" class="column gap8">
        <p>Nous utilisons des cookies pour le bon fonctionnement de notre site. En continuant à naviguer, vous acceptez notre <a href="display_rgpd.php">politique de gestion des cookies</a>.</p>
        <button id="cookie-accept">J'accepte</button>
        <button id="cookie-refuse">Je refuse</button>
    </div>
    <div>
        <a href="display_rgpd.php">Vos données personelles</a>
    </div>
</header>

<!-- Script pour le bandeau de consentement, suit toutes les pages -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Récupérer les boutons et le bandeau
        const cookieBanner = document.getElementById('cookie-banner');
        const acceptButton = document.getElementById('cookie-accept');
        const refuseButton = document.getElementById('cookie-refuse');

        // Vérifier si l'utilisateur a déjà exprimé son choix
        if (localStorage.getItem('cookiesAccepted') !== null) {
            cookieBanner.style.display = 'none';
        }

        // Ajouter un événement au bouton "J'accepte"
        acceptButton.addEventListener('click', function() {
            // Masquer le bandeau
            cookieBanner.style.display = 'none';
            // Enregistrer le consentement dans localStorage
            localStorage.setItem('cookiesAccepted', 'true');
        });

        // Ajouter un événement au bouton "Je refuse"
        refuseButton.addEventListener('click', function() {
            // Masquer le bandeau
            cookieBanner.style.display = 'none';
            // Enregistrer le refus dans localStorage
            localStorage.setItem('cookiesAccepted', 'false');
        });
    });
</script>