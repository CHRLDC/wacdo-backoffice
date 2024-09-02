<?php

/**
 * remove_to_cart.php
 * Controleur: Supprimer un items dans la SESSION['cart']
 *  Parametre: 
 *      SESSION['items'] - item à supprimer
 *      SESSION['menus'] - menus à supprimer
 */

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

// Vérifier le type d'élément à supprimer
$type = $_GET['type'] ?? null;
$index = $_GET['index'] ?? null;

if ($type && is_numeric($index)) {
    // Accéder au panier existant dans la session
    $cart = $_SESSION['cart'] ?? [];

    // Supprimer l'élément en fonction du type
    if ($type === 'item' && isset($cart['items'][$index])) {
        unset($cart['items'][$index]);
        // Réindexer le tableau pour éviter des indices vides
        $cart['items'] = array_values($cart['items']);
    } elseif ($type === 'menu' && isset($cart['menu'][$index])) {
        unset($cart['menu'][$index]);
        // Réindexer le tableau pour éviter des indices vides
        $cart['menu'] = array_values($cart['menu']);
    }

    // Recalculer le total
    $cart['total'] = 0;
    foreach ($cart['items'] as $item) {
        $cart['total'] += $item['price'] * $item['quantity'];
    }
    foreach ($cart['menu'] as $menu) {
        $cart['total'] += $menu['price'] * $menu['quantity'];
    }

    // Mettre à jour le panier dans la session
    $_SESSION['cart'] = $cart;
}

// Rediriger vers la page de récapitulatif de la commande
header('Location: display_check_new_order.php');
exit;
