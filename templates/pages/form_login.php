<?php

/**
 * form_login.php
 * Template de page complète: Affiche le formulaire de connexion
 * 
 */

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portail Wacdo - Logiciel entreprise">
    <!-- Lien CSS -->
    <link rel="stylesheet" href="public/css/style.css">
    <title>Connectez-vous</title>
</head>

<body>
    <div class="container absolute-container">
        <h1>Connectez-vous</h1>
        <!-- Formulaire de connexion -->
        <form method="post" id="form-login">
            <div class="form-group">
                <label for="email">Adresse email :</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required>
                <p class="display-none error-message" id="error-connexion">Votre e-mail ou mot de passe n'est pas correct</p>
                <a href="display_form_mail_password_forgotten.php" class="forgot-password">Première connexion ?</a>
                <a href="display_form_mail_password_forgotten.php" class="forgot-password">Mot de passe oublié ?</a>
            </div>
            <div class="form-group flex justify-center">
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>

    <!-- Lien Java Script -->
    <script src="public/js/login.js" defer></script>
</body>

</html>