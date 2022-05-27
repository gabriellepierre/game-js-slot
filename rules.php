<?php
  $page="rules";
  ini_set('display_errors', 1);
  include('connexionbdd.php');
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="assets/img/manchot.ico">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bandit Manchot - Règles</title>
  </head>
  <body>

    <?php
      include('navbar.php');
    ?>

    <main class="main-container">
      <h1>Les règles du bandit manchot</h1>
      <h2>Fonctionnement du jeu</h2>
      <p>Le bandit manchot (machine à sous) est un jeu de hasard et d'argent. Pour jouer, il vous suffit de cliquer sur le manche, ce qui lancera une partie. Les rouleaux vont commencer à tourner puis s'arrêter un à un, et le but est de tomber sur le même item à chaque rouleau. <br/>Selon l'item, vous gagnerez une certaine somme d'argent. L'item avec la probabilité de moins haute vous fera gagner le jackpot ! <br/>
      Une partie de niveau 1 vous coûtera 10 clochettes, c'est pourquoi vous avez 100 Clochettes dès votre arrivée sur le jeu. Le joueur a une probabilité de perdre bien plus haute que celle de gagner. C'est pour cette raison que le jeu se nomme ainsi : vous avez plus de chances de perdre de l'argent que d'en gagner, donc on qualifie le jeu de "bandit", et vous devez tirer un manche pour lancher une partie, d'où l'appellation "manchot". </p>

      <br/>
      
      <h2>Probabilités par niveau</h2>
      <p>Le niveau 1 : 
        <ul>
          <li>1 chance sur 1000 de faire le Jackpot</li>
          <li>5 chances sur 100 de tomber sur la pêche 3 fois</li>
          <li>17 chances sur 100 de tomber sur la cerise 3 fois.</li>
        </ul>
        <br/>
      Le niveau 2 :
        <ul>
          <li>1 chance sur 1000 de faire le Jackpot</li>
          <li>3 chances sur 1000 de tomber sur la pêche 3 fois</li>
          <li>9 chances sur 100 de tomber sur la cerise 3 fois</li>
          <li>17 chances sur 100 de tomber sur l'orange 3 fois.</li>
        </ul>
        <br/>
      Le niveau 3:
        <ul>
          <li>2.7 chances sur 10 000 de faire le Jackpot</li>
          <li>5.5 chances sur 10 000 de tomber sur la pêche 4 fois</li>
          <li>9.8 chances sur 1000 de tomber sur la cerise 4 fois</li>
          <li>17.5 chances sur 1000 de tomber sur l'orange 4 fois.</li>
        </ul>
        <br/>
        Le niveau 4:
        <ul>
          <li>1.4 chance sur 10 000 de faire le Jackpot</li>
          <li>16.3 chances sur 10 000 de tomber sur la pêche 4 fois</li>
          <li>5.5 chances sur 1000 de tomber sur la cerise 4 fois</li>
          <li>27.3 chances sur 1000 de tomber sur l'orange 4 fois.</li>
        </ul>
        </p>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
