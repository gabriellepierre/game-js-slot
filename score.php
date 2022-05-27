<?php
  $page="";
  ini_set('display_errors', 1);
  include 'connexionbdd.php';
  session_start();
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- style -->
    <link rel="icon" type="image/png" href="assets/img/logo.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- titre -->
    <title>Bandit Manchot - Accueil</title>
  </head>

  <body>
<?php
//print_r($_SESSION['login']);
function ajout_score($score){
   
    include 'connexionbdd.php';
    //etape 1 recuperer le score
    $requete1 = $bdd->query("SELECT `score` FROM `utilisateur` WHERE `utilisateur`.`pseudo` = '".$_SESSION['login']."';");
    while ($data = $requete1->fetch())
	{
        $ancienScore = $data["score"];
    }
    $score += $ancienScore;
    $requete1->closeCursor();
    
    //etape 2 mettre a jour de score
    $requete2 = $bdd->query("UPDATE `utilisateur` SET `score` = '$score' WHERE `utilisateur`.`pseudo` = '".$_SESSION['login']."';");
    $requete2->closeCursor();
    $_SESSION['score'] = $score;

}

function enleve_score($score){
    include 'connexionbdd.php';
    //etape 1 recuperer le score
    $requete3 = $bdd->query("SELECT `score` FROM `utilisateur` WHERE `utilisateur`.`pseudo` = '".$_SESSION['login']."';");
    while ($data = $requete3->fetch())
	{
        $ancienScore = $data["score"];
    }
    $score = ($ancienScore-$score);
    $requete3->closeCursor();
    
    //etape 2 mettre a jour de score
    $requete4 = $bdd->query("UPDATE `utilisateur` SET `score` =  '$score'  WHERE `utilisateur`.`pseudo` = '".$_SESSION['login']."';");
    $requete4->closeCursor();
    $_SESSION['score'] = $score;

}
/*
if(isset($_GET["ajout_score"])) {ajout_score( $_GET["ajout_score"] );}
if(isset($_GET["enleve_score"])) {enleve_score( $_GET["enleve_score"] );}*/

if(isset($_POST["ajout_score"])) {ajout_score( $_POST["ajout_score"] );}
if(isset($_POST["enleve_score"])) {enleve_score( $_POST["enleve_score"] );}

/* LE test de fonctionnement
if(isset($_GET["ajout_score"])) {
    include 'connexionbdd.php';
    //etape 1 recuperer le score
    $requete1 = $bdd->query("SELECT `score` FROM `utilisateur` WHERE `utilisateur`.`pseudo` = '".$_SESSION['login']."';");
    while ($data = $requete1->fetch())
	{
        $ancienScore = $data["score"];
    }
    $score = $_GET["ajout_score"] + $ancienScore;
    $requete1->closeCursor();
    
    //etape 2 mettre a jour de score
    $requete2 = $bdd->query("UPDATE `utilisateur` SET `score` = '$score' WHERE `utilisateur`.`pseudo` = '".$_SESSION['login']."';");
    $requete2->closeCursor();
}*/
?>  
</body>
</html>