<?php

/**
 * update_status_order.php
 * Controleur: Mettre à jour le statut d'une commande dans la BDD (en fonction du rôle de l'utilisateur connecté)
 * Paramètres:
 *      GET['order_id'] - l'id de la commande à mettre à jour
 *      GET['status'] - le nouveau statut
 * 
 */

// Inclure les fichiers nécessaires
require_once 'utils/init.php';

// Vérification utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Récupérer l'utilisateur connecté
$userConnected = sessionUserconnected(); // Récupérer l'objet utilisateur connecté

// Récupérer les paramètres de l'URL
$order_id = $_GET['order_id'] ?? null;
$new_status = $_GET['status'] ?? null;

// Liste des statuts valides
$valid_statuses = ['standby', 'delivered', 'prepared', 'canceled', 'inProgress'];

// Vérification du rôle de l'utilisateur connecté et des statuts qu'il peut appliquer
$rolePermissions = [
    'reception' => ['canceled', 'delivered'],
    'preparer' => ['standby', 'inProgress', 'prepared'],
    'admin' => ['standby', 'delivered', 'prepared', 'canceled', 'inProgress']
];

// Vérifier que l'order_id et le statut existent
if ($order_id && in_array($new_status, $valid_statuses)) {

    // Instancier et charger l'objet Order
    $order = new Order($order_id);

    // Vérifier si l'utilisateur connecté a le droit de changer le statut à ce nouvel état
    $userRole = $userConnected->role->html(); // Obtenir le rôle de l'utilisateur connecté
    if (isset($rolePermissions[$userRole]) && in_array($new_status, $rolePermissions[$userRole])) {
        // Si le statut est "livré", ajouter la date de livraison
        if ($new_status == 'delivered') {
            $order->delivered_date = date('Y-m-d H:i:s');
        }

        // Mettre à jour le statut
        $order->status = $new_status;

        // Sauvegarder les changements dans la base de données
        $order->update();

        // Rediriger vers la page de détails de la commande après la mise à jour
        header("Location: display_details_order.php?order_id=" . $order_id);
        exit();
    } else {
        // Rediriger avec un message d'erreur si l'utilisateur n'a pas les droits
        header("Location: display_details_order.php");
        exit();
    }
}
