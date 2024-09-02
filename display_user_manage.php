<?php

/**
 * display_user_manage.php
 * Contrôleur : Affiche les détails d'un utilisateur s'il y a un ID dans l'URL
 *              Affiche un formulaire vide pour saisir un nouvel utilisateur si pas d'id dans l'URL
 *             $_GET['idUser'] - l'id du produit à afficher (facultatif)
 *             $_GET['mode'] - le mode (facultatif)
 */

// Initialisation des variables globales
include_once "utils/init.php";

// Vérification de la connexction
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}
// Vérification des rôles
hasRole('admin');

// Récupérer l'ID de l'utilisateur depuis l'URL, s'il est présent
$idUser = isset($_GET['id']) ? $_GET['id'] : null;
$mode = isset($_GET['mode']) ? $_GET['mode'] : null;

if ($idUser) {
    // Charger les informations de l'utilisateur si un ID est présent
    $user = new User($idUser);

    if ($user) {
        $isEdit = ($mode === 'edit');
    } else {
        // Si l'utilisateur n'existe pas, rediriger
        header("Location: display_list_users.php");
        exit;
    }
} else {
    // Si pas d'ID, on est en mode création
    $isEdit = false;
    $user = new User();
}

// Récupérer les rôles disponibles en BDD
$roles = $user->getRoles();

// Inclure la page complète pour afficher ou éditer l'utilisateur
include "templates/pages/user_manage.php";
