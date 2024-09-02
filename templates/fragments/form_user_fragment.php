<?php

/**
 * form_user_fragment.php
 * Fragments: Affiche le formulaire d'ajout/modification d'utilisateur
 *  Paramètres:
 *      $user: objet utilisateur à modifier (facultatif)
 *      $isEdit: mode édition (true) ou mode création (false).
 *      $roles: tableau des rôles disponibles
 */

?>

<form method="POST" action="<?= $isEdit ? 'update_user.php' : 'new_user.php'; ?>">
    <?php if ($isEdit): ?>
        <!-- Champ caché pour l'ID de l'utilisateur (utile pour la modification) -->
        <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">
    <?php endif; ?>

    <label for="name">Nom:</label><br>
    <input type="text" id="name" name="name" value="<?= $isEdit ? $user->name->html() : ''; ?>" required><br><br>

    <label for="first_name">Prénom:</label><br>
    <input type="text" id="first_name" name="first_name" value="<?= $isEdit ? $user->first_name->html() : ''; ?>" required><br><br>

    <label for="mail">Email:</label><br>
    <input type="email" id="mail" name="mail" value="<?= $isEdit ? $user->mail->html() : ''; ?>" required><br><br>

    <label for="role">Rôle:</label><br>
    <select id="role" name="role" required>
        <option value="">Sélectionnez un rôle</option>
        <?php foreach ($roles as $role): ?>
            <option value="<?= htmlspecialchars($role); ?>" <?= $isEdit && $user->role->html() == htmlspecialchars($role) ? 'selected' : ''; ?>>
                <?= htmlspecialchars(translate($role)) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <input type="submit" value="<?= $isEdit ? 'Mettre à jour' : 'Créer'; ?>">

    <?php if ($isEdit): ?>
        <!-- Bouton pour annuler les modifications et retourner aux détails -->
        <a href="display_user_manage.php?id=<?= $user->getId(); ?>"><input type="button" value="Annuler"></a>
        <!-- Bouton pour supprimer l'utilisateur -->
        <a href="delete_user.php?id=<?= $user->getId(); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
            <input type="button" value="Supprimer">
        </a>
    <?php endif; ?>
</form>