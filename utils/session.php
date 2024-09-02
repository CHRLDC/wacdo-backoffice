<?php

/**
 * 
 *** Mécanisme de session ***
 * 
 * Session : permet de stocker des informations dans le navigateur de l'utilisateur
 *           si utilisateur est connecté: $_SESSION["id"] = id de l'utilisateur
 *           sinon: $_SESSION["id"] = 0
 * 
 * Utilisation:
 * 
 *          sessionActivation()             : activation du mécanisme de session (à utiliser en initialisation)
 *          sessionIsconnected()           : vérifier si l'utilisateur est connecté
 *          sessionIdconnected()           : donner l'id de l'utilisateur connecté
 *          sessionUserconnected()         : donner l'objet de l'utilisateur connecté
 *          sessionConnect($id)             : connecter un utilisateur
 *          sessionDeconnect()              : déconnecter l'utilisateur
 *          
 */


/**
 * Activation du mécanisme de session
 * @return bool true si on est connecté, false sinon
 */
function sessionActivation()
{
    // Démarrer le mécanisme de session
    session_start();

    // Sécuriser la session contre les attaques de fixation
    // Vérifier si la session a été initialisée
    if (!isset($_SESSION['initiated'])) {
        // Regénérer la session pour un nouvel ID
        session_regenerate_id();
        // Marquer la session comme initialisée
        $_SESSION['initiated'] = true;
    }

    // Si un utilisateur est connecté :
    if (sessionIsconnected()) {
        // Charger l'objet utilisateur connecté 
        global $utilisateurConnecte;
        $utilisateurConnecte = new User(sessionIdconnected());
        // Si l'utilisateur n'existe plus, forcer la déconnexion
        if (!$utilisateurConnecte->isLoad()) {
            sessionDeconnect();
        }
    }

    return sessionIsconnected();
}

/**
 * Vérifier si l'utilisateur est connecté
 * @return bool true si il est connecté, false sinon
 */
function sessionIsconnected()
{
    return !empty($_SESSION["id"]);
}

/**
 * Donner l'id de l'utilisateur connecté
 * @return int id de l'utilisateur sinon 0
 */
function sessionIdconnected()
{
    if (sessionIsconnected()) {
        return $_SESSION["id"];
    } else {
        return 0;
    }
}

/**
 * Donner l'objet de l'utilisateur connecté
 * @return objet de l'utilisateur, sinon new utilisateur
 */
function sessionUserconnected()
{
    if (sessionIsconnected()) {
        global $utilisateurConnecte;
        return $utilisateurConnecte;
    } else {
        return new User();
    }
}

/**
 * Déconnecter l'utilisateur
 * @return void
 */
function sessionDeconnect()
{
    // Supprimer l'id de l'utilisateur
    $_SESSION["id"] = 0;

    // Vérifier si les cookies de session sont utilisés
    if (ini_get("session.use_cookies")) {
        // Récupérer les paramètres du cookie
        $params = session_get_cookie_params();
        // Supprimer le cookie de session
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Détruire la session
    session_destroy();
}

/**
 * Connecter un utilisateur
 * @param int $id id de l'utilisateur
 * @return bool true
 */
function sessionConnect($id)
{
    $_SESSION["id"] = $id;
    //   - charger l'objet utilisateur connecté 
    global $utilisateurConnecte;
    $utilisateurConnecte = new User(sessionIdconnected());
}

/**
 * Verifier si l'utilisateur a les droits d'accès
 * @param string|array $requiredRoles roles requis
 * @return void
 */
function hasRole($requiredRoles)
{
    $userConnected = sessionUserconnected();
    if (!in_array($userConnected->role->html(), [$requiredRoles, 'admin'])) {
        header("Location: templates/pages/unauthorized.php");
        exit;
    }
    define('ALLOWED', true);
}
