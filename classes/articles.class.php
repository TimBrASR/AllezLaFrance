<?php

class articles {

    /**
     * 
     * @var int
     */
    public ?int $id;

    /**
     * 
     * @var string
     */
    public string $titre;

    /**
     * 
     * @var string
     */
    public string $texte;

    /**
     * 
     * @var string
     */
    public string $date;

    /**
     * 
     * @var bool
     */
    public bool $publie;

    /**
     * 
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * 
     * @return string
     */
    public function getTitre(): string {
        return $this->titre;
    }

    /**
     * 
     * @return string
     */
    public function getTexte(): string {
        return $this->texte;
    }

    /**
     * 
     * @return string
     */
    public function getDate(): string {
        return $this->date;
    }

    /**
     * 
     * @return bool
     */
    public function getPublie(): bool {
        return $this->publie;
    }

    /**
     * 
     * @param int|null $id
     * @return self
     */
    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * 
     * @param string $titre
     * @return self
     */
    public function setTitre(string $titre): self {
        $this->titre = $titre;
        return $this;
    }

    /**
     * 
     * @param string $texte
     * @return self
     */
    public function setTexte(string $texte): self {
        $this->texte = $texte;
        return $this;
    }

    /**
     * 
     * @param string $date
     * @return self
     */
    public function setDate(string $date): self {
        $this->date = $date;
        return $this;
    }

    public function setPublie(bool $publie): self {
        $this->publie = $publie;
        return $this;
    }

    /**
     * 
     * @param array $donnees
     * @return self
     */
    public function hydrate(array $donnees): self {

        if (!empty($donnees['id'])) {
            $this->setId($donnees['id']);
        } else {
            $this->setId(null);
        }

        if (!empty($donnees['titre'])) {
            $this->setTitre($donnees['titre']);
        } else {
            $this->setTitre('');
        }
        if (!empty($donnees['texte'])) {
            $this->texte = $donnees['texte'];
        } else {
            $this->texte = '';
        }
        if (!empty($donnees['date'])) {
            $this->setDate($donnees['date']);
        } else {
            $this->setDate('');
        }
        if (!empty($donnees['publie'])) {
            $this->setPublie($donnees['publie']);
        } else {
            $this->setPublie(0);
        }

        return $this;
    }


/**
     * 
     * @return array
     */
    public function getList(): array {
        $listArticle = [];

        // Prépare une requête de type SELECT avec une clause WHERE selon l'id.
        $sql = 'SELECT id, '
                . 'titre, '
                . 'texte, '
                . 'publie, '
                . 'DATE_FORMAT(date, "%d/%m/%Y") as date '
                . 'FROM articles';

        $req = $this->bdd->prepare($sql);

        // Exécution de la requête avec attribution des valeurs aux marqueurs nominatifs.
        $req->execute();

        // On stocke les données obtenues dans un tableau.
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            //On créé des objets avec les données issues de la table
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }

        //print_r2($listArticle);
        return $listArticle;
    }
}