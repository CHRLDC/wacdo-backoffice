<?php

/** ./modeles/Order.php
 * 
 * Modele de donnée Order
 * 
 */

class Order extends _model
{
    // Nom de la table
    protected $table = 'Order';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("number", "TXT", "Numéro de commande");
        $this->addField("place_number", "INT", "Numéro de place");
        $this->addField("orderType", "TXT", "Type de commande");
        $this->addField("amount", "DEC", "Montant");
        $this->addField("status", "TXT", "Statut");
        $this->addField("User", "LINK", "Utilisateur", "User");
        $this->addField("created_date", "DATETIME", "Date de création");
        $this->addField("delivered_date", "DATETIME", "Date de livraison");
    }

    /**
     * Lister les commandes avec statut 'stand by', triées par date de livraison croissante
     * @return array Liste des commandes
     */
    public function listStandByOrdersByDeliveryDate()
    {
        // Construire la requête SQL avec le tri par statut et par date de livraison
        $sql = "SELECT " . $this->escapedFieldsList() . " 
            FROM `$this->table` 
            ORDER BY 
                CASE 
                    WHEN `status` = :status THEN 1 
                    ELSE 2 
                END, 
                `created_date` ASC";

        // Paramètres pour la requête préparée
        $param = [
            ':status' => 'standby'
        ];

        // Exécuter la requête et retourner le résultat
        return $this->getListformSql($sql, $param);
    }

    /**
     * Lister en fonction du choix utilisateur
     * @param string $sortBy Champs de tri
     * @param string $sortOrder Ordre de tri
     * @return array Liste des commandes triées
     */
    public function listOrdersByCustomSort($sortBy, $sortOrder)
    {
        $sql = "SELECT " . $this->escapedFieldsList() . " 
            FROM `$this->table`
            ORDER BY 
                CASE 
                    WHEN `status` = 'standby' THEN 1 
                    ELSE 2 
                END, 
                `$sortBy` $sortOrder";

        return $this->getListformSql($sql, []);
    }

    /**
     * Récupérer tous les détails complets d'une commande, y compris les éléments et les produits associés
     * @param int $order_id L'ID de la commande
     * @return array Détails complets de la commande
     */
    public function getFullOrder($order_id)
    {
        // Charger les détails de la commande
        if (!$this->load($order_id)) {
            return false;
        }

        // Récupérer les champs de la commande sous forme de tableau
        $orderDetails = $this->getFieldsArray();

        // Récupérer les éléments de la commande
        $elementModel = new Element();
        $elements = $elementModel->getElementsOfOrder($order_id);

        // Récupérer les produits de chaques éléments
        $productModel = new Product();
        $productsOfElement = [];
        foreach ($elements as $element) {
            $products = $productModel->getProductsOfElement($element->id);
            $productsOfElement[$element->id] = $products;
            $element->values['products'] = $productsOfElement[$element->id] ?? [];
            $orderDetails['elements'][$element->id] = $element;
        }
        return $orderDetails;
    }

    /**
     * Insertion d'une commande entières
     * @param array $json Les données de la commande
     */
    public function insertFullOrder($json)
    {
        // Assigner les valeurs du JSON
        $this->number->value = $json['orderNumber'];

        // Mapper les valeurs du JSON aux valeurs acceptées par la base de données
        if ($json['orderType'] === "Sur place" || $json['orderType'] === "eatIn") {
            $this->orderType->value = 'eatIn';
        } elseif ($json['orderType'] === "À emporter" || $json['orderType'] === "takeOut") {
            $this->orderType->value = 'takeOut';
        } else {
            throw new Exception("Invalid orderType value: " . $json['orderType']);
        }

        // Nettoyer et convertir le montant en nombre
        $amount = str_replace(',', '.', $json['total']);
        $this->amount->value = floatval($amount);

        // Si placeNumber est présent
        if (!empty($json['placeNumber'])) {
            $this->place_number->value = $json['placeNumber'];
        }

        // Ajouter l'utilisateur à la commande si l'utilisateur est connecté
        if (sessionIsconnected()) {
            $this->User->value = sessionIdconnected();
        }

        // Statut par défaut
        $this->status->value = 'standby';
        // Date de création
        $this->created_date->value = date("Y-m-d H:i:s");

        // Insertion de la commande dans la table `Order`
        $this->insert();

        // Récupérer l'id de la commande qui vient d'être créée
        global $bdd;
        $orderId = $bdd->lastInsertId();

        // Insertion des éléments et menus associés
        $element = new Element();

        // Traitement des items
        if (isset($json['items'])) {
            foreach ($json['items'] as $item) {
                // Vérifier si l'item suit l'ancien ou le nouveau format
                if (isset($item['size']) && is_array($item['size'])) {
                    $item['size'] = array_values($item['size'])[0];
                }
                if (isset($item['sauceId']) && is_array($item['sauceId'])) {
                    $item['sauceId'] = array_values($item['sauceId'])[0];
                }
                $element->insertElementFromJson($orderId, $item);
            }
        }

        // Traitement des menus
        if (isset($json['menu'])) {
            foreach ($json['menu'] as $menu) {
                // Vérifier si le menu suit l'ancien ou le nouveau format
                if (isset($menu['size']) && is_array($menu['size'])) {
                    $menu['size'] = array_values($menu['size'])[0];
                }
                if (isset($menu['sauceId']) && is_array($menu['sauceId'])) {
                    $menu['sauceId'] = array_values($menu['sauceId'])[0];
                }
                if (isset($menu['drinkId']) && is_array($menu['drinkId'])) {
                    $menu['drinkId'] = array_values($menu['drinkId'])[0];
                }
                if (isset($menu['accompanimentId']) && is_array($menu['accompanimentId'])) {
                    $menu['accompanimentId'] = array_values($menu['accompanimentId'])[0];
                }
                $element->insertElementFromJson($orderId, $menu);
            }
        }
    }

    /**
     * Création du numéro de commande
     * @return string Le numéro de commande
     */
    public function generateNumberOrder()
    {
        // Requête pour récupérer le dernier numéro de commande
        $sql = "SELECT `number` FROM `$this->table` ORDER BY `id` DESC LIMIT 1";
        $param = [];

        // Exécuter la requête et récupérer le dernier numéro de commande
        $result = $this->executeSQL($sql, $param);
        /** @var PDOStatement $result */
        $lastOrder = $result->fetch(PDO::FETCH_ASSOC);

        // Extraire la partie numérique du dernier numéro de commande et l'incrémenter
        $lastNumber = (int)substr($lastOrder['number'], -4);
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Ajouter un préfixe
        $currentYear = date('Y-m');
        $orderNumber = $currentYear . $newNumber;

        // Retourner le nouveau numéro de commande
        return $orderNumber;
    }
}
