<?php

/**
 * display_form_login.php
 * Contrôleur: Générer le formulaire de connexion si utilisateur non connecté
 * 
 */

// Initialisation des variables globales
include_once "utils/init.php";

// Générer le formulaire de connexion
if (sessionIsconnected()) {
    header("Location: index.php");
    exit;
} else {
    include_once "templates/pages/form_login.php";
}
