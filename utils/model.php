<?php

/**
 *                       
 * Classe _model : contient les fonctions génériques
 * 
 * Utilisation:
 * 
 *            __get():  $obj->nom->value               Appelle _model::__get('nom'), qui utilise _field::__get('value')
 *                  ou  $obj->nom->html()
 *                      $obj->nom->libelle
 *                  ou  $obj->nom->libelleHtml()
 *       
 *            __set():  $obj->nom->value = "Dupond"    Appelle _model::__set('nom', 'Dupond'), qui utilise _field::__set('value', 'Dupond')
 * 
 * 
 */


class _model
{
    // Initialisation des attributs
    protected $table = "";          // Nom de la table
    protected $fields = [];        // Noms des champs

    // Détails de l'Objet
    protected $id = 0;         // id de l'objet chargé
    protected $values = [];   // Valeurs de l'objet
    protected $targets = []; // Objets cibles

    /*****************************************************************************
     *                                                                           *
     *                               Constructeur                                *
     *                                                                           *
     *****************************************************************************/

    /**
     * Constructeur: charge l'objet au moment où on instacie un nouvel objet
     *               Définir les champs
     * @param int $id
     */
    function __construct($id = null)
    {
        // définir les champs
        $this->define();

        // Si l'id est non null, charger l'objet avec l'id
        if (!is_null($id)) {
            $this->load($id);
        }
    }

    /*****************************************************************************
     *                                                                           *
     *               Méthodes liées à l'utilisation de _field.php                *
     *                                                                           *
     *****************************************************************************/

    /**
     * Ajouter un champ dans l'objet courant
     * Créer un nouvel objet _field avec ses propriétés
     * @param string $name Nom du champ
     * @param string $type Type du champ
     * @param string $libelle Libellé du champ
     * @param string $link Lien entre le champ et la classe cible
     */
    protected function addField($name, $type = null, $libelle = null, $link = null)
    {
        $this->fields[$name] = new _field($this, $name, $type, $libelle, $link);
    }

    /**
     * Définir les champs
     * @return void
     */
    protected function define()
    {
        // Doit-être surchagée par les sous-classes
    }

    /**
     * Récupérer tous les champs de l'objet courant
     * @return array Liste des champs
     */
    function getFields()
    {
        return $this->fields;
    }

    /**
     * Récupérer l'objet correspondant au champ donné
     * @param string $field Nom du champ
     * @return object Objet champ
     */
    function field($field)
    {
        if (isset($this->fields[$field])) {
            // Si le champ existe on le retourne
            return $this->fields[$field];
        } else {
            // Sinon, on retourne un objet "vide"
            return new _field($this, "_");
        }
    }
    /*****************************************************************************
     *                                                                           *
     *                               Méthodes: Fonctions                         *
     *                                                                           *
     *****************************************************************************/

    /**
     * Vérifier si l'objet est chargé
     * @return bool
     */
    function isLoad()
    {
        return !empty($this->id);
    }

    /*****************************************************************************
     *                                                                           *
     *                      Getters: Récupérer les attributs                     *
     *                                                                           *
     *****************************************************************************/

    /**
     * Retourner un objet champ
     * @param string $field Nom du champ invoqué
     * @return mixed La valeur du champ si elle existe sinon null
     */
    function __get($property)
    {
        // Si la propriété existe dans les champs
        if (isset($this->fields[$property])) {
            // Retourne l'objet champ (instance de _field)
            return $this->fields[$property];
        } else if ($property === "id") {
            return $this->getId();
        }
        // Si la propriété n'existe pas, retourne null
        return null;
    }

    /**
     * Récupère l'id de l'objet courant
     * @return int Id de l'objet
     */
    function getId()
    {
        return $this->id;
    }

    /*****************************************************************************
     *                                                                           *
     *                      Setters: Modifier les attributs                      *
     *                                                                           *
     *****************************************************************************/

