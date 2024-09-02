<?php

/**
 * test_display_form_new_order.php
 * Controleur : Générer la liste des catégories (relais JS)
 * to: formulaire de saisie de nouvelle commande
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

// Charger les catégories
$category = new Category();
$categories = $category->listAll();

// Si la liste est vide, rediriger
if (empty($categories)) {
    header("Location: index.php");
    exit;
}

// Afficher le formulaire de test
include_once "templates/pages/form_new_order.php";
