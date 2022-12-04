<?php

class commentairesManager
{
    //DECLARATION ET INSTANCIATION
    public $bdd; 
    public $_result;
    public $_message;
    public $_commentaires; 
    public $_getLastInsertId;

    public function __construct(PDO $bdd)
    {
        $this->setBdd($bdd);
    }


    function getBdd()
    {
        return $this->bdd;
    }

    function get_result()
    {
        return $this->_result;
    }

    function get_message()
    {
        return $this->_message;
    }

    function get_commentaires()
    {
        return $this->_commentaires;
    }

    function get_getLastInsertId()
    {
        return $this->_getLastInsertId;
    }

    //SET

    function setBdd($bdd)
    {
        $this->bdd = $bdd;
    }

    function set_result($_result)
    {
        $this->_result = $_result;
    }

    function set_message($_message)
    {
        $this->_message = $_message;
    }

    function set_commentaires($_commentaires)
    {
        $this->_commentaires = $_commentaires;
    }

    function set_getLastInsertId($_getLastInsertId)
    {
        $this->_getLastInsertId = $_getLastInsertId;
    }



    //Je get un  commentaire à partir de l'ID
    public function getCommentairesById($id)
    {
        //prepare une requete de type select avec une clause WHERE  
        $sql = 'SELECT * FROM commentaires WHERE id = :id';
        $req = $this->bdd->prepare($sql);

        //execution de la requete avec attribution des valeurs
        $req->bindValue(':id', $id, PDO::PARAM_INT); //param init va permettre de verifier si ce qu'on rentre comme données correspond bien a un INT sinon le programme renvoie une erreur
        $req->execute();

        //on stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $commentaires = new commentaires();
        $commentaires->hydrate($donnees);
        return $commentaires;
    }

//je get une LIST Commentaires par rapport a un article 

    public function getListCommentaires2($id_articles)
    {
        $listCommentaires = []; //on créer une liste vide ou on mettra tous les commentaires


        //prepare une requete de type select
        $sql = 'SELECT * FROM commentaires WHERE id_articles = :id_articles';


        $req = $this->bdd->prepare($sql);

        //execution de la requete avec attribution des valeurs
        $req->bindValue(':id_articles', $id_articles, PDO::PARAM_INT);
        $req->execute();

        //on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { //tant qu'il y a des commentaires, on boucle
            //on créer des objets avec les données issue de la bdd
            $commentaires = new commentaires();
            $commentaires->hydrate($donnees);
            $listCommentaires[] = $commentaires;
        }
        //print_r2($listCommentaires)
        return $listCommentaires;
    }


    //je GET une LIST Commentaires par rapport a un article mais avec une jointure

    public function getListCommentairesJointures($id_articles)
    {
        $listCommentaires = []; //on creer une liste vide ou ont mettra tous les commentaires


        //prepare une requete de type select
        $sql = 'SELECT * FROM commentaires as co INNER JOIN articles as ar ON ar.id = co.id_articles  WHERE co.id_articles = :id_articles';


        $req = $this->bdd->prepare($sql);

        //execution de la requete avec attribution des valeurs
        $req->bindValue(':id_articles', $id_articles, PDO::PARAM_INT);
        $req->execute();

        //on stocke les données obtenues dans un tableau
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) { //tant que il y a des commentaires alors on boucle
            //on cree des objets avec les données issue de la bdd
            $commentaires = new commentaires();
            $commentaires->hydrate($donnees);
            $listCommentaires[] = $commentaires;
        }
        return $listCommentaires;
    }

    public function addCommentaires(commentaires $commentaires)
    {
        $sql = "INSERT INTO commentaires "
            . "(id_articles, pseudo, email, commentaires_texte)"
            . "VALUES (:id_articles, :pseudo , :email , :commentaires_texte)";
        $req = $this->bdd->prepare($sql); // Prépare la requette en ayant effectuer la connexion au préalable
        $req->bindValue(':id_articles', $commentaires->getid_articles(), PDO::PARAM_INT);
        $req->bindValue(':pseudo', $commentaires->getpseudo(), PDO::PARAM_STR);
        $req->bindValue(':email', $commentaires->getemail(), PDO::PARAM_STR);
        $req->bindValue(':commentaires_texte', $commentaires->getcommentaires_texte(), PDO::PARAM_STR);

        $req->execute();
        if ($req->errorCode() == 00000) {
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->lastInsertId();
        } else {
            $this->_result = false;
        }
        return $this;
    }


}
