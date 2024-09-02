<?php

/**
 * new_user.php
 * Controleur : Creer un nouvel utilisateur
 *  Paramètre :
 *      Les données saisies du formulaire
 */

include_once "utils/init.php";

// Vérification utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}
// Vérification rôle utilisateur
hasRole('admin');

// Vérification des données POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();

    // Nettoyage et validation des données
    $name = trim($_POST['name']);
    $first_name = trim($_POST['first_name']);
    $mail = filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL);
    $role = trim($_POST['role']);

    // Vérification des erreurs de validation
    if (!$mail) {
        die("Email invalide");
    }

    // Définir les informations de l'utilisateur en protégeant contre XSS
    $user->set('name', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
    $user->set('first_name', htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'));
    $user->set('mail', $mail);
    $user->set('role', $role);

    // Insérer l'utilisateur dans la base de données
    $user->insert();

    // Créer l'account_manage associé
    $account = new Account_manage();
    $account->set('User', $user->getId());
    $account->set('date_creation', date('Y-m-d H:i:s'));
    $account->insert();

    // Rediriger vers la liste des utilisateurs après la création
    header("Location: display_list_users.php");
    exit;
} else {
    // Rediriger si les données POST sont manquantes
    header("Location: display_list_users.php");
    exit;
}
