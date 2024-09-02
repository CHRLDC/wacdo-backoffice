<?php

/**
 * test_form_products_new_order_fragment.php
 */
?>
<?php if (!empty($products)): ?>
    <form action="add_to_cart.php" method="post">
        <p class="mB8"><strong>Avertissement: Composer qu'un seul produit à la fois</strong></p>
        <input type="hidden" name="form_type" value="products_form">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <p><strong><?= $product->name->html(); ?></strong> - <?= $product->price->html(); ?> €</p>
                <?php if (strpos(strtolower($product->name->html()), 'nuggets') !== false): ?>
                    <!-- Sélection de la sauce pour les nuggets -->
                    <select name="sauce-accompaniment[<?= $product->getId(); ?>]">
                        <option value="">Choisir une sauce</option>
                        <?php foreach ($sauces as $sauce): ?>
                            <option value="<?= $sauce->getId(); ?>"><?= $sauce->name->html(); ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <input type="number" name="quantity[<?= $product->getId(); ?>]" min="1" placeholder="Quantité">
                <button type="submit">Ajouter</button>
            </div>
        <?php endforeach; ?>
    </form>
<?php else: ?>
    <p>Aucun produit disponible dans cette catégorie.</p>
<?php endif; ?>