<?php
class commentaires
{

    public $id;
    public $id_articles;
    public $pseudo;
    public $email;
    public $commentaires_texte;

    //GetSetID
    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }


    //GetSetid_articles

    function getid_articles()
    {
        return $this->id_articles;
    }

    function setid_articles($id_articles)
    {
        $this->id_articles = $id_articles;
    }


    //GetSetpseudo

    function getpseudo()
    {
        return $this->pseudo;
    }
    function setpseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    //Getsetemail

    function getemail()
    {
        return $this->email;
    }

    function setemail($email)
    {
        $this->email = $email;
    }


    //getSet commentaires_texte

    function getcommentaires_texte()
    {
        return $this->commentaires_texte;
    }

    function setcommentaires_texte($commentaires_texte)
    {
        $this->commentaires_texte = $commentaires_texte;
    }

    public function hydrate($donnees)
    {


//ID
        if (isset($donnees['id'])) {
            $this->id = $donnees['id'];
        } else {
            $this->id = '';
        }


//id_articles
        if (isset($donnees['id_articles'])) {
            $this->id_articles = $donnees['id_articles'];
        } else {
            $this->id_articles = '';
        }


//pseudo
        if (isset($donnees['pseudo'])) {
            $this->pseudo = $donnees['pseudo'];
        } else {
            $this->pseudo = '';
        }

//email
        if (isset($donnees['email'])) {
            $this->email = $donnees['email'];
        } else {
            $this->email = '';
        }

//commentaires_texte
        if (isset($donnees['commentaires_texte'])) {
            $this->commentaires_texte = $donnees['commentaires_texte'];
        } else {
            $this->commentaires_texte = '';
        }
    }
}