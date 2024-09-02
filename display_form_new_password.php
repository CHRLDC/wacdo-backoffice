<?php

/**
 * display_form_new_password.php
 * Contrôleur: Contrôler la présence et la validité du token dans l'URL
 *             Afficher le formulaire de changement de mot de passe
 */

// Initialisation des variables globales
include_once "utils/init.php";

// Contrôler l'existence de la clé dans le lien
if (!isset($_GET["key"])) {
    exit("Le lien est invalide");
}
$key = $_GET["key"];

// Contrôler la taille de la clé (32 caractères)
if (strlen($key) !== 32) {
    exit("Le lien est invalide : clé incorrecte");
}

// Vérifier que la clé existe dans la base de données
$account = new Account_manage();
if (!$account->checkKeyTokenMail($key)) {
    exit("Le lien est invalide ou a expiré");
}

// Si la clé est valide, afficher le formulaire de changement de mot de passe
include "templates/pages/form_update_password.php";
