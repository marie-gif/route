<?php
define("URL",str_replace("index.php","",(isset($_SERVER["HTTPS"])
? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require 'model/Autoloader.class.php';
// Autoloader::register();
require_once "controller/controller.php";



try {
    if(isset($_GET['page']) && !empty($_GET['page'])){
       

    switch ($_GET['page']){
        case"accueil": getAccueil();
    break;
         case "categories": getPageCategories();
    break;
        case "dejaclient": getPageDejaclient();
    break;
        case "model_accueil" : getPageModelAccueil();
    break; 
        case "sousCategorie" : getPageSousCatModel();
    break; 
        case "search" : getPageDerecherche();
    break; 
 
    default: throw new Exception("La page n'existe pas");
      }

    } else {
    getAccueil();
   }
 } catch(Exception $e){
    $errorMessage = $e->getMessage(); 
    require "views/error.view.php";
    }
