<?php

/*
* product_manage.php
* Template de page complète : affiche le formulaire pour modifier ou ajouter un produit ou les détails du produit
* Paramètres :
*    $product : objet à afficher
*    $actionUrl: action du formulaire
*    $isEdit: mode édition (true) ou mode création (false).
     $categories: liste des catégories
*
*/
// Autorisation d'afficher la page
if (!defined('ALLOWED')) {
    header("Location: unauthorized.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title><?= $isEdit ? 'Modifier le produit' : 'Ajouter un produit'; ?></title>
</head>
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Gérer les produits</h1>
        <nav class="mB16">
            <a href="display_list_product.php"><input type="button" value="Retour à la liste des produits"></a>
        </nav>
        <!-- Affichage du fragment details ou form -->
        <?php if ($idProduct && !$isEdit): ?>
            <!-- Affichage des détails du produit -->
            <?php include_once "templates/fragments/details_product_fragment.php"; ?>
            <a href="display_product_manage.php?id=<?= $product->getId(); ?>&mode=edit"><input type="button" value="Modifier"></a>
            <a href="remove_product.php?id=<?= $product->getId(); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');"><input type="button" value="Supprimer"></a>
        <?php else: ?>
            <!-- Affichage du formulaire pour création ou modification -->
            <?php include_once "templates/fragments/form_product_fragment.php"; ?>
        <?php endif; ?>
    </div>
</body>

</html>