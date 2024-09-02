<?php // autoload.php

/**
 * 
 *** Fonctions d'autochargement ***
 * 
 *      Charge toutes les classes dans le dossier modeles
 *      Charge tous les fichiers de configurations dans le dossier utils
 * 
 */

/**
 * Autochargement des fichiers classes
 * @param string $class nom de la classe
 * @return void
 */
function autoloadClasses($class)
{
    // Comportement original : charger les classes depuis le dossier 'modeles'
    $filePath = "modeles/$class.php";
    if (file_exists($filePath)) {
        include $filePath;
    }

    // Si la classe n'a pas été trouvée, vérifier si c'est la classe 'Cart' dans le namespace 'Utils'
    if (!class_exists($class, false)) { // false pour ne pas tenter de charger la classe à nouveau
        if ($class === 'Utils\\Cart') {
            $cartFilePath = __DIR__ . "/utils/cart.php";
            if (file_exists($cartFilePath)) {
                include $cartFilePath;
            }
        }
    }

    // Si après tout cela, la classe n'existe toujours pas, afficher une erreur
    if (!class_exists($class, false)) {
        echo "La classe $class n'existe pas après chargement.";
    }
}


/**
 * Autochargement des fichiers de configuration dans le dossier utils
 */
function autoloadConfig()
{
    // Dossier contenant les fichiers de configuration
    $configDir = 'utils';

    // Récupérer la liste des fichiers présents dans le dossier utils
    $files = scandir($configDir);

    // Parcourir chaque fichier trouvé dans le dossier utils
    foreach ($files as $file) {
        // Ignorer certains fichiers spécifiques et les répertoires spéciaux
        if ($file === 'autoload.php' || $file === 'init.php' || $file === '.' || $file === '..') {
            continue; // Passer au fichier suivant
        }

        // Construire le chemin complet vers le fichier
        $filePath = "$configDir/$file";

        // Vérifier si le fichier a l'extension PHP
        if (pathinfo($filePath, PATHINFO_EXTENSION) === 'php') {
            try {
                // Inclure le fichier PHP une seule fois
                require_once $filePath;
            } catch (Throwable $e) {
                // En cas d'erreur lors de l'inclusion, loguer l'erreur et passer au fichier suivant
                error_log("Erreur lors de l'inclusion du fichier : $filePath - " . $e->getMessage());
                continue; // Continuer la boucle pour traiter les autres fichiers
            }
        }
    }
}
