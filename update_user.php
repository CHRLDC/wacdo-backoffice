<?php

/**
 * update_user.php
 * Controleur: Mettre à jour les informations d'un utilisateur dans la BDD
 *  Paramètres :
 *      $_POST['user_id'] - l'id de l'utilisateur à mettre à jour
 *      Les données saisies dans le formulaire
 */

// Initialisation
include_once "utils/init.php";

// Vérification utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification rôle utilisateur
hasRole('admin');

// Vérification des données POST (input hidden dans le formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    // Sanitation et validation de l'ID utilisateur
    $user_id = intval($_POST['user_id']);
    if ($user_id <= 0) {
        // Rediriger si l'ID est invalide
        header("Location: display_list_users.php");
        exit;
    }

    $user = new User();
    if ($user->load($user_id)) {
        // Sanitation et validation des données du formulaire
        $name = trim($_POST['name']);
        $first_name = trim($_POST['first_name']);
        $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
        $role = trim($_POST['role']);

        // Vérification des erreurs de validation
        if (!$mail) {
            die("Email invalide");
        }

        // Mettre à jour les informations de l'utilisateur avec protection contre XSS
        $user->set('name', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
        $user->set('first_name', htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'));
        $user->set('mail', $mail);
        $user->set('role', $role);

        // Sauvegarder les modifications
        $user->update();

        // Rediriger vers la page de détails de l'utilisateur après la mise à jour
        header("Location: display_user_manage.php?id=$user_id&mode=view");
        exit;
    } else {
        // Rediriger si l'utilisateur n'existe pas
        header("Location: display_list_users.php");
        exit;
    }
} else {
    // Rediriger si les données POST sont manquantes
    header("Location: display_list_users.php");
    exit;
}
