<?php

/**
 * 
 * Contrôleur: Mettre à jour le nouveau mot de passe dans la BDD
 *             Contrôler du token
 *             Contrôler la saisie du nouveau mot de passe
 * 
 * @param string POST['login'] - Le login de l'utilisateur
 * @param string POST['password1'] - Le mot de passe de l'utilisateur
 * @param string POST['password2'] - Le mot de passe de l'utilisateur
 * @param string GET['key'] - Le token de l'utilisateur
 * 
 */


// Initialisation des variables globales
include_once "utils/init.php";

// Récupération du token de l'utilisateur et de l'adresse mail
$mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$key = $_GET["key"];

// Vérifier la valididé du token
$account = new Account_manage();
if (!$account->checkKeyTokenMail($key)) {
    exit("Le lien est invalide ou a expiré");
}

// Vérifier la valididé de l'adresse e-mail
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    exit("Adresse e-mail invalide.");
}

// Vérifier que l'email existe dans la base de données
$user = new User();
$id = $user->checkByEmail($mail);
if ($id == false) {
    // Si false (login ou mot de passe incorrect), donner une erreur (JS affichera l'erreur)
    echo "Le lien est invalide";
    exit;
}
// Contrôler la conformité du nouveau mot de passe
// à faire...

// Contrôler la confirmation du nouveau mot de passe
if ($_POST["password1"] != $_POST["password2"]) {
    // Si false (login ou mot de passe incorrect), donner une erreur (JS affichera l'erreur)
    echo "Les mots de passe ne sont pas identiques";
    exit;
}

// Mettre à jour le nouveau mot de passe
$user->resetPassword($id, $_POST["password1"]);

// Rediriger vers l'index
header("Location: index.php");
exit;
