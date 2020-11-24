<?php

class Manager {

    private $_db;
    private $jeux;

    public function __construct()
    {
        $db = new Database();
        $this->db = $db->getConnection();                     
    }

    public function ajouterJeux($jeu){
       $this->jeux[] = $jeu;
     }
    public function getJeux(){
         return $this->jeux;
     }
    public function nouvelleCat($groupe)
    {
        $q = $this->db->prepare('SELECT COUNT(*) FROM categories WHERE groupe=:groupe');
        $q->bindValue(':groupe', $groupe);
        $q->execute(); 
        
        $toto = $q->fetchColumn();  
        if( $toto==0 )
        {
            $q = $this->db->prepare('INSERT INTO categories(groupe) VALUES(:groupe)');
            $q->bindValue(':groupe', $groupe);
            $q->execute();
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
    public function sousCat($nomSousCat,$idCategorie)
    {
        $q = $this->db->prepare('SELECT COUNT(*) FROM souscategories WHERE nomSousCat=:nomSousCat');
        $q->bindValue(':nomSousCat', $nomSousCat);
        $q->execute(); 
        
        $toto = $q->fetchColumn();  
        if( $toto==0 )
        {
            $q = $this->db->prepare('INSERT INTO souscategories(nomSousCat,idCategorie) VALUES(:nomSousCat,:idCategorie)');
            $q->bindValue(':nomSousCat', $nomSousCat);
            $q->bindValue(':idCategorie', $idCategorie);
            $q->execute();
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }


    public function allCat()
    {
        $q = $this->db->query('SELECT * FROM categories');
        return $q->fetchAll();
    }    
    public function sousCatAll($idCategorie)
    {
        $q = $this->db->prepare('SELECT * FROM souscategories WHERE idCategorie=:idCategorie');
        $q->bindValue(':idCategorie', $idCategorie);
        $q->execute();
        return $q->fetchAll();
    }    


    public function modifCat($groupe, $id)
    {
        $q = $this->db->prepare('UPDATE categories SET groupe=:groupe WHERE id=:id');
        $q->bindValue(':groupe', $groupe);
        $q->bindValue(':id', $id);
        $q->execute();
        echo "<meta http-equiv='refresh' content='0'>";
    }        

    public function modifsousCat($nomSousCat, $id)
    {
        $q = $this->db->prepare('UPDATE souscategories SET nomSousCat=:nomSousCat WHERE id=:id');
        $q->bindValue(':nomSousCat', $nomSousCat);
        $q->bindValue(':id', $id);
        $q->execute();
        echo "<meta http-equiv='refresh' content='0'>";
    }  
    
    


    public function supCat( $id)
    {
        $q = $this->db->prepare('DELETE FROM categories WHERE id=:id');
        $q->bindValue(':id', $id);
        $q->execute();
        echo "<meta http-equiv='refresh' content='0'>";
    }        

    public function supsousCat($id)
    {
        $q = $this->db->prepare('DELETE FROM souscategories WHERE id=:id');
        $q->bindValue(':id', $id);
        $q->execute();
        echo "<meta http-equiv='refresh' content='0'>";
    }  






    // public function aLLsousCatAll()
    // {
    //     $q = $this->db->QUERY('SELECT * FROM souscategories');
    //     return $q->fetchAll();
    // }        
    
    
    public function enregistreSousCategories()
    {

        $q = $this->db->prepare('INSERT INTO souscategorie(nomSousCat,idCategorie) VALUES
        (:nomSousCat,:idCategorie)');
        $q->bindValue(':nomSousCat', $nomSousCat);
        $q->bindValue(':idCategorie', $idCategorie);
        $q->execute();
    }

    public function enregistreJeux(Jeux $jouet, $files)
    {

        $q = $this->db->prepare('INSERT INTO jeux(nom,categorie,prix,quantite,annee,image,cote) VALUES
        (:nom,:categorie,:prix,:quantite,:annee,:image,:cote)');
        $q->bindValue(':nom', $jouet->getNom());
        $q->bindValue(':categorie', $jouet->getCategorie());
        $q->bindValue(':prix', $jouet->getPrix());
        $q->bindValue(':quantite', $jouet->getQuantite());
        $q->bindValue(':annee', $jouet->getAnnee());
        $q->bindValue(':image', '');
        $q->bindValue(':cote', $jouet->getCote());

        $q->execute();

        $id = $this->db->lastInsertId();        

        $messages = array();

        if(isset($files))
        {
            if($files['name']!='')
            {
                include 'model/upload.php';

                if($ok)
                {
                    $q = $this->db->prepare('UPDATE jeux SET image=:image WHERE id=:id');
                    $q->bindValue(':image', 'img'.$id.'.'.$imageFileType);
                    $q->bindValue(':id', $id);
                    $q->execute();

                    array_push($messages, 'file uploaded');
                }
                else
                {
                    array_push($messages, 'file not uploaded');                    
                }

            }
            else
            {
                array_push($messages, 'no file to upload');
            } 
            echo $ok;
        }

        header('Location: index.php?page=accueil&message='.serialize($messages));

    }

    public function afficherJeux()
    {
        $query = 
        'SELECT J.nom nom, J.categorie categorie, S.nomSousCat nomSousCat, C.groupe groupe, J.quantite quantite, J.prix prix, J.annee annee, J.image image, J.cote cote 
        FROM jeux J        
        JOIN souscategories S ON S.id=J.categorie    
        JOIN categories C ON S.idCategorie=C.id        

        ';
        $b = $this->db->prepare($query);
        $b->execute();
        $mesJeux = $b->fetchAll(PDO::FETCH_ASSOC);
       
        return $mesJeux;
        
    }


    public function afficherJeuxByCatId($id)
    {
        $query = 
        'SELECT J.nom nom, J.categorie categorie, S.nomSousCat nomSousCat, C.groupe groupe, J.quantite quantite, J.prix prix, J.annee annee, J.image image, J.cote cote 
        FROM jeux J        
        JOIN categories C ON J.categorie=C.id        
        JOIN souscategories S ON S.idCategorie=C.id
        WHERE C.id='.$id;
        $b = $this->db->prepare($query);
        $b->execute();
        $mesJeux = $b->fetchAll(PDO::FETCH_ASSOC);
       
        return $mesJeux;
        
    }



    public function rechercher($terme )
    {
       
    //    $select_terme = $this->db->query("SELECT
    //     groupe FROM        
    //     categories
    //     WHERE groupe LIKE '%".$terme."%' ");

    $select_terme = $this->db->query(
        "SELECT J.nom nom, C.groupe groupe , S.nomSousCat nomSousCat 
        FROM jeux J
        JOIN categories C ON J.categorie=C.id   
        JOIN souscategories S  ON C.id=S.idCategorie
         
    WHERE groupe LIKE '%".$terme."%' OR nomSousCat LIKE '%".$terme."%' OR nom LIKE '%".$terme."%' ");    

       //$select_terme->bindValue(':terme', $terme);
       
    //    $terme=> $nom;
    //    $terme=> $groupe;
    //    $terme=> $nomSousCat;
    // $select_terme->execute(array());
       //print_r($select_terme);
       //$select_terme->execute(array("%$_GET[$nom]%", "%$_GET[$groupe]%, %$_GET[$nomSousCat]%"));
       //$recher = $select_terme->fetchAll();
       return $select_terme->fetchAll();
    }
    }
