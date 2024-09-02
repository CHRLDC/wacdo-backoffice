<?php

/**
 * 
 * Contrôleur: Vérifier l'existance du mail (nettoyé) dans la BDD
 *             Créer un token de sécurité
 *             Créer et envoyer un mail
 * 
 * @param string $mail - L'adresse e-mail de l'utilisateur
 * 
 */


// Initialisation des variables globales
include_once "utils/init.php";

// Récupération de l'adresse e-mail saisie par l'utilisateur
$mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

// Vérifier la valididé de l'adresse e-mail
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    exit("Adresse e-mail invalide.");
}

// Confirmer l'existance de cette adresse email dans la BDD
$user = new User();
$id = $user->checkByEmail($mail);

// Si l'adresse e-mail n'existe pas, arrêter le script
if ($id == false) {
    exit;
}

// Créer et mettre à jour la clé 
$account = new Account_manage($id);
$token_password = $account->generateRandomKey();
$account->updateAccount($token_password);
// Créer le lien templates/pages/form_password_perdu
$lien = "http://exam-back.cdacosta.mywebecom.ovh/display_form_new_password.php?key=" . $token_password;

// Envoyer le mail de création d'un nouveau mot de passe:
// Destinataire //cdacosta@mywebecom.ovh pour test
$to = '"Charles Webecom"<cdacosta@mywebecom.ovh>';

// Objet du mail
$subject = "Nouveau mot de passe";

// Contenu du mail
ob_start();
include_once "templates/mails/mail_password.php";
$message = ob_get_clean();

// Head du mail
$head = [];
$head["From"] =  '"Charles Webecom"<cdacosta@mywebecom.ovh>';
$head["Reply-to"] = "cdacosta@mywebecom.ovh";
$head["MIME-version"] = "1.0";
$head["Content-Type"] = "text/html; charset=utf-8";

// Envoi du mail
if (mail($to, $subject, $message, $head)) {
    // Générer du code JavaScript dans la sortie HTML
    echo "<script>
            alert('Si votre compte existe, un mail a été envoyé à cette adresse " . htmlspecialchars($email_saisie) . "');
            window.location.href = 'display_form_login.php';
          </script>";
    exit;
} else {
    echo "Échec de l'envoi du message.";
}
