<?php

/*
* user_manage.php
* Template de page complète : Affiche le formulaire pour modifier ou ajouter un produit ou les détails d'un utilisateur* 
* Paramètres :
*    $user : objet utilisateur chargé
*    $actionUrl: action du formulaire
*    $isEdit: mode édition (true) ou mode création (false).
*    $roles : tableau des rôles disponibles
*
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title><?= $isEdit ? 'Modifier utilisateur' : 'Ajouter un utilisateur'; ?></title>
</head>
<?php include_once 'display_header_nav.php' ?>

<body class="mHeader">
    <div class="container-1200">
        <h1>Gérer les utilisateurs</h1>
        <nav class="mB16">
            <a href="display_list_users.php"><input type="button" value="Retour à la liste des utilisateurs"></a>
        </nav>

        <?php if ($idUser && !$isEdit): ?>
            <!-- Affichage des détails de l'utilisateur -->
            <?php include_once "templates/fragments/details_user_fragment.php"; ?>
            <a href="display_user_manage.php?id=<?= $user->getId(); ?>&mode=edit"><input type="button" value="Modifier"></a>
            <a href="remove_user.php?id=<?= $user->getId(); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"><input type="button" value="Supprimer"></a>
        <?php else: ?>
            <!-- Affichage du formulaire de création/modification -->
            <?php include_once "templates/fragments/form_user_fragment.php"; ?>
        <?php endif; ?>
    </div>
</body>

</html>