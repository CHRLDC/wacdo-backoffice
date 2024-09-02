<?php

/**
 * Controleur : Deconnecter l'utilisateur
 */

// Initialisation des variables globales
include_once "utils/init.php";

// Supprimer le panier
unset($_SESSION['cart']);

// Deconnecter l'utilisateur
sessionDeconnect();

//Redirection
header("Location: index.php");
exit;
