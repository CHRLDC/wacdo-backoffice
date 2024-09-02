<?php

/**
 * 
 * Template de page complète: Formulaire de saisie de l'adresse mail (pour l'envoi de l'email)
 * 
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="description">
    <!-- Lien CSS -->
    <link rel="stylesheet" href="public/css/style.css">
    <title>Votre adresse mail</title>
</head>


<body>
    <div class="container absolute-container">
        <h1>Nouveau mot de passe</h1>
        <!-- Formulaire d'adresse mail -->
        <form action="mail_for_new_password.php" method="post">
            <div class="form-group">
                <label for="email">Votre adresse e-mail :</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Envoyer l'e-mail">
            </div>
        </form>
    </div>
</body>

</html>