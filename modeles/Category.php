<?php

/** ./modeles/Category.php
 * 
 * Modele de donnée Category
 * 
 */

class Category extends _model
{
    // Nom de la table
    protected $table = 'Category';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("title", "TXT", "Titre");
        $this->addField("image_path", "TXT", "Chemin de l'image");
    }
}
