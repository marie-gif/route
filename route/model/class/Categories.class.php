<?php

class Categories {

    private $_id;
    private $_groupe;
   

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
public function getGroupe()
{
    return $this->_groupe;
}

public function setId($id)
    {
      $this->_id = (int) $id;
    }  
    
public function setGroupe($groupe)
    {
        if (is_string($groupe) )
        {        
            $groupe = ucfirst($groupe);            
            $this->_groupe = $groupe;
        }
    }

}
