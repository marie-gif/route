<DOCTYPE html>
<html>
<head>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</head> 
<body>

<?php $manager = New manager(); ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Vintage</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Mes Categories
        </a>

      <?php $categories = $manager->allCat(); ?>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

          <?php foreach($categories as $cat) : ?>
            <a class="dropdown-item" href="index.php?page=accueil&id_cat=<?= $cat['id']?>"> <?= $cat['groupe'] ?> </a>
          <?php endforeach; ?>
        <div class="dropdown-divider"></div>

          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
     
     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Mes sous Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
     </ul>

    <form action ="" method ="GET" class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" name ="terme" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name = "s" value = "Rechercher">Rechercher</button>

    </form>
  </div>
</nav>


<table class="table table-dark">
<div class="container">
<div class="row">
<div class="col">
<label for="pet-select">jouets</label>
<div>
<?php
  if (isset($_GET["s"]) AND $_GET["s"] == "Rechercher")
  {
      $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les failles html
      $terme = $_GET["terme"];
      $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
      $terme = strip_tags($terme); //pour supprimer les balises html dans la requête
  
      if (isset($terme))
  {
      $terme = strtolower($terme);
      $manager = New manager();
      $recher = $manager->rechercher($terme );
      foreach($recher as $index=>$rech)
      {
        echo $index.') categorie: '.$rech['groupe'];
        echo '<br>---- sous categorie: '.$rech['nomSousCat'];
        echo '<br>---- jeux: '.$rech['nom'].'<br>';        
      }
  }
  
}  
?>
</div>
<?php 
if(isset($_GET['id_cat']))
{
  echo '<h6> Jeux de la categorie'.$_GET['id_cat'].'</h6>';
  $jeux_cat = $manager->afficherJeuxByCatId( $_GET['id_cat'] );
  foreach($jeux_cat as $jeux)
  {
    echo $jeux['nom'].'<br>';
  }
}
?>

</div>

<?php

$categories = $manager->allCat();
if(isset($_POST['ajouterCat']) AND $_POST['ajouterCat_txt']!="" AND !empty($_POST['ajouterCat_txt']))
{
    $ajouterCat= $manager->nouvelleCat($_POST['ajouterCat_txt']);
}

?>

<div class="card" style="width: 18rem;">
<div class="card-body">
<form action = "" method ="POST">
<label><input type ="text" name="ajouterCat_txt">Categorie</label>
<input type="submit" value="ajouter" name="ajouterCat">
</form>
</div>
</div>

<?php

 
 
 if(isset($_POST['ajouterSousCat']) AND $_POST['ajouterSousCat_txt']!="" AND !empty($_POST['ajouterSousCat_txt']))
 {
     if(isset($_POST['pets']) AND $_POST['pets']!="" AND !empty($_POST['pets']))
     {
        $ajouterSousCat= $manager->sousCat($_POST['ajouterSousCat_txt'],$_POST['pets']);
    }
 }

?>

<div class="card" style="width: 18rem;">
  <div class="card-body">
<br>
<form action = "" method ="POST">
    <select name="pets" id="pet-select">
        <option value="">--Choisir une catégorie--</option>
        <?php foreach($categories as $categorie) : ?>
            <option value=<?=$categorie['id']?>> <?=$categorie['groupe']?> </option>;
        <?php endforeach; ?>
    </select>
    <label><input type ="text" name="ajouterSousCat_txt">Sous-Categorie</label>
    <input type="submit" value="ajouter" name="ajouterSousCat">
</form>
<br> 
</div>
</div>

</fieldset>
<fieldset>

<?php


?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
<form enctype="multipart/form-data" action = "index.php?page=model_accueil" method ="POST" >
    <select name="catselect" id="catselect">
        <option value="">--Choisir sa catégorie--</option>
        <?php foreach($categories as $categorie) : ?>
            <option value=<?=$categorie['id']?>> <?=$categorie['groupe']?> </option>;
        <?php endforeach; ?>
    </select>

    <select name="souscatselect" id="souscatselect">
        <option id='empty' value='empty' selected>---</option>
        <?php foreach($categories as $categorie) : ?>
            <?php $ssc = $manager->sousCatAll($categorie['id']); ?>
            <?php foreach($ssc as $souscat) : ?>
                <option data-value=<?=$categorie['id']?> value=<?=$souscat['id']?>> <?=$souscat['nomSousCat']?> </option>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </select>

    </br>
    <label><input type="text" name="nom">Nom</label>
    </br>
    <label><input type="text" name="prix"> Prix</label>
    </br>
    <label><input type="number" name="quantite" value='0' min='0'> Quantité</label>
    </br>
    <label><input type="date" name="annee"> Annee</label>
    </br>
    <label><input type="url" name="cote"> Cote</label> 
    </br>
    <label><input type="file" name="image"> Image</label>    
    </br>
    <input type="submit" value="ajouter" name="enregistre">
</form>

<script>
$("#catselect").change(function() {
  if ($(this).data('options') == undefined) {
    $(this).data('options', $('#souscatselect option').clone());
  }
  var id = $(this).val();
  var options = $(this).data('options').filter('[data-value=' + id + ']');
  $('#souscatselect').html(options).show();
});
</script>
</div>
</div>
<?php 

if(isset($_GET['message']))
{
  $message = unserialize($_GET['message']);
  foreach($message as $mes)
  {
    echo '<p style="color:red">'.$mes.'</p>';
  }
}
?>
    <table class="table table-dark">
    <tr>
    <th>nom</th>
    <th>prix</th>
    <th>categorie</th>
    <th>sous categorie</th>
    <th>quantité</th>
    <th>année</th>
    <th>cote</th>
    <th>image</th>
    </tr>
    <?php
    
     $mesJeux = $manager->afficherJeux();  
     foreach ($mesJeux as $jouet) :
        $groupe = $jouet['groupe'];
        $nomSousCat = $jouet['nomSousCat'];

        unset($jouet['groupe']);
        unset($jouet['nomSousCat']);

        $jeux=new Jeux($jouet);
    ?>
     <tr>
    <td><?= $jeux->getId(); ?> <?= $jeux->getNom(); ?></td>
    <td><?= $jeux->getPrix(); ?></td>
    <td> <?= $groupe?> </td>
    <td><?= $nomSousCat; ?></td>

    <td><?= $jeux->getQuantite(); ?></td>
    <td><?= $jeux->getAnnee(); ?></td>
    <td><?= $jeux->getCote(); ?></td>
    <td><img src="public/img/<?= $jeux->getImage(); ?>" height="50px" width="auto"></td>
    </tr>
    <?php 
    endforeach;
     ?> 
    </table>

<div id="mescats"></div>

<?php
if( isset( $_POST['modif_cat']))
{
    $groupe = $_POST['nom_cat'];
    $id = $_POST['id_cat'];
    $manager->modifCat($groupe, $id);
}

if( isset( $_POST['modif_souscat']))
{
    $groupe = $_POST['nom_souscat'];
    $id = $_POST['id_souscat'];
  
    ($groupe, $id);
}

if( isset( $_POST['sup_cat']))
{
    $id = $_POST['id_cat'];
    $manager->supCat($id);
}

if( isset( $_POST['sup_souscat']))
{
    $id = $_POST['id_souscat'];
    $manager->supsousCat($id);
}

foreach($categories as $categorie) 
{
    ?>
    <form action="" method="POST">
    <input type="hidden" value="<?=$categorie['id']?>" name="id_cat">
    <input type="text" value="<?=$categorie['groupe']?>" name="nom_cat">
    <input class="btn btn-primary" type="submit" name="modif_cat" value="modifier">
    <input class="btn btn-danger" type="submit" name="sup_cat" value="supprimer">
    </form>
    <?php
    
    $ssc = $manager->sousCatAll($categorie['id']);

    echo "<ul>";
    foreach($ssc as $souscat)
    {
        ?>
        <li>
        <div class="input-group input-group-lg">
         <div class="input-group-prepend">
        <form action="" method="POST">
        <input type="hidden" class="form-control" value="<?=$souscat['id']?>" name="id_souscat">
        <input type="text" value="<?=$souscat['nomSousCat']?>" name="nom_souscat">
        <input class="btn btn-primary" type="submit" name="modif_souscat" value="modifier">
        <input class="btn btn-danger" type="submit" name="sup_souscat" value="supprimer">
        </form>
        </div>
        </div>
        </li>
        <?php        
    }
    echo "</ul>";
}


// foreach($categories as $categorie) 
// {
//     $ssc = $manager->sousCatAll($categorie['id']);
//     echo '<h3>'.$categorie['groupe'].'</h3><br>';
//     foreach($ssc as $souscat)
//     {
//         echo '--- '.$souscat['nomSousCat'].'<br>';
//     }
// }
?>
</div>
</body>
</html>