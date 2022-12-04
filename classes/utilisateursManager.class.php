<?php

class utilisateursManager {

    /**
     * 
     * @var PDO
     */
    private PDO $bdd;

    /**
     * 
     * @var bool|null
     */
    private ?bool $_result;

    /**
     * 
     * @var utilisateurs
     */
    private utilisateurs $_utilisateurs;

    /**
     * 
     * @var int
     */
    private int $_getLastInsertId;

    /**
     * 
     * @return PDO
     */
    public function getBdd(): PDO {
        return $this->bdd;
    }

    /**
     * 
     * @return bool|null
     */
    public function get_result(): ?bool {
        return $this->_result;
    }

    /**
     * 
     * @return utilisateurs
     */
    public function get_utilisateurs(): utilisateurs {
        return $this->_utilisateurs;
    }

    /**
     * 
     * @return int
     */
    public function get_getLastInsertId(): int {
        return $this->_getLastInsertId;
    }

    /**
     * 
     * @param PDO $bdd
     * @return self
     */
    public function setBdd(PDO $bdd): self {
        $this->bdd = $bdd;
        return $this;
    }

    /**
     * 
     * @param bool|null $_result
     * @return self
     */
    public function set_result(?bool $_result): self {
        $this->_result = $_result;
        return $this;
    }

    /**
     * 
     * @param utilisateurs $_utilisateurs
     * @return self
     */
    public function set_utilisateurs(utilisateurs $_utilisateurs): self {
        $this->_utilisateurs = $_utilisateurs;
        return $this;
    }

    /**
     * 
     * @param int $_getLastInsertId
     * @return self
     */
    public function set_getLastInsertId(int $_getLastInsertId): self {
        $this->_getLastInsertId = $_getLastInsertId;
        return $this;
    }

    /**
     * 
     * @param PDO $bdd
     */
    public function __construct(PDO $bdd) {
        $this->setBdd($bdd);
    }
    

/**
     * 
     * @param utilisateurs $utilisateurs
     * @return $this
     */
    public function add(utilisateurs $utilisateurs) {
        $sql = "INSERT INTO utilisateurs "
                . "(nom, prenom, email, mdp, sid) "
                . "VALUES (:nom, :prenom, :email, :mdp, :sid)";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':nom', $utilisateurs->getNom(), PDO::PARAM_STR);
        $req->bindValue(':prenom', $utilisateurs->getPrenom(), PDO::PARAM_STR);
        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':mdp', $utilisateurs->getMdp(), PDO::PARAM_STR);
        $req->bindValue(':sid', $utilisateurs->getSid(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }

    /**
     * 
     * @param string $email
     * @return utilisateurs
     */
    public function getByEmail(string $email): utilisateurs {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM utilisateurs WHERE email = :email';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $donnees = !$donnees ? [] : $donnees;

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        //print_r2($utilisateurs);
        return $utilisateurs;
    }

    public function getBySid(string $sid): utilisateurs {
        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT * FROM utilisateurs WHERE sid = :sid';
        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->bindValue(':sid', $sid, PDO::PARAM_STR);
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $donnees = !$donnees ? [] : $donnees;

        $utilisateurs = new utilisateurs();
        $utilisateurs->hydrate($donnees);
        //print_r2($utilisateurs);
        return $utilisateurs;
    }
    
    /**
     * 
     * @param utilisateurs $utilisateurs
     * @return self
     */
    public function updateByEmail(utilisateurs $utilisateurs): self {
        $sql = "UPDATE utilisateurs SET sid = :sid WHERE email = :email";
        $req = $this->bdd->prepare($sql);
        //Sécurisation les variables
        $req->bindValue(':email', $utilisateurs->getEmail(), PDO::PARAM_STR);
        $req->bindValue(':sid', $utilisateurs->getSid(), PDO::PARAM_STR);
        //Exécuter la requête
        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
        } else {
            $this->_result = false;
        }
        return $this;
    }
}