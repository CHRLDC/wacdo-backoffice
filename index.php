<?php

/**
 * index.php
 * Controleur : Générer la liste (triée en fonction du rôle User) des commandes si l'utilisateur est connecté sinon rediriger
 **/

// Initialisation
require_once "utils/init.php";

// Récupération de l'utilisateur connecté
if (sessionIsconnected()) {
    $user = sessionUserconnected();
} else {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Générer la liste des commandes triées par date de livraison croissante avec statut en attente
$order = new Order();
$orders_list = $order->listStandByOrdersByDeliveryDate();
$test = $order->listAll();

// Affichage de la page de la liste des commandes
include_once "templates/pages/list_orders.php";
