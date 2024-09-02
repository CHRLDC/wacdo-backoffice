<?php

/**
 * form_product_fragment.php
 * Fragment de formulaire pour ajouter/modifier un produit
 * Paramètres:
 *      $isEdit: mode édition (true) ou mode création (false).
 *      $actionUrl: action du formulaire
 *      $categories: liste des catégories
 *      $product: objet produit
 */

?>

<form method="POST" action="<?= $actionUrl; ?>" enctype="multipart/form-data">
    <?php if ($isEdit): ?>
        <!-- Champ caché pour l'ID du produit (pour la modification) -->
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product->getId()); ?>">
    <?php endif; ?>

    <label for="category">Catégorie:</label><br>
    <select id="category" name="category" required>
        <option value="">Sélectionnez une catégorie</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->getId(); ?>"
                <?= $isEdit && $product->Category->value == $category->getId() ? 'selected' : ''; ?>>
                <?= $category->title->html(); ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="name">Nom du Produit:</label><br>
    <input type="text" id="name" name="name" value="<?= $isEdit ? $product->name->html() : ''; ?>" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required><?= $isEdit ? $product->description->html() : ''; ?></textarea><br><br>

    <label for="price">Prix:</label><br>
    <input type="number" step="0.01" id="price" name="price" value="<?= $isEdit ? $product->price->html() : ''; ?>" required><br><br>

    <label for="status">Statut:</label><br>
    <select id="status" name="status" required>
        <option value="available" <?= $isEdit && $product->status->value == 'available' ? 'selected' : ''; ?>>Disponible</option>
        <option value="unavailable" <?= $isEdit && $product->status->value == 'unavailable' ? 'selected' : ''; ?>>Indisponible</option>
    </select><br><br>

    <label for="image_path">Image:</label><br>
    <?php if ($isEdit && !empty($product->image_path->value)): ?>
        <img src="../../public/images/<?= $product->image_path->html(); ?>" alt="<?= $product->name->html(); ?>"><br>
    <?php endif; ?>
    <input type="file" id="image_path" name="image_path" <?= $isEdit ? '' : 'required'; ?>><br><br>

    <input type="submit" value="<?= $isEdit ? 'Mettre à jour' : 'Ajouter'; ?>">
</form>