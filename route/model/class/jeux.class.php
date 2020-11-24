<?php

class Jeux {

    private $_id;
    private $_nom;
    private $_categorie;
    private $_prix;
    private $_quantite;
    private $_annee;
    private $_image;
    private $_cote;
   

    public function __construct(array $donnees){

        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
                
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
            // On appelle le setter.
            $this->$method($value);
            }
        }
    }
    
    public function getId() { return $this->_id; }
    public function getNom() { return $this->_nom; }
    public function getCategorie() { return $this->_categorie; }
    public function getPrix() { return $this->_prix; }
    public function getQuantite() { return $this->_quantite; }
    public function getAnnee() { return $this->_annee; }
    public function getImage() { return $this->_image; }
    public function getCote() { return $this->_cote; }

    public function setId($id)
    {
        $this->_id = (int) $id;
    }  
        
    public function setNom($nom)
    {
        if (is_string($nom) )
        {                    
            $this->_nom = ucfirst($nom);            
        }
    }

    public function setCategorie($categorie)
    {
        $this->_categorie = (int) $categorie;
    }  

    public function setPrix($prix)
    {
        $this->_prix = (float) $prix;
    }  
    
    public function setQuantite($quantite)
    {
        $this->_quantite = (int) $quantite;
    }    
    
    public function setAnnee($annee)
    {
        $this->_annee = (int) $annee;
    }   
    
    public function setImage($image)
    {
        $this->_image = $image;
    }       

    public function setcote($cote)
    {
        $this->_cote = $cote;
    }           

}