    /**
     * Modifier la valeur d'un champ
     * @param string $property Nom du champ invoqué à modifier
     * @param mixed $value Nouvelle valeur de la propriété
     */
    function __set($field, $value)
    {
        // Si la propriété existe dans les champs
        if (isset($this->fields[$field])) {
            // Utiliser la méthode magique __set de _field pour mettre à jour la valeur
            $this->fields[$field]->value = $value;
        } else {
            throw new Exception("Le champ $field n'existe pas.");
        }
    }

    /**
     * Donner une valeurs à un champ
     * @param string $field Nom du champ
     * @param mixed $value Valeur du champ
     * @return bool
     */
    function set($field, $value)
    {
        // Vérifier si le champ existe dans les champs
        if (isset($this->fields[$field])) {
            // Mettre à jour la valeur dans l'objet _field
            $this->fields[$field]->value = $value;
            return true;
        } else {
            throw new Exception("Le champ $field n'existe pas.");
        }
    }
    /*****************************************************************************
     *                                                                           *
     *                 Méthode de synchronisation avec la BDD                    *
     *                                                                           *
     *****************************************************************************/

    /**
     * Lister tous les objets
     * @return array Liste des objets, peut être vide si aucun objet trouvé
     */
    function listAll()
    {
        // Construire la requête et donner les paramètres (aucuns)
        $sql = "SELECT " . $this->escapedFieldsList() . " FROM `$this->table`";
        $param = [];

        // Exécuter la requête et récupérer le résultat en forme de liste indexée par l'id
        $list = $this->getListformSql($sql, $param);

        // Retourner la liste, peut être vide
        return $list;
    }

    /**
     * Charger l'objet correspondant à l'id donné
     * @param int $id id
     * @return bool
     */
    function load($id)
    {
        // Construire la requête et donner les paramètres
        $sql = "SELECT " . $this->escapedFieldsList() . " FROM `$this->table` WHERE `id` = :id";
        $param = [":id" => $id];

        // Exécuter la requête et récupérer le résultat
        /** @var PDOStatement $result */
        $result = $this->executeSQL($sql, $param);
        $list = $result->fetchAll(PDO::FETCH_ASSOC);

        // Si des résultats sont trouvés
        if (!empty($list)) {
            // Assigner les valeurs du 1er element aux attributs de l'objet courant
            $this->assignValues($list[0]);

            // On renseigne l'id dans l'objet 
            $this->id = $id;

            return true;
        }

        return false;
    }

    /**
     * Insertion d'un nouvel objet
     * @return bool
     */
    function insert()
    {
        // Construire la requête et donner les paramètres
        $sql = "INSERT INTO `$this->table` SET" . $this->buildListSet();
        $param = $this->initParamRequest();

        // Exécuter la requête
        $this->executeSQL($sql, $param);

        // Donner l'id créé au nouvel objet
        global $bdd;
        $this->id = $bdd->lastInsertId();

        return true;
    }

    /**
     * Mettre à jour l'objet courant
     * @return bool
     */
    function update()
    {
        // Construire la requête et donner les paramètres
        $sql = "UPDATE `$this->table` SET " . $this->buildListSet() . " WHERE `id` = :id";
        $param = $this->initParamRequest();
        $param[":id"] = $this->id;
        // Exécuter la requête
        $this->executeSQL($sql, $param);

        return true;
    }

    /**
     * Suppression de l'objet courant
     * @return bool
     */
    function delete()
    {
        // Construire la requête et donner les paramètres
        $sql = "DELETE FROM `$this->table` WHERE `id` = :id";
        $param = [":id" => $this->id];

        // Exécuter la requête
        $this->executeSQL($sql, $param);

        return true;
    }

    /*****************************************************************************
     *                                                                           *
     *                          Méthodes  secondaires                            *
     *                                                                           *
     *****************************************************************************/

    /**                                                            
     * Initialiser les paramètres pour la requête SQL
     * @param void
     * @return array tableau des paramètres des valeurs associées
     */
    protected function initParamRequest()
    {
        // Créer le tableau
        $param = [];
        // Compléter le tableau pour valoriser les noms des champs
        foreach ($this->fields as $field) {
            $param[":" . $field->name] = $field->value ?? null;
        }
        return $param;
    }

    /**
     * Préparer et Exécuter une requête SQL
     * @param string $sql le texte de la requête
     * @param array $param les paramètres de la requête
     * @return $req requête exécutée
     */
    protected function executeSQL($sql, $param)
    {
        // Préparation de la requête
        global $bdd;
        $req = $bdd->prepare($sql);

        // Exécuter la requête
        if (!$req->execute($param)) {
            // Si une erreur s'est produite
            return false;
        }
        return $req;
    }

    /**
     * Exécute une requête SQL et retourne le résultat
     * @param string $sql La requête SQL
     * @param array $param Les paramètres de la requête
     * @return PDOStatement|false Le résultat de la requête ou false en cas d'échec
     */
    protected function getListformSql($sql, $param)
    {
        // Récupérer le résultat de la requête
        $req = $this->executeSQL($sql, $param);

        // Créer la liste d'objet
        $list = [];
        // Tant qu'il y a des éléments dans le résultat, on l'ajoute à la liste d'objet
        /** @var PDOStatement $req */
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            //Récupérer la classe de l'objet
            $class = get_class($this);
            // Créer un objet
            $obj = new $class();
            // Assigner les valeurs
            $obj->assignValues($data);
            // Ajouter l'objet à la liste indexé par son id
            $list[$obj->getId()] = $obj;
        }
        return $list;
    }

    /**
     * Assigner les valeurs aux attributs de l'objet courant
     * @param array $data les valeurs de la requête
     * @return void
     */
    protected function assignValues($data)
    {
        // Si on a des valeurs de la requête
        if (isset($data["id"])) {
            $this->id = $data["id"];
        }

        // Pour chacun des champs, si le champ existe, on assigne la valeur correspondante
        foreach ($this->fields as $field) {
            if (array_key_exists($field->name, $data)) {
                // Assigner la valeur telle qu'elle est, même si c'est NULL
                $field->value = $data[$field->name] !== '' ? $data[$field->name] : null;
            }
        }
    }

    /**
     * Construire la liste des champs pour une requête SELECT
     * @return string Liste des champs échappés (ex: `id`, `nom`, `prenom`)
     */
    protected function escapedFieldsList()
    {
        // Ajouter l'id en premier
        $list = ["`id`"];
        // Ajouter chaque champ
        foreach ($this->fields as $field) {
            $list[] = "`" . $field->name . "`";
        }

        // Retourne la liste des champs séparés par des virgules
        return implode(', ', $list);
    }

    /**
     * Construire la liste des élements pour une requête SET & UPDATE
     * @return string Liste des élements (ex: `nomChamp` = :nomChamp)
     */
    protected function buildListSet()
    {
        // Faire un tableau contenant pour chaque champ, un élément avec le texte `nomChamp` = :nomChamp
        $result = [];
        foreach ($this->fields as $field) {
            $result[] = "`" . $field->name . "` = :" . $field->name;
        }

        // Générer le texte final en utilisant implode pour séparer les éléments par une virgule
        return implode(", ", $result);
    }

    /**
     * Récupérer les valeurs des champs de l'objet sous forme de tableau associatif
     * @return array Tableau associatif des champs et leurs valeurs
     */
    public function getFieldsArray()
    {
        $fieldsArray = [];

        // Ajouter l'id en premier
        $fieldsArray['id'] = $this->id;

        // Ajouter chaque champ avec sa valeur
        foreach ($this->fields as $field) {
            $fieldsArray[$field->name] = $field->value;
        }

        return $fieldsArray;
    }
}
