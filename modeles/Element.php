<?php

/** ./modeles/Element.php
 * 
 * Modele de donnée Element
 * 
 */

class Element extends _model
{
    // Nom de la table
    protected $table = 'Element';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("type", "TXT", "Type");
        $this->addField("size_menu", "TXT", "Taille du menu");
        $this->addField("size_item", "TXT", "Taille de l'item");
        $this->addField("quantity", "INT", "Quantité");
        $this->addField("price", "DEC", "Prix");
    }

    /**
     * Récupérer tous les éléments d'une commande
     * @param int $order_id L'ID de la commande
     * @return array Liste des éléments, peut être vide si aucun élément trouvé
     */
    public function getElementsOfOrder($order_id)
    {
        // Construire la requête SQL pour récupérer les IDs des éléments
        $sql = "SELECT e.* FROM Element e 
                INNER JOIN Order_Element oe ON e.id = oe.Element
                WHERE oe.Order = :order_id";
        $param = [":order_id" => $order_id];

        // Exécuter la requête et récupérer le résultat sous forme de liste indexée par l'id
        $elements = $this->getListformSql($sql, $param);

        return $elements;
    }

    /**
     * Insertion d'un élément pour une commande (avec les tables de liaisons)
     * @param int $orderId L'ID de la commande
     * @param array $item Les données de l'item
     */
    public function insertElementFromJson($orderId, $item)
    {
        // Valider et nettoyer les données
        $orderId = (int)$orderId;

        // Nettoyer les données en fonction du type d'élément
        $this->type->value = isset($item['idMenu']) ? 'menu' : 'item';

        if ($this->type->value === 'menu') {
            $this->size_menu->value = isset($item['size']) ? htmlspecialchars($item['size'], ENT_QUOTES, 'UTF-8') : null;
            $this->size_item->value = null;
        } else {
            $this->size_item->value = isset($item['size']) ? htmlspecialchars($item['size'], ENT_QUOTES, 'UTF-8') : null;
            $this->size_menu->value = null;
        }

        $this->quantity->value = isset($item['quantity']) ? (int)$item['quantity'] : 1;
        $this->price->value = isset($item['price']) ? (float)$item['price'] : 0.0;

        // Insertion de l'élément dans la table `Element`
        $this->insert();

        // Récupérer l'ID de l'élément qui vient d'être créé
        global $bdd;
        $elementId = $bdd->lastInsertId();

        // Créer une entrée dans la table de liaison `Order_Element`
        $orderElement = new Order_Element();
        $orderElement->Order->value = $orderId;
        $orderElement->Element->value = $elementId;
        $orderElement->insert();

        // Insérer les produits associés
        $elementProduct = new Element_Product();
        if ($this->type->value === 'menu') {
            // Vérifie si chaque clé existe avant d'essayer de l'utiliser
            if (isset($item['idMenu'])) {
                $elementProduct->insertProductForElement($elementId, $item['idMenu']);
            }
            if (isset($item['sauceId'])) {
                $elementProduct->insertProductForElement($elementId, $item['sauceId']);
            }
            if (isset($item['accompanimentId'])) {
                $elementProduct->insertProductForElement($elementId, $item['accompanimentId']);
            }
            if (isset($item['drinkId'])) {
                $elementProduct->insertProductForElement($elementId, $item['drinkId']);
            }
        } else if ($this->type->value === 'item') {
            if (isset($item['idOther'])) {
                $elementProduct->insertProductForElement($elementId, $item['idOther']);
            }
            if (isset($item['sauceId'])) {
                $elementProduct->insertProductForElement($elementId, $item['sauceId']);
            }
            if (isset($item['idDrink'])) {
                $elementProduct->insertProductForElement($elementId, $item['idDrink']);
            }
        }
    }
}
