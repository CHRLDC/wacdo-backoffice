<?php

/**
 * 
 * Template de page complète: Affiche le formulaire de nouveau mot de passe
 * 
 * @param string $GET['key'] - Key du token
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
    <title>Votre nouveau mot de passe</title>
</head>

<body>
    <div class="container absolute-container">
        <h1>Nouveau mot de passe</h1>
        <!-- Formulaire de confirmation d'adresse mail et mots de passe -->
        <form action="update_password.php?key=<?= $_GET['key'] ?>" method="post">
            <div class="form-group">
                <label for="email">Saisir votre e-mail :</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password1">Nouveau mot de passe :</label>
                <input type="password" name="password1" id="password1" required>
            </div>
            <div class="form-group">
                <label for="password2">Confirmation de mot de passe :</label>
                <input type="password" name="password2" id="password2" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Valider">
            </div>
        </form>
    </div>
</body>

</html>