<?php

/**
 * receved_order_api.php
 * Controleur: Insérer en base de données une commande reçue en JSON
 * API POST
 */

// Inclure les fichiers nécessaires
require_once 'utils/init.php';

// Vérifier si la requête est une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Erreur : Seules les requêtes POST sont acceptées.");
}

// Vérifier si la key API est valide
$key = $_GET['key'] ?? '';
// à faire...

// Lire le contenu JSON de la requête POST
$json = file_get_contents('php://input');

if ($json === false) {
    exit;
}

// Décoder le JSON en tableau
$orderData = json_decode($json, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    exit;
}

// Instancier la classe Order et insérer les données
$order = new Order();

try {
    // Insérer les données de la commande
    $order->insertFullOrder($orderData);
    echo json_encode(["message" => "Commande insérée avec succès."]);
} catch (Exception $e) {
    // En cas d'erreur, retourner un message d'erreur en JSON
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}
