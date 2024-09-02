<?php

/**
 * display_list_users.php
 * Controleur : Générer la liste des utilisateurs
 */

// Initialisation
include_once "utils/init.php";

// Récupération de $utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification des rôles
hasRole('admin');

// Créer une instance du modèle User
$user = new User();

// Récupérer tous les utilisateurs
$users_list = $user->listAll();

// Si la liste des utilisateurs est vide, rediriger vers la page d'accueil
if (empty($users_list)) {
    header("Location: index.php");
    exit;
}

// Afficher la liste des utilisateurs
include_once "templates/pages/list_users.php";
