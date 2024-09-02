<?php

/**
 * check_new_order.php
 * Template de page complète : Affiche la page de confirmation de la commande
 *  Paramètres:
 *      $cart - le panier
 */
// Autorisation d'afficher la page
if (!defined('ALLOWED')) {
    header("Location: unauthorized.php");
    exit;
}
// Utilisation du namespace
use Utils\Cart;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Confirmation de la commande</title>
</head>
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200 column gap16">
        <h1>Récapitulatif de la commande</h1>

        <h2>Détails de la commande</h2>

        <h2>Articles</h2>
        <?php if (!empty($cart['items'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Sauce</th>
                        <th>Taille</th>
                        <th>Prix Unitaire</th>
                        <th>Prix Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart['items'] as $index => $item): ?>
                        <tr>
                            <td><?= Cart::getNameProductForCart(htmlspecialchars($item['idOther'] ?? $item['idDrink'])); ?></td>
                            <td><?= htmlspecialchars($item['quantity']); ?></td>
                            <td><?= isset($item['sauceId']) ? htmlspecialchars(is_array($item['sauceId']) ? implode(", ", array_map('getNameProductForCart', $item['sauceId'])) : Cart::getNameProductForCart($item['sauceId'])) : 'N/A'; ?></td>
                            <td>
                                <?= isset($item['size']) ? htmlspecialchars(is_array($item['size']) ? implode(", ", $item['size']) : $item['size']) : 'N/A'; ?>
                            </td>
                            <td><?= number_format($item['price'], 2); ?> €</td>
                            <td><?= number_format($item['price'] * $item['quantity'], 2); ?> €</td>
                            <td><a href="remove_from_cart.php?type=item&index=<?= $index; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a></td>
                        </tr>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun article ajouté.</p>
        <?php endif; ?>

        <h2>Menus</h2>
        <?php if (!empty($cart['menu'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Taille</th>
                        <th>Boisson</th>
                        <th>Accompagnement</th>
                        <th>Sauce</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Prix Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart['menu'] as $index => $menu): ?>
                        <tr>
                            <td><?= Cart::getNameProductForCart($menu['idMenu']); ?></td>
                            <td><?= htmlspecialchars(implode(", ", $menu['size'])); ?></td>
                            <td><?= Cart::getNameProductForCart(reset($menu['drinkId'])); ?></td>
                            <td><?= Cart::getNameProductForCart(reset($menu['accompanimentId'])); ?></td>
                            <td><?= Cart::getNameProductForCart(reset($menu['sauceId'])); ?></td>
                            <td><?= htmlspecialchars($menu['quantity']); ?></td>
                            <td><?= number_format($menu['price'], 2); ?> €</td>
                            <td><?= number_format($menu['price'] * $menu['quantity'], 2); ?> €</td>
                            <td><a href="remove_from_cart.php?type=menu&index=<?= $index; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce menu ?');">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucun menu ajouté.</p>
        <?php endif; ?>


        <?php if (!empty($_SESSION['cart']['total'])): ?>
            <div class="flex gap8">
                <h2>Total de la commande:</h2>
                <p class="bigfont"><strong></strong> <?= number_format($_SESSION['cart']['total'], 2); ?> €</p><br>
            </div>
        <?php endif; ?>

        <form action="new_order.php" method="post">
            <div class="flex gap16 mB16">
                <label for="OrderType">Type de commande:</label>
                <select name="OrderType" id="" required>
                    <option value="">Choisir</option>
                    <option value="Sur place">Sur place</option>
                    <option value="À emporter">À emporter</option>
                </select>
                <label for="placeNumber">Numero de chevalet</label>
                <input type="number" name="placeNumber"><br><br>
            </div>
            <div class="flex gap16">
                <a href="display_form_new_order.php" class="button">Ajouter un autre produit</a>
                <a href="remove_cart.php" onclick="return confirm('Êtes-vous sûr de vouloir vider le panier ?');" class="button">Vider le panier</a>
                <input type="submit" value="Confirmer la commande">
            </div>
        </form><br>


    </div>
</body>

</html>