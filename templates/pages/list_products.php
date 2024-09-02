<?php

/*
* list_products.php
* Template de page complète : Affiche la liste des produits (option de tri par catégorie)
* Paramètres :
*    $product_list : liste des produits
*    $category_list : liste des catégories
*    GET['category_id'] : ID de la catégorie
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
    <title>Liste des produits</title>
</head>
<!-- Affichage du header -->
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Gestion des Produits</h1>
        <a href="display_product_manage.php"><input type="button" class="mB16 button" value="Ajouter un produit"></a>
        <!-- Formulaire de tri par catégorie -->
        <form method="GET">
            <label for="category">Trier par catégorie :</label>
            <select name="category_id" id="category" class="mB16">
                <option value="full">Toutes les catégories</option>
                <?php foreach ($category_list as $category): ?>
                    <option value="<?= $category->getId(); ?>" <?= (isset($_GET['category_id']) && $_GET['category_id'] == $category->getId()) ? 'selected' : ''; ?>>
                        <?= $category->title->html(); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Trier</button>
        </form>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Nom du produit</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Affichage de la liste des produits (triée) -->
                <?php foreach ($product_list as $product): ?>
                    <?php if (!isset($_GET['category_id']) || $_GET['category_id'] === 'full' || $_GET['category_id'] == $product->Category->value): ?>
                        <tr data-categorie="<?= $product->Category->html(); ?>">
                            <td><?= $product->name->html(); ?></td>
                            <td><?= $product->Category->target->title->html(); ?></td>
                            <td>
                                <a href="display_product_manage.php?id=<?= $product->getId(); ?>">Gérer</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</body>

</html>