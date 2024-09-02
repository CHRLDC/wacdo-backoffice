<?php

/*
 * update_product.php
 * Controleur: Mettre à jour un produit en BDD
 * Paramètre : $_POST['product_id'] - l'id du produit à mettre à jour
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

// Récupération de l'ID du produit à mettre à jour (input hidden dans le formulaire)
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;

if ($product_id) {
    // Charger le produit depuis la base de données
    $product = new Product();
    if ($product->load($product_id)) {
        // Charger la catégorie associée au produit
        $categoryId = $product->Category->target->getId();

        // Sanitation et validation des champs du formulaire
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $status = trim($_POST['status']);

        // Vérification de la validité des champs
        if (empty($name) || empty($description) || $price <= 0 || empty($status)) {
            echo "Erreur : Tous les champs sont obligatoires et doivent être valides.";
            exit;
        }

        // Mettre à jour les champs du produit avec les données du formulaire
        $product->name->value = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $product->description->value = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
        $product->price->value = $price;
        $product->status->value = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

        // Mettre à jour la catégorie si elle est modifiée
        $newCategoryId = isset($_POST['category']) ? intval($_POST['category']) : null;
        if ($newCategoryId && $newCategoryId !== $categoryId) {
            $product->Category->value = $newCategoryId;

            // Recharger la catégorie en cas de changement
            $category = new Category();
            if (!$category->load($newCategoryId)) {
                echo "Erreur : La nouvelle catégorie sélectionnée est invalide.";
                exit;
            }
        } else {
            // Charger la catégorie actuelle si elle n'est pas modifiée
            $category = new Category();
            $category->load($categoryId);
        }

        // Gérer l'upload de l'image
        if (isset($_FILES['image_path']) && $_FILES['image_path']['error'] === UPLOAD_ERR_OK) {
            // Construire le répertoire de destination
            $uploadDir = 'public/images/' . strtolower(str_replace(' ', '_', htmlspecialchars($category->title->value, ENT_QUOTES, 'UTF-8'))) . '/';

            // Vérifier que le répertoire existe, sinon le créer
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    echo "Erreur : Impossible de créer le répertoire de destination.";
                    exit;
                }
            }

            // Construire le nom du fichier
            $filename = strtolower(str_replace(' ', '_', htmlspecialchars($product->name->value, ENT_QUOTES, 'UTF-8'))) . '.png';
            $uploadFile = $uploadDir . $filename;

            // Déplacer le fichier téléchargé vers le répertoire de destination
            if (move_uploaded_file($_FILES['image_path']['tmp_name'], $uploadFile)) {
                // Mettre à jour le chemin de l'image dans l'objet produit avec le chemin relatif
                $product->image_path->value = '/' . strtolower(str_replace(' ', '_', htmlspecialchars($category->title->value, ENT_QUOTES, 'UTF-8'))) . '/' . $filename;
            } else {
                echo "Erreur lors de l'upload de l'image.";
                exit;
            }
        }

        // Enregistrer les modifications dans la base de données
        if ($product->update()) {
            header("Location: display_list_product.php");
            exit;
        } else {
            echo "Erreur lors de la mise à jour du produit.";
            exit;
        }
    } else {
        echo "Erreur : Produit non trouvé.";
        exit;
    }
} else {
    echo "Erreur : ID produit manquant.";
    exit;
}
