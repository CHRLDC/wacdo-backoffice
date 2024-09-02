<?php

/** ./modeles/Product.php
 * 
 * Modele de donnée product
 * 
 */

class Product extends _model
{
    // Nom de la table
    protected $table = 'Product';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("Category", "LINK", "Catégorie", "Category");
        $this->addField("name", "TXT", "Nom");
        $this->addField("description", "TXT", "Description du produit");
        $this->addField("price", "DEC", "Prix");
        $this->addField("status", "TXT", "Status");
        $this->addField("image_path", "TXT", "Chemin de l'image");
    }

    /**
     * Récupérer la catégorie associée à un produit
     * @param int $productId L'ID du produit
     * @return array|null Les informations de la catégorie ou null si non trouvée
     */
    public function getCategory($productId)
    {
        // Construire la requête SQL pour récupérer la catégorie associée
        $sql = "SELECT c.*
            FROM Category c
            INNER JOIN Product p ON c.id = p.Category
            WHERE p.id = :productId";

        // Exécuter la requête avec l'ID du produit comme paramètre
        $param = [":productId" => $productId];
        $stmt = $this->executeSQL($sql, $param);
        /** @var PDOStatement $stmt */
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourner les informations de la catégorie ou null si non trouvée
        return $category ?: null;
    }

    /**
     * Lister tous les produits d'une catégorie
     * @param int $category_id L'ID de la catégorie
     * @return array Liste des produits, peut être vide si aucun produit trouvé
     */
    function getProductsOfCategory($category_id)
    {
        // Construire la requête SQL
        $sql = "SELECT p.* FROM $this->table p 
            INNER JOIN Category c ON p.Category = c.id
            WHERE c.id = :category_id";
        $param = [":category_id" => $category_id];

        // Exécuter la requête et sélectionner le résultat en forme de liste indexée par l'id
        $products = $this->getListformSql($sql, $param);

        // Retourner la liste, peut être vide
        return $products;
    }

    /**
     * Récupérer tous les produits d'un élément
     * @param int $element_id L'ID de l'élément
     * @return array Liste des produits, peut être vide si aucun produit trouvé
     */
    function getProductsOfElement($element_id)
    {
        // Construire la requête SQL
        $sql = "SELECT p.* FROM $this->table p 
            INNER JOIN Element_Product ep ON p.id = ep.Product
            WHERE ep.Element = :element_id";
        $param = [":element_id" => $element_id];

        // Exécuter la requête et récupérer le résultat en forme de liste indexée par l'id
        $products = $this->getListformSql($sql, $param);

        return $products;
    }
}
