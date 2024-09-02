<?php

/**
 * Template de page complète: Liste des utilisateurs
 * @param array $list_users Tableau des objets User
 */
if (!defined('ALLOWED')) {
    header("Location: unauthorized.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Liste des Utilisateurs</title>
</head>
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Gestion des Utilisateurs</h1>
        <div>
            <!-- Bouton pour ajouter un nouvel utilisateur -->
            <a href="display_user_manage.php"><input type="button" value="Ajouter un nouvel utilisateur"></a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users_list as $user): ?>
                    <tr>
                        <td><?= $user->getId(); ?></td>
                        <td><?= $user->name->html(); ?></td>
                        <td><?= $user->first_name->html(); ?></td>
                        <td><?= $user->mail->html(); ?></td>
                        <td><?= translate($user->role->value); ?></td>
                        <td><a href="display_user_manage.php?id=<?= $user->getId(); ?>">Modifier</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>