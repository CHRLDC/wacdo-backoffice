<?php

/** ./modeles/Order_Element.php
 * 
 * Modele de donnée Order_Element
 * 
 */

class Order_Element extends _model
{
    // Nom de la table
    protected $table = 'Order_Element';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("Order", "LINK", "Commande", "Order");
        $this->addField("Element", "LINK", "Élément", "Element");
    }
}
