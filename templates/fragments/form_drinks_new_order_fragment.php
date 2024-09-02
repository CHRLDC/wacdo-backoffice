<?php

/**
 * form_drinks_new_order_fragment.php
 * Fragment de page: Formulaire d'ajout d'une boisson
 */
?>
<?php if (!empty($products)): ?>
    <form action="add_to_cart.php" method="post">
        <p class="mB8"><strong>Avertissement: Composer qu'une seule boisson à la fois</strong></p>
        <input type="hidden" name="form_type" value="drinks_form">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <p><strong><?= $product->name->html(); ?></strong> - <?= $product->price->html(); ?> €</p>
                <select name="size-drink[<?= $product->getId(); ?>]">
                    <option value="">Choisir une taille</option>
                    <option value="30cl">30cl</option>
                    <option value="50cl">50cl (+0.50€)</option>
                </select>
                <input type="number" name="quantity[<?= $product->getId(); ?>]" min="1" placeholder="Quantité">
                <button type="submit">Ajouter</button>
            </div>
        <?php endforeach; ?>
    </form>
<?php else: ?>
    <p>Aucun produit disponible dans cette catégorie.</p>
<?php endif; ?>