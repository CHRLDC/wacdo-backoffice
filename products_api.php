<?php

/*
 * products_api.php
 * API pour récupérer la liste des produits
 */

// Ajouter les en-têtes CORS
header('Access-Control-Allow-Origin: *'); // Permet toutes les origines
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Méthodes autorisées
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // En-têtes autorisés

// Si la méthode est OPTIONS, retourner une réponse vide avec le code 200
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Initialisation des variables globales
include_once "utils/init.php";

// Vérifier si la key API est valide
$key = $_GET['key'] ?? '';
// à faire...

// Charger les produits depuis la base de données
$product = new Product();
$productList = $product->listAll();

// Structurer les produits dans le format attendu
$response = [
    'menus' => [],
    'burgers' => [],
    'boissons' => [],
    'frites' => [],
    'encas' => [],
    'desserts' => [],
    'sauces' => [],
    'salades' => [],
    'wraps' => []
];

// Parcourir les produits et les organiser par catégorie
foreach ($productList as $prod) {
    $category = $prod->getCategory($prod->getId());

    if ($category) {
        $categoryKey = strtolower(str_replace(' ', '', $category['title']));

        if (isset($response[$categoryKey])) {
            $response[$categoryKey][] = [
                'id' => (int)$prod->getId(),
                'nom' => $prod->name->html(),
                'prix' => round($prod->price->html(), 2),
                'image' => $prod->image_path->html()
            ];
        }
    }
}

// Renvoyer la réponse JSON
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_SLASHES);
