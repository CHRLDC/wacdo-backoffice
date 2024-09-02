<?php

/** ./modeles/User.php
 * 
 * Modele de donnée User
 * 
 */

class User extends _model
{
    // Nom de la table
    protected $table = 'User';

    // Création des champs ($name, $type, $libelle, $link);
    protected function define()
    {
        $this->addField("name", "TXT", "Nom");
        $this->addField("first_name", "TXT", "Prénom");
        $this->addField("mail", "TXT", "Email");
        $this->addField("password", "TXT", "Mot de passe");
        $this->addField("role", "TXT", "Rôle");
    }

    /**
     * Authentifier un utilisateur
     * @param string $login - le login de l'utilisateur
     * @param string $password - le mot de passe de l'utilisateur
     * @return int - l'id de l'utilisateur
     */
    public function checkAuthentification($login, $password)
    {
        try {
            // Vérifier si le login existe dans la base de données
            $sql = "SELECT * FROM `$this->table` WHERE `mail` = :login LIMIT 1";
            $param = [":login" => $login];

            // Préparer et exécuter la requête
            global $bdd;
            $req = $bdd->prepare($sql);
            if (!$req->execute($param)) {
                // Si on a une erreur de requête, retourner false
                return false;
            }

            // On récupère l'utilisateur
            $utilisateur = $req->fetch(PDO::FETCH_ASSOC);
            if (!$utilisateur) {
                // Aucun utilisateur trouvé avec ce login
                return false;
            }

            // Vérifier le mot de passe
            if (!password_verify($password, $utilisateur['password'])) {
                // Mot de passe incorrect
                return false;
            }

            // Authentification réussie, retourner l'id de l'utilisateur
            return $utilisateur['id'];
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            error_log('Erreur de base de données : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier si un email existe dans la base de données
     * @param string $email - l'email à vérifier
     * @return int - l'id de l'utilisateur
     */
    public function checkByEmail($email)
    {
        try {
            // Vérifier si le login existe dans la base de données
            $sql = "SELECT * FROM `$this->table` WHERE `mail` = :email LIMIT 1";
            $param = [":email" => $email];

            // Préparer et exécuter la requête
            global $bdd;
            $req = $bdd->prepare($sql);
            if (!$req->execute($param)) {
                // Si on a une erreur de requête, retourner false
                return false;
            }

            // On récupère l'utilisateur
            $utilisateur = $req->fetch(PDO::FETCH_ASSOC);
            if (!$utilisateur) {
                // Aucun utilisateur trouvé avec ce login
                return false;
            }
            // Authentification réussie, retourner l'id de l'utilisateur
            return $utilisateur['id'];
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            // Log ou traitement spécifique des erreurs
            error_log('Erreur de base de données : ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Modifier le mot de passe d'un utilisateur
     * @param int $id - l'id de l'utilisateur
     * @param string $password - le nouveau mot de passe
     */
    public function resetPassword($id, $password)
    {
        $user = new User($id);
        $user->set("password", password_hash($password, PASSWORD_BCRYPT));
        $user->update();
    }

    /**
     * Récupérer les rôles
     * @return array - les rôles
     */
    public function getRoles()
    {
        // Définir le nom de la colonne que nous cherchons
        $columnName = "role";

        // Construire la requête SQL avec un placeholder pour le nom de la colonne
        $sql = "SHOW COLUMNS FROM `$this->table` LIKE :columnName";

        // Créer un tableau de paramètres pour la requête
        $param = [':columnName' => $columnName];

        // Exécuter la requête SQL en utilisant la méthode executeSQL()
        $stmt = $this->executeSQL($sql, $param);

        // Récupérer le résultat de la requête
        /** @var PDOStatement $stmt */
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Extraire les valeurs possibles de l'énumération depuis la colonne 'Type'
        $enumValues = $result['Type']; // Ex: "enum('admin','preparer','reception')"

        // Nettoyer et transformer ces valeurs en un tableau
        $enumValues = str_replace(["enum('", "')", "'"], "", $enumValues);
        $roles = explode(",", $enumValues);

        // Retourner le tableau des rôles
        return $roles;
    }
}
