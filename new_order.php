<?php

/**
 * new_order.php
 * Controler : Ajouter une nouvelle commande en base de données
 *  A besoin de :
 *      $_SESSION['cart'] - informations de la commande
 */

// Initialisation
include_once "utils/init.php";

// Vérification de la connexction
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification des rôles
hasRole('reception', 'admin');

// Récupérer le panier existant dans la session
$cart = $_SESSION['cart'] ?? [];

// Nettoyer les données

// Générer le numéro de commande
$order = new Order();
$orderNumber = $order->generateNumberOrder();

// Compléter les informations de la commande
$orderDetails = [
    'orderNumber' => $orderNumber,
    'orderPlace' => (int)$_POST['placeNumber'] ?? $cart['orderPlace'],
    'orderType' => $_POST['OrderType'] ?? $cart['orderType']
];

// Fusionner les nouvelles informations avec celles déjà dans la session
$_SESSION['cart'] = array_merge($cart, $orderDetails);

// Ajouter la commande en BDD
$order->insertFullOrder($_SESSION['cart']);

//Vider la session panier
unset($_SESSION['cart']);

//Afficher la liste des commandes
header("Location: index.php");
