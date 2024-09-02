<?php

/**
 * details_user_fragment.php
 * Fragment pour afficher les détails de l'utilisateur
 *  Paramètres: $user Utilisateur à afficher
 */
?>

<div class="column gap16 mB16">
    <div class="flex gap8">
        <h4><strong>Nom:</strong></h4>
        <p><?= $user->name->html(); ?></p><br>
    </div>

    <div class="flex gap8">
        <h4><strong>Prénom:</strong></h4>
        <p><?= $user->first_name->html(); ?></p><br>
    </div>

    <div class="flex gap8">
        <h4><strong>Email:</strong></h4>
        <p><?= $user->mail->html(); ?></p><br>
    </div>

    <div class="flex gap8">
        <h4><strong>Rôle:</strong></h4>
        <p><?= translate($user->role->html()); ?></p><br>
    </div>
</div>