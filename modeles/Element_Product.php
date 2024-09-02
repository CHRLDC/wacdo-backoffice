<?php

/** ./modeles/Element_Product.php
 * 
 * Modele de donnée Element_Product
 * 
 */

class Element_Product extends _model
{
    // Nom de la table
    protected $table = 'Element_Product';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("Element", "LINK", "Élément", "Element");
        $this->addField("Product", "LINK", "Produit", "Product");
    }

    /**
     * Insertion d'un produit pour un élément
     * @param int $elementId - l'id de l'élément
     * @param int $productId - l'id du produit
     */
    public function insertProductForElement($elementId, $productId)
    {
        // Valider et nettoyer les identifiants
        $elementId = (int)$elementId;
        $productId = (int)$productId;

        // Assigner les valeurs aux champs
        $this->Element->value = $elementId;
        $this->Product->value = $productId;

        // Insertion dans la table Element_Product
        $this->insert();
    }
}
