<?php

/**
 * remove_cart.php
 * Controleur : Vider la SESSION['cart'] et rediriger
 * 
 */

// Initialisation
require_once 'utils/init.php';

// Vérification utilisateur connecté
if (!sessionIsconnected()) {
    sessionDeconnect();
    header("Location: display_form_login.php");
    exit;
}

// Vérification rôle utilisateur
hasRole('reception', 'admin');

// Vider la SESSION['cart']
unset($_SESSION['cart']);

// Rediriger vers l'accueil
header('Location: display_form_new_order.php');
exit;
