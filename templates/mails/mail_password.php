<?php

/**
 * mail_password.php
 * Templates Mail: Structure mail de reinitialisation du mot de passe
 * @param string $lien - Lien vers lequel rediriger l'utilisateur
 */

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="UTF-8">
    <title>Réinitialisation ou création de mot de passe</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #ffffff; border: 1px solid #dddddd;">
        <h2 style="font-size: 18px; font-weight: bold; text-align: center;">Réinitialisation de votre mot de passe</h2>
        <p style="font-size: 14px;">
            Bonjour,
        </p>
        <p style="font-size: 14px;">
            Nous avons reçu une demande de réinitialisation ou de création de votre mot de passe. Si vous n'avez pas demandé cette démarche, vous pouvez ignorer cet e-mail.
        </p>
        <p style="font-size: 14px;">
            Pour réinitialiser ou créer votre mot de passe, veuillez cliquer sur le lien ci-dessous ou copier/coller l'URL dans votre navigateur :
        </p>
        <p style="text-align: center; margin: 20px 0;">
            <a href="<?= htmlspecialchars($lien) ?>" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px;">Réinitialiser mon mot de passe</a>
        </p>
        <p style="font-size: 14px; text-align: center;">
            <a href="<?= htmlspecialchars($lien) ?>" style="color: #007bff;"><?= htmlspecialchars($lien) ?></a>
        </p>
        <p style="font-size: 12px; color: #555555;">
            Ce lien expirera dans 24 heures pour des raisons de sécurité.
        </p>
        <p style="font-size: 12px; color: #555555;">
            Merci de ne pas répondre à cet e-mail. Si vous avez des questions, veuillez contacter notre support.
        </p>
        <p style="font-size: 14px; text-align: center;">
            Cordialement,<br>
            L'équipe de Wacdo
        </p>
    </div>
</body>

</html>