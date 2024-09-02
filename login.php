<?php

/**
 * 
 * Contrôleur: Gèrer l'authentification de l'utilisateur
 *             Initie une session $utilisateur
 * 
 * @param string POST['email'] - Le mail de l'utilisateur
 * @param string POST['password'] - Le mot de passe de l'utilisateur
 * 
 */

// Initialisation des variables globales
include_once "utils/init.php";

// Récupération des données JSON envoyées par login.js
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier les données reçues
if (!$data) {
    echo json_encode(['success' => false]);
    exit;
}

// Récupérer le login et le mot de passe envoyés en JSON
$login = isset($data['email']) ? $data['email'] : '';
$password = isset($data['password']) ? $data['password'] : '';

// Authentification de l'utilisateur
$utilisateur = new User();
$id = $utilisateur->checkAuthentification($login, $password);
if ($id == false) {
    // Si false, envoyer une réponse JSON avec une erreur
    echo json_encode(['success' => false]);
    exit;
}

// Attendre 1 secondes (sécurité)
sleep(1);

// L'utilisateur est authentifié, chargement et lancement de la session
$utilisateur->load($id);
sessionConnect($id);

// Envoyer une réponse JSON avec succès
echo json_encode(['success' => true]);
exit;
