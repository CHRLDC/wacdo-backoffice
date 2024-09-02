<?php

/**
 * add_to_cart.php
 * Controleur: Ajouter l'item et créer ses détails dans SESSION['cart']
 *  Parametre: 
 *      $_POST['form_type'] - Provenance du formulaire (hidden dans le formulaire)
 *      Les données du formulaire
 */

// Utilisation du namespace
use Utils\Cart;

// Initialisation
require_once 'utils/init.php';

// Vérification de la connexction
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification des rôles
hasRole('reception', 'admin');

// Vérifiez si le panier existe dans la session, sinon initialisez-le
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        'orderNumber' => 0,
        'orderPlace' => 0,
        'orderType' => 0,
        'items' => [],
        'menu' => [],
        'total' => 0.00
    ];
}

// Vérifiez si le formulaire soumis est identifié
$form_type = $_POST['form_type'] ?? null;

// Récupérer les id_product (par la quantité selectionné)
$id_product = Cart::getProductByQuantity($_POST);

if ($form_type === 'products_form') {

    $item = [
        'idOther' => $id_product,
        'quantity' => (int)$_POST['quantity'][$id_product],
        'sauceId' => $_POST['sauce-accompaniment'] ?? null,
        'price' => (float)Cart::getPriceForCart($id_product, null)
    ];

    // Filtrer les sous-éléments non vides
    $item = Cart::array_filter_recursive($item);

    // Vérifier si l'article existe déjà dans le panier
    $found = false;
    foreach ($_SESSION['cart']['items'] as &$existingItem) {
        if ($existingItem['idOther'] === $item['idOther'] && $existingItem['sauceId'] === $item['sauceId']) {
            $existingItem['quantity'] += $item['quantity'];
            $found = true;
            break;
        }
    }

    // Si l'article n'existe pas, l'ajouter au panier
    if (!$found) {
        $_SESSION['cart']['items'][] = $item;
    }
} elseif ($form_type === 'menus_form') {

    $menu = [
        'idMenu' => $id_product,
        'size' => $_POST['size-menu'] ?? 'normal',
        'quantity' => (int)$_POST['quantity'][$id_product],
        'sauceId' => $_POST['sauce-menu'],
        'drinkId' => $_POST['drink-menu'],
        'accompanimentId' => $_POST['accompaniment-menu'],
        'price' => (float)cart::getPriceForCart($id_product, $_POST['size-menu'])
    ];

    // Filtrer les sous-éléments non vides
    $menu = Cart::array_filter_recursive($menu);

    // Vérifier si le menu existe déjà dans le panier
    $found = false;
    foreach ($_SESSION['cart']['menu'] as &$existingMenu) {
        if ($existingMenu['idMenu'] === $menu['idMenu'] && $existingMenu['size'] === $menu['size'] && $existingMenu['sauceId'] === $menu['sauceId'] && $existingMenu['drinkId'] === $menu['drinkId'] && $existingMenu['accompanimentId'] === $menu['accompanimentId']) {
            $existingMenu['quantity'] += $menu['quantity'];
            $found = true;
            break;
        }
    }

    // Si le menu n'existe pas, l'ajouter au panier
    if (!$found) {
        $_SESSION['cart']['menu'][] = $menu;
    }
} elseif ($form_type === 'drinks_form') {
    $item = [
        'idDrink' => $id_product,
        'size' => $_POST['size-drink'] ?? '30cl',
        'quantity' => (int)$_POST['quantity'][$id_product],
        'price' => (float)Cart::getPriceForCart($id_product, $_POST['size-drink'])
    ];

    // Filtrer les sous-éléments non vides
    $item = Cart::array_filter_recursive($item);

    // Vérifier si la boisson existe déjà dans le panier
    $found = false;
    foreach ($_SESSION['cart']['items'] as &$existingItem) {
        if ($existingItem['idDrink'] === $item['idDrink'] && $existingItem['size'] === $item['size']) {
            $existingItem['quantity'] += $item['quantity'];
            $found = true;
            break;
        }
    }

    // Si la boisson n'existe pas, l'ajouter au panier
    if (!$found) {
        $_SESSION['cart']['items'][] = $item;
    }
}

// Mettre à jour le montant total de la commande
$total = 0.00;
foreach ($_SESSION['cart']['items'] as $item) {
    $total += $item['quantity'] * $item['price'];
}
foreach ($_SESSION['cart']['menu'] as $menu) {
    $total += $menu['quantity'] * $menu['price'];
}
$_SESSION['cart']['total'] = $total;

// Redirection vers le formulaire pour continuer à ajouter des éléments
header('Location: display_form_new_order.php');
exit;
