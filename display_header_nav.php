<?php

/**
 * display_header_nav.php
 * Génèrer les données du header en fonction du rôle de l'utilisateur
 */

// Initialisation
include_once 'utils/init.php';

// Récupération de l'utilisateur connecté
if (sessionIsconnected()) {
    $userConnected = sessionUserconnected();
} else {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Créer les accès aux liens du header
$headerData = [
    'isConnected' => sessionIsconnected(),
    'firstName' => $userConnected ? $userConnected->first_name->html() : '',
    'role' => $userConnected ? $userConnected->role->html() : '',
    'showNewOrder' => sessionIsconnected() && in_array($userConnected->role->html(), ['reception', 'admin']),
    'showUserManagement' => sessionIsconnected() && $userConnected->role->html() === 'admin',
    'showProductManagement' => sessionIsconnected() && $userConnected->role->html() === 'admin',
];

// Affichage du header
include_once 'templates/fragments/header_nav.php';
