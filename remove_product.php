<?php

/*
 * remove_product.php
 * Controleur : Supprimer un produit de la BDD
 * Paramètre : $_GET['id'] - l'id du produit à supprimer
 */

// Initialisation des variables globales
include_once "utils/init.php";

// Vérification utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification rôle utilisateur
hasRole('admin');

// Récupération de l'ID du produit à supprimer (forcer int)
$product_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($product_id) {
    // Charger le produit depuis la base de données
    $product = new Product();
    if ($product->load($product_id)) {
        // Supprimer l'image associée
        if (!empty($product->image_path->value)) {
            $imagePath = 'public/images' . $product->image_path->value;
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Supprimer le fichier image
            }
        }
        // Supprimer le produit de la base de données
        if ($product->delete()) {
            header("Location: display_list_product.php");
            exit;
        } else {
            echo "Erreur lors de la suppression du produit.";
        }
    }
}
