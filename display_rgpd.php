<?php

/**
 * display_rgpd.php
 * Controler: Générer les informations de l'utilisateur (RGPD)
 */

// Initialisation
include_once "utils/init.php";

// Récupération de l'utilisateur connecté
if (sessionIsconnected()) {
    $userConnected = sessionUserconnected();
} else {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Générer les données de l'utilisateur connecté
$user = new User($userConnected->id);

// Afficher les informations de l'utilisateur connecté
include_once "templates/pages/rgpd.php";
