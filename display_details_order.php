<?php

/**
 * display_details_order.php
 * Controleur : Générer les détails d'une commande
 *  Paramètre:
 *      GET['order_id'] - l'id de la commande
 */

// Initialisation
require_once 'utils/init.php';

// Récupérer le paramètre
$order_id = $_GET['order_id'] ?? null;

// Instanciation de l'objet Order
$order = new Order();

// Récupérer tous les détails de la commande
$orderDetails = $order->getFullOrder($order_id);

// Si la commande n'existe pas
if (!$orderDetails) {
    header("Location: index.php");
    exit;
}

// Affichage
include_once 'templates/pages/details_order.php';
