<?php

/**
 * details_product_fragment.php
 * Fragment de page: Affiche les détails d'un produit
 * Paramètres: $product 
 *             
 */
?>
<div class="product-details column gap16">
    <div class="flex gap8">
        <h4>Nom du Produit:</h4>
        <p><?= $product->name->html(); ?></p>
    </div>

    <div class="flex gap8">
        <h4>Catégorie:</h4>
        <p><?= $product->Category->target->title->html() ?></p>
    </div>


    <div class="flex gap8">
        <h4>Description:</h4><br>
        <p><?= $product->description->html(); ?></p>
    </div>

    <div class="flex gap8">
        <h4>Prix:</h4><br>
        <p><?= $product->price->html(); ?>€</p>
    </div>

    <div class="flex gap8">
        <h4>Statut:</h4><br>
        <p><?= $product->status->html(); ?></p>
    </div>

    <h4>Image:</h4><br>
    <div class="product-image-container mB16">
        <img src="../../public/images/<?= $product->image_path->html(); ?>" alt="<?= $product->name->html(); ?>">
    </div>
</div>