<?php

/**
 * test_form_menus_new_order_fragment.php
 * Fragment: Formulaire d'ajout d'un menu
 *  Parametres:
 *      $products: liste des produits du menu
 */
?>

<?php if (!empty($products)): ?>
    <p class="mB8"><strong>Avertissement: Composer qu'un seul menu à la fois</strong></p>
    <form action="add_to_cart.php" method="post" class="form-menus column gap16">
        <input type="hidden" name="form_type" value="menus_form">
        <?php foreach ($products as $product): ?>
            <div class="product-item">
                <p class="mB8"><strong><?= $product->name->html(); ?></strong> - <?= $product->price->html(); ?> €</p>
                <!-- Sélection de la taille du menu -->
                <select name="size-menu[<?= $product->getId(); ?>]">
                    <option value="">Choisir une taille</option>
                    <option value="normal">Normal</option>
                    <option value="maxi">Maxi (+0.50€)</option>
                </select>

                <!-- Sélection de l'accompagnement -->
                <select name="accompaniment-menu[<?= $product->getId(); ?>]">
                    <option value="">Choisir un accompagnement</option>
                    <?php foreach ($accompaniments as $accompaniment): ?>
                        <option value="<?= $accompaniment->getId(); ?>"><?= $accompaniment->name->html(); ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Sélection de la boisson -->
                <select name="drink-menu[<?= $product->getId(); ?>]">
                    <option value="">Choisir une boisson</option>
                    <?php foreach ($drinks as $drink): ?>
                        <option value="<?= $drink->getId(); ?>"><?= $drink->name->html(); ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Sélection de la sauce -->
                <select name="sauce-menu[<?= $product->getId(); ?>]">
                    <option value="">Choisir une sauce</option>
                    <?php foreach ($sauces as $sauce): ?>
                        <option value="<?= $sauce->getId(); ?>"><?= $sauce->name->html(); ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="number" name="quantity[<?= $product->getId(); ?>]" min="1" placeholder="Quantité">
                <!-- Bouton pour ajouter au panier -->
                <button type="submit">Ajouter</button>
            </div>
        <?php endforeach; ?>
    </form>
<?php else: ?>
    <p>Aucun produit disponible dans cette catégorie.</p>
<?php endif; ?>