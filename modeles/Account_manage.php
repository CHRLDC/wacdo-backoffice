<?php

/** ./modeles/Account_manage.php
 * 
 * Modele de donnée Account_manage
 * 
 */

class Account_manage extends _model
{
    // Nom de la table
    protected $table = 'Account_manage';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("User", "LINK", "Utilisateur", "User");
        $this->addField("date_token_mail", "DATETIME", "Date du token mail");
        $this->addField("date_validation_mail", "DATETIME", "Date de validation du mail");
        $this->addField("status", "TXT", "Statut");
        $this->addField("token_reset_mdp", "TXT", "Token de réinitialisation de mot de passe");
        $this->addField("compteur_echec", "INT", "Compteur d'échecs");
        $this->addField("date_creation", "DATETIME", "Date de création");
    }

    /**
     * Surcharge du constructeur pour charger les données avec id de User
     * @param int $userId L'id de l'utilisateur (facultatif)
     * @return true si ok
     */
    public function __construct($userId = null)
    {
        // Appeler le constructeur parent
        parent::__construct();

        // Si un userId est passé en paramètre, charger les données de cet utilisateur
        if ($userId !== null) {
            $this->loadByUserId($userId);
        }
        return true;
    }

    /**
     * Charger les données d'un utilisateur avec son id
     * @param int $userId L'id de l'utilisateur
     */
    public function loadByUserId($userId)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE `User` = :userId";
        $stmt = $this->executeSQL($sql, [":userId" => $userId]);

        // Récupérer les données
        /** @var PDOStatement $stmt */
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si des données sont trouvées, les assigner aux champs de l'objet
        if ($data) {
            $this->assignValues($data);
        }
    }

    /**
     * Modifier le token et la date de la table Account_manage
     * @param string $token_password Le nouveau token
     */
    public function updateAccount($token_password)
    {
        // Assigner le nouveau token et la date à l'objet
        $this->set("token_reset_mdp", $token_password);
        $this->set("date_token_mail", date("Y-m-d H:i:s"));
        $this->update();
    }

    /**
     * Générer une clé aléatoire de 32 caractères
     * @return string la clé
     */
    public function generateRandomKey()
    {
        $longueur = 32;
        // Générer des octets aléatoires
        $bytes = random_bytes($longueur);
        // Encoder en base64 pour obtenir une chaîne de caractères
        $key = substr(bin2hex($bytes), 0, $longueur);
        return $key;
    }

    /**
     * Controler la validité de la clé de récupération du mot de passe
     * @param string $key La clé a valider
     */
    public function checkKeyTokenMail($key)
    {
        // Rechercher si le token existe dans la table Account_manage et s'il est encore valide (moins de 24h)
        $sql = "SELECT COUNT(*) FROM " . $this->table . " 
                WHERE token_reset_mdp = :token_reset_mdp 
                AND TIMESTAMPDIFF(HOUR, date_token_mail, NOW()) <= 24";

        $stmt = $this->executeSQL($sql, [":token_reset_mdp" => $key]);

        // Récupérer le nombre de lignes trouvées
        /** @var PDOStatement $stmt */
        $count = $stmt->fetchColumn();

        // Retourner true si la clé existe et est encore valide, sinon false
        return $count > 0;
    }
}
