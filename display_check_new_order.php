<?php

/**
 * display_check_new_order.php
 * Controleur : Générer la page de confirmation de commande
 */

// Initialisation
include_once "utils/init.php";

// Vérification utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification rôle utilisateur
hasRole('reception', 'admin');

// Récupérer la commande dans la SESSION
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
}

//Instancier la classe Produit
$product = new Product();

//Affichage de la page de confirmation de commande
include_once "templates/pages/check_new_order.php";
