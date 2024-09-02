<?php

/**
 * translation.php
 * Fonctions de traduction générales de l'application
 */


/**
 * Retourner la traduction d'un mot à partir de la table de traduction
 * @param string $key - le mot
 * @return string la traduction
 */
function translate($key)
{
    // Tableaux de traduction
    $translations = [
        'orderType' => [
            'eatIn' => 'Sur place',
            'takeOut' => 'À emporter',
        ],
        'status' => [
            'standby' => 'En attente',
            'inProgress' => 'En cours de préparation',
            'prepared' => 'Préparée',
            'delivered' => 'Livrée',
            'canceled' => 'Annulée',
        ],
        'role' => [
            'admin' => 'Administrateur',
            'preparer' => 'Préparateur de commande',
            'reception' => 'Receptionniste',
        ]
    ];

    // Parcourir les catégories pour trouver la traduction correspondante
    foreach ($translations as $category => $translation) {
        if (isset($translation[$key])) {
            return $translation[$key];
        }
    }

    // Si aucune traduction n'est trouvée, retourner la clé originale
    return $key;
}
