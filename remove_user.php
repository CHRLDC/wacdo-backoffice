<?php

/**
 * remove_user.php
 * Controleur : Supprimer un utilisateur et sont account_manage en base de données
 *  Paramètre : 
 *      $_GET['id'] - l'id de l'utilisateur à supprimer
 */

// Initialisation
include_once "utils/init.php";

// Vérification de la connexion utilisateur
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification rôle utilisateur
hasRole('admin');

// Récupération de l'ID de l'utilisateur à supprimer (forcer int)
$user_id = isset($_GET['id']) ? intval($_GET['id']) : null;


if ($user_id) {
    // Charger le utilisateur depuis la base de données
    $user = new User();
    if ($user->load($user_id)) {
        // Supprimer Account_manage associé en premier
        $account = new Account_manage();
        $account->loadByUserId($user_id);
        $account->delete();
        // Supprimer l'utilisateur de la base de données
        if ($user->delete()) {
            header("Location: display_list_users.php");
            exit;
        } else {
            echo "Erreur lors de la suppression du utilisateur.";
        }
    }
}
