<?php

/**
 * display_list_product.php
 * Controleur : Générer la liste des produits et catégories
 *              Si utilisateur est admin
 *
 **/

// Initialisation
require_once "utils/init.php";

// Vérifier si l'utilisateur est connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification des rôles, autoriser que les admins à accéder à la page
hasRole('admin');

// Générer la liste des produits
$product = new Product();
$product_list = $product->listAll();

// Générer la liste des catégories
$categorie = new Category();
$category_list = $categorie->listAll();

// SI la liste est vide
if (empty($product_list)) {
    echo "Aucun produit n'a été trouvé";
    exit;
}

// Affichage de la liste des produits par catégories
include_once "templates/pages/list_products.php";
