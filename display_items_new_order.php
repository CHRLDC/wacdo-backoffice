<?php

/**
 * display_items_new_order.php.php
 * Controleur : Générer les listes de produits correspondantes au fragments à afficher pour la catégorie choisie
 *  Paramètres:
 *      $_GET['category_id'] - l'id de la catégorie à afficher
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

// Récupérer l'id de la catégorie
$categoryId = $_GET['category_id'] ?? null;

if ($categoryId) {
    // Charger la catégorie à partir de l'id
    $category = new Category($categoryId);

    // Charger les produits de la catégorie
    $product = new Product();
    $products = $product->getProductsOfCategory($categoryId);

    // Charger les boissons, accompagnements, et sauces si la catégorie est "menus"
    $drinks = $product->getProductsOfCategory(2);
    $accompaniments = $product->getProductsOfCategory(4);
    $sauces = $product->getProductsOfCategory(9);

    // Charger les boissons, accompagnements, et sauces si la catégorie est "menus" et afficher le fragment correspondant
    if ($category->title->html() === 'menus') {
        include 'templates/fragments/form_menus_new_order_fragment.php';
    } else if ($category->title->html() === 'boissons') {
        include 'templates/fragments/form_drinks_new_order_fragment.php';
    } else {
        include 'templates/fragments/form_products_new_order_fragment.php';
    }
}
