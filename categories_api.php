<?php

/*
 * categories_api.php
 * Controleur API: Générer la liste des catégories, structurée sous format JSON
 */

// Ajouter les en-têtes CORS
header('Access-Control-Allow-Origin: *'); // Permet toutes les origines
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Méthodes autorisées
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // En-têtes autorisés

// Initialisation des variables globales
include_once "utils/init.php";

// Vérifier si la key API est valide
$key = $_GET['key'] ?? '';
// à faire...

// Charger les catégories depuis la base de données
$category = new Category();
$categoryList = $category->listAll();

// Structurer les catégories
$response = [];

foreach ($categoryList as $cat) {
    $response[] = [
        'id' => (int)$cat->getId(),
        'title' => $cat->title->html(),
        'image' => $cat->image_path->html()
    ];
}

// Renvoyer la réponse JSON avec l'option pour éviter l'échappement des barres obliques
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_SLASHES);
