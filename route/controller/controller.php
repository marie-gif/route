<?php


function getAccueil(){
   
    
    require_once "view/accueil.vue.php";
    }

function getPageDejaclient(){
    
 require_once "view/dejaclient.vue.php";
    }
function getPageCategories(){
       
 require_once "view/categories.vue.php";
       
    }

function getPageModelAccueil(){
    
    require_once "model/accueil.model.php";
            
        }
        function getPageSousCatModel(){
    
            require_once "model/sousCat.model.php";
                    
                }
                function getPageDerecherche(){
    
                    require_once "model/verif_form.model.php";
                            
                        }