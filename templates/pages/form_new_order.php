<?php

/**
 * test_form_new_order.php
 * Template de page complète : Afficher le formulaire de création d'une nouvelle commande
 * Paramètres : 
 *      $categories - tableau des catégories
 */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nouvelle Commande</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<!-- Affichage du header -->
<?php include_once 'display_header_nav.php'; ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Créer une nouvelle commande</h1>
        <div>
            <a href="display_check_new_order.php" class="button">VOIR LE PANIER</a><br><br>
        </div>
        <!-- Liste des catégories -->
        <div id="categories-list" class="flex gap8 mB8">
            <?php foreach ($categories as $category): ?>
                <div class="category-item">
                    <a href="load_items.php" class="category-link flex" data-category-id="<?= $category->getId(); ?>">
                        <div class="category-image-container">
                            <img src="public/images<?= $category->image_path->html(); ?>" alt="<?= $category->title->html(); ?>" class="category-image">
                        </div>
                        <span><?= $category->title->html(); ?></span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Conteneur pour les produits ou menus ou boissons-->
        <div id="items-container">
            <!-- Le contenu sera chargé ici par form_new_order.js-->
        </div>
    </div>
    <!-- Lien JavaScript -->
    <script src="public/js/form_new_order.js" defer></script>
</body>

</html>