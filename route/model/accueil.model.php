<?php

    

    
    if ($_FILES['image']["size"] > 8000000 )
    {
        $messages = array('La taille maximum est de 8MB');
        header('Location: index.php?page=accueil&message='.serialize($messages));
    }

    $dt = DateTime::createFromFormat('Y-m-d', $_POST['annee']);
    $date = $dt->format('Y');
    
        
        $data = array(
            'nom'=>$_POST['nom'],
            'categorie'=>$_POST['souscatselect'],
            'prix'=>$_POST['prix'],
            'quantite'=>$_POST['quantite'],
            'annee'=>$date,
            'image'=>'',
            'cote'=>$_POST['cote']
        );


    $jeux = New Jeux($data);
    $manager = New manager();
    $manager->enregistreJeux($jeux, $_FILES['image']);
        