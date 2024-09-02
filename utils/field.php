<?php // field.php

/**
 * 
 * *** Classe permetant de gérer un champ de base de données ***
 * 
 */

class _field
{
    // Propriétés:

    protected $name;        // nom du champ
    protected $type;        // type de champ : TXT, DATE, DATETIME, NUM, LINK
    protected $libelle;     // Libellé du champ
    protected $link;        // Objet pointé si lien
    protected $object;      // Objet dont ce champ fait partie
    protected $value;       // valeur du champ
    protected $target;       // Objet pointé si chargé

    /**
     * Constructeur
     * @param string $name Nom du champ
     * @param string $type Type de champ : TXT, DATE, DATETIME, NUM, LINK
     * @param string $libelle Libellé du champ
     * @param string $link Nom de l'objet pointé si lien
     */
    function __construct($object, $name, $type = null, $libelle  = null, $link = null)
    {
        // Chargement des propriétés
        $this->object = $object;
        $this->name = $name;
        $this->type = (empty($type) ? "TXT" : $type);
        $this->libelle = (empty($libelle) ? $name : $libelle);
        $this->link = $link;
        $this->target = null;
    }

    /**
     * Charger l'objet lié si le type est LINK
     * @return object|null Instance de l'objet lié ou null
     */
    protected function loadTarget()
    {
        if ($this->type == "LINK" && !empty($this->value) && !empty($this->link)) {
            $class = $this->link;
            $target = new $class($this->value);  // Passez l'ID directement au constructeur
            if ($target->isLoad()) {
                return $target;
            }
        }
        return null;
    }

    /**
     * Renvoyer la valeur de la propriété protégée de la classe
     * @param string $property Nom de la propriété à accéder
     * @return mixed La valeur de la propriété si elle existe
     */
    function __get($property)
    {
        if ($property == "target") {
            if (is_null($this->target) && $this->type == "LINK") {
                $this->target = $this->loadTarget();
            }
            return $this->target;
        }
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * Modifier les propriétés protégées de la classe
     * @param string $property Nom de la propriété à modifier
     * @param mixed $value Nouvelle valeur de la propriété
     */
    function __set($property, $value)
    {
        // Si la propriété existe, on la modifie
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    /**
     * Renvoyer la valeur HTML du champ
     * @return string La valeur HTML
     */
    function html()
    {
        return nl2br(htmlentities($this->value));
    }

    /**
     * Renvoyer le libellé HTML du champ
     * @return string Le libellé HTML
     */
    function libelleHtml()
    {
        return nl2br(htmlentities($this->libelle));
    }
}
