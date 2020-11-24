<?php

class SousCategories {

    private $_id;
    private $_nomSousCat;
    private $_idCategorie;

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
public function getId()
{
    return $this->_id;
}
public function get_nomSousCat()
{
    return $this->__nomSousCat;
}
public function get_idCategorie()
{
    return $this->_idCategorie;
}

public function setId($id)
    {
      $this->_id = (int) $id;
    }  
    
public function set_nomSousCat($nomSousCat)
    {
        if (is_string($nomSousCat) )
        {        
            $nomSousCat = ucfirst($nomSousCat);            
            $this->_nomSousCat = $nomSousCat;
        }
    }
    public function set_idCategorie($_idCategorie)
    {
        if (is_string($idCategorie) )
        {        
            $idCategorie = ucfirst($idCategorie);            
            $this->_idCategorie = $idCategorie;
        }
    }

}
