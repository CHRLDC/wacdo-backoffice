<?php

/** database.php
 * Gestion de la connexion à la base de données:
 *      -Ouvre la base de données
 *      -Gestion des messages d'erreurs
 */

// Gestion des messages d'erreurs
ini_set('display_errors', 1); // Affiche les erreurs
error_reporting(E_ALL);  // Toutes les erreurs sont affichées

// Ouvrir la base de données dans la variable globale $bdd
global $bdd;
// Essayer de se connecter à la base de données
try {
    $bdd = new PDO("mysql:host=localhost;dbname=projets_exam-back_cdacosta;charset=utf8", "login", "password"); //(sécurité dépot public) login et mot de passe sur MyWebecom
    // Debogue
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (Throwable $exception) {
    // Si une exception est déclenchée
    echo "Une erreur a été rencontrée avec la base de données:";
    print_r($exception);
}
