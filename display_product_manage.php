<?php

/*
* display_product_manage.php
* Contrôleur : Générer les détails d'un utilisateurs ou le formulaire avec ou sans les données d'un utilisateur (Lecture, Modification, Création)
* Paramètre : $_GET['id'] - l'id du produit à afficher (facultatif)
*             $_GET['mode'] - le mode (facultatif)
*/

// Initialisation des variables globales
include_once "utils/init.php";

// Vérifier si l'utilisateur est connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}
// Vérification du rôle utilisateur: autoriser que les administrateurs
hasRole('admin');

// Récupérer l'id du produit depuis l'URL, s'il est présent
$idProduct = isset($_GET['id']) ? $_GET['id'] : null;
$mode = isset($_GET['mode']) ? $_GET['mode'] : null;

// Récupérer la liste des catégories
$category = new Category();
$categories = $category->listAll();


if ($idProduct) {
    // Si un id est présent, on essaie de charger le produit
    $product = new Product($idProduct);

    // Vérifier si le produit a été chargé correctement
    if ($product) {
        $isEdit = ($mode === 'edit');
    } else {
        header("Location: display_list_product.php");
        exit;
    }
} else {
    // Si pas d'id, on est en mode création
    $isEdit = false;
    $product = new Product();
}
// Déterminer l'action du formulaire
$actionUrl = $isEdit ? 'update_product.php' : 'new_product.php';

// Afficher la page product_manage.php
include_once "templates/pages/product_manage.php";
