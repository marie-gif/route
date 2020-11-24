<?php

$data = array(
    'nomSousCat'=>$_POST['Souspets'],
    'idCategorie'=>$_POST['idCategorie'],
    
    
);


$Scat = New SousCategories($data);
$manager = New manager();
$manager->enregistreSousCategories();


