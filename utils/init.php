<?php // init.php

/**
 * 
 *** Code d'initialisation: initialisation des fichiers ***
 *
 *          Lancer les codes pour autochargement des classes et des configurations
 *          Lancer le code pour l'utilisation du render
 *          Lancer le mecanisme de session
 * 
 */

// Initialisation et lancement de l'autochargement des classes
include_once "utils/autoload.php";
autoloadConfig();

// Lancement de l'autochargement des fichiers utils
spl_autoload_register("autoloadClasses");

// Activer le mecanisme de sessions
sessionActivation();
