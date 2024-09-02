<?php

/*
 * new_product.php
 * Controleur: Créer un nouveau produit dans la BDD
 * Paramètres:
 *      Les données du formulaire
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

// Récupérer et valider la catégorie depuis le formulaire
$categoryId = isset($_POST['category']) ? intval($_POST['category']) : null;
if (!$categoryId) {
    echo "Erreur : Catégorie invalide.";
    exit;
}

// Création d'un nouvel objet Product
$product = new Product();

// Nettoyer et validation des champs du produit
$name = trim($_POST['name']);
$description = trim($_POST['description']);
$price = floatval($_POST['price']);
$status = trim($_POST['status']);

// Vérification de la validité des champs
if (empty($name) || empty($description) || $price <= 0 || empty($status)) {
    echo "Erreur : Tous les champs sont obligatoires et doivent être valides.";
    exit;
}

// Remplir les champs du produit avec les données du formulaire
$product->name->value = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$product->description->value = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
$product->price->value = $price;
$product->status->value = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');
$product->Category->value = $categoryId;

// Charger la catégorie pour utiliser le titre lors de la génération du chemin de l'image
$category = new Category();
if (!$category->load($categoryId)) {
    echo "Erreur : La catégorie sélectionnée est invalide.";
    exit;
}

// Gérer l'upload de l'image
if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
    // Construire le répertoire de destination basé sur la catégorie
    $uploadDir = 'public/images/' . strtolower(str_replace(' ', '_', htmlspecialchars($category->title->value, ENT_QUOTES, 'UTF-8'))) . '/';

    // Vérifier que le répertoire existe, sinon le créer
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            echo "Erreur : Impossible de créer le répertoire de destination.";
            exit;
        }
    }

    // Construire le nom du fichier basé sur le nom du produit
    $filename = strtolower(str_replace(' ', '_', htmlspecialchars($product->name->value, ENT_QUOTES, 'UTF-8'))) . '.png';
    $uploadFile = $uploadDir . $filename;

    // Déplacer le fichier téléchargé vers le répertoire
    if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadFile)) {
        // Mettre à jour le chemin de l'image dans le produit
        $product->image_path->value = '/' . strtolower(str_replace(' ', '_', htmlspecialchars($category->title->value, ENT_QUOTES, 'UTF-8'))) . '/' . $filename;
    } else {
        echo "Erreur lors de l'upload de l'image.";
        exit;
    }
}

// Enregistrer le nouveau produit dans la base de données
if ($product->insert()) {
    header("Location: display_list_product.php");
    exit;
} else {
    echo "Erreur lors de la création du produit.";
}
