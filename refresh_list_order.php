<?php

/**
 * refresh_list_order.php
 * Controleur : Générer la liste des commandes triées en fonction du rôle utilisateur
 * Relation AJAX: refresh_list_order.js
 */

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

// Récupérer les paramètres de tri depuis la requête
$sortBy = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'delivered_date';
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

// Sécuriser les paramètres de tri
$validSortColumns = ['delivered_date', 'created_date', 'amount'];
if (!in_array($sortBy, $validSortColumns)) {
    $sortBy = 'delivered_date';
}
$sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

// Générer la liste des commandes triées selon les paramètres
$order = new Order();
$orders_list = $order->listOrdersByCustomSort($sortBy, $sortOrder);

// Afficher le fragment de la liste des commandes
include_once "templates/fragments/list_orders_fragment.php";
