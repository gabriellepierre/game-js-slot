<?php
  $page="home";
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
    
    if (isset($_POST['jouer'])) {
        if (isset($_POST['login'])) {
            $_SESSION['login'] = strip_tags((String) $_POST['login']); //Sécurisation du pseudo

            if ($_SESSION['login'] != "") {
        
                $exists = false;

                $requeteScore = $bdd->prepare('SELECT pseudo, score FROM utilisateur WHERE pseudo = ?');
                $requeteScore->execute(array($_SESSION['login']));
                
                while ($data = $requeteScore->fetch()) {
                    if ($_SESSION['login'] == $data['pseudo']) {
                        $exists=true;
                        $_SESSION['score'] = $data['score'];
                    } 
                }

                $requeteScore->closeCursor();

                /*if (!$exists) {
                    $requeteEcriturePseudo=$bdd->prepare('INSERT INTO utilisateur (pseudo, score) VALUES (:pseudo, :score)');
                    $requeteEcriturePseudo->execute(array(
                    'pseudo' => $_SESSION['login'],
                    'score' => 100,
                    ));
                    $requeteEcriturePseudo->closeCursor();
                    $requetePseudoCree = $bdd->prepare('SELECT pseudo, score FROM utilisateur WHERE pseudo = ?');
                    $requetePseudoCree->execute(array($_SESSION['login']));
                
                    while ($data = $requetePseudoCree->fetch()) {
                        if ($_SESSION['login'] == $data['pseudo']) {
                            $exists=true;
                            $_SESSION['score'] = $data['score'];
                        } 
                    }

                    $requetePseudoCree->closeCursor();
                } */
                if (isset($_POST['newuser_pseudo']) && !empty($_POST['newuser_pseudo'])) {
                    $pseudo = strip_tags((String) $_POST['newuser_pseudo']);
                    $req = $bdd->prepare('SELECT pseudo FROM utilisateur WHERE pseudo=?');
                    $req->execute(array($pseudo));
                    if ($donnees = $req ->fetch())
                    {
                        $_SESSION['msg_pseudo_unavailable'] = '<div class="msg_pseudo_unavailable w-100 text-center">Il y a déjà une personne qui utilise ce pseudo !</div>';
                        header('Location: index.php');
                    }
                    else {
                        if (isset($_FILES['img']['tmp_name']) AND !empty($_FILES['img']['tmp_name'])){
                            $img_blob = file_get_contents($_FILES['img']['tmp_name']);
                        }
                        else {
                            $img_blob = file_get_contents('assets/img/default.png');
                        }
                        $_SESSION['login'] = $pseudo;
                        $insert_pseudo=$bdd->prepare('INSERT INTO utilisateur (pseudo, score, img) VALUES (:pseudo, :score, :image)');
                        $insert_pseudo->execute(array(
                            'pseudo' => $_SESSION['login'],
                            'score' => 100,
                            'image' => $img_blob,
                        ));
                        $insert_pseudo->closeCursor();
        
                        $reload_pseudo = $bdd->prepare('SELECT pseudo, score FROM utilisateur WHERE pseudo = ?');
                        $reload_pseudo->execute(array($_SESSION['login']));
        
                        while ($data = $reload_pseudo->fetch()) {
                            if ($_SESSION['login'] == $data['pseudo']) {
                                $_SESSION['score'] = $data['score'];
                            }
                        }
        
                        $reload_pseudo->closeCursor();
                    }
                }
        
            }
        } 
    }
    
    include('navbar.php');
    if (!isset($_SESSION['login'])) {
    ?>
        <main class=" d-flex flex-column align-items-center justify-content-center">
        <section id="login-section" class="play d-flex justify-content-center align-items-center">
          <h1 class="login-title">Connectes-toi pour jouer !</h1>
          <form id="form" action="index.php" method="POST">
            <div id="msgPseudo"></div>
            <input id="pseudo" type="text" placeholder="Pseudo" name="login" required>
            <input class="btn btn-login-submit btn-primary-outline" type="submit" value="Jouer !" name="jouer"></input>
          </form>
        </section>
        <div class="custom-shape-divider-top-1639870130">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M1200 120L0 16.48 0 0 1200 0 1200 120z" class="shape-fill"></path>
            </svg>
        </div>
        <section class="signin d-flex justify-content-center align-items-center">
            <form enctype="multipart/form-data" class="d-flex flex-wrap justify-content-center align-items-start" action="index.php" method="POST">
                <h1 class="signin-title text-center">Ou inscris toi !</h1>
                <div class="d-flex justify-content-center form-sign">
                    <label for="newuser_pseudo">Choisis un pseudo :
                        <br><br>
                        <input type="text" name="newuser_pseudo" placeholder="Pseudo" required>
                    </label>
                    <label for="img">Choisis un avatar :
                        <br><br>
                        <input class="file" type="file" name="img">
                    </label>
                    <input class="btn btn-signin-submit btn-primary-outline" type="submit" value="S'inscrire">
                </div>
            </form>
            <?php
            if (isset($_SESSION['msg_pseudo_unavailable'])){
                echo $_SESSION['msg_pseudo_unavailable'];
            }
            ?>
        </section>
    </main>
    <?php
    } else {
    ?>
    <main class="main-container-jeu d-flex flex-column align-items-center justify-content-center">
        <h1 class="text-center pb-5">Bandit Manchot !</h1>
        <div class="w-50 game flex-fill d-flex justify-content-center">
        <span class="align-self-center">
          <div id="formChoixNiveau" > <!-- method="POST"> -->
            <select id="choixNiveau" type="select" name="chxNiveau">
                <label>Quel niveau de difficulté ?</label>
                <option value="1" selected="selected">Niveau 1</option>
                <option value="2">Niveau 2</option>
                <option value="3">Niveau 3</option>
                <option value="4">Niveau 4</option>
            </select>
            <button id="choixNiveauButton" ><!-- type="submit"> -->Valider</button>
          </div>
          <p id="reponseChoix"></p>

          <div id="banditLvl1Container" class="banditContainerNone">
              <div id="banditLvl1Corps">
                  <div id="banditLvl1Rouleau1">
                      <div class="rouleau1 rouleau1Anim">
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <!-- retour -->
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el04"></span>
                      </div>
                  </div>
                  <div id="banditLvl1Rouleau2">
                      <div class="rouleau2 rouleau2Anim">
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <!-- retour -->
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                      </div>
                  </div>
                  <div id="banditLvl1Rouleau3">
                      <div class="rouleau3 rouleau3Anim">
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <!-- retour -->
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el02"></span>
                      </div>
                  </div>  
              </div>
              <div id="banditLvl1AnimePieces"></div>
              <div id="banditLvl1Manche"></div>
              <span id="choixIcons">Icons personnages</span>
              <span class="fenteAPiece1"><span></span></span>
          </div> <!-- end of .banditLvl1Container -->

          <div id="banditLvl2Container" class="banditContainerNone">
              <div id="banditLvl2Corps">
                  <div id="banditLvl2Rouleau1">
                      <div class="rouleau1 rouleau1Anim">
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el03"></span>
                          <!-- retour -->
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el04"></span>
                      </div>
                  </div>
                  <div id="banditLvl2Rouleau2">
                      <div class="rouleau2 rouleau2Anim">
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el02"></span>
                          <!-- retour -->
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el02"></span>
                      </div>
                  </div>
                  <div id="banditLvl2Rouleau3">
                  <div class="rouleau3 rouleau3Anim">
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el04"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el03"></span>
                          <span class="r1els r1el02"></span>
                          <span class="r1els r1el01"></span>
                          <!-- retour -->
                          <span class="r1els r1el01"></span>
                          <span class="r1els r1el03"></span>
                      </div>
                  </div>  
              </div>
              <div id="banditLvl2AnimePieces"></div>
              <div id="banditLvl2Manche"></div>
              <span id="choix2Icons">Icons personnages</span>
              <span class="fenteAPiece1"><span></span></span>
          </div> <!-- end of .banditLvl2Container -->

          <div id="banditLvl3Container" class="banditContainerNone">
              <div id="banditLvl3Corps">
                  <div id="banditLvl3Rouleau1">
                      <div class="rouleau1 rouleau1Anim">
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>
                  <div id="banditLvl3Rouleau2">
                      <div class="rouleau2 rouleau2Anim">
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>
                  <div id="banditLvl3Rouleau3">
                      <div class="rouleau3 rouleau3Anim">
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>  
                  <div id="banditLvl3Rouleau4">
                      <div class="rouleau4 rouleau4Anim">
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div> 
              </div>
              <div id="banditLvl3AnimePieces"></div>
              <div id="banditLvl3Manche"></div>
              <span id="choix3Icons">Icons personnages</span>
              <span class="fenteAPiece2"><span></span></span>
          </div> <!-- end of .banditLvl3Container -->

          <div id="banditLvl4Container" class="banditContainerNone">
              <div id="banditLvl4Corps">
                  <div id="banditLvl4Rouleau1">
                      <div class="rouleau1 rouleau1Anim">
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>
                  <div id="banditLvl4Rouleau2">
                      <div class="rouleau2 rouleau2Anim">
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>
                  <div id="banditLvl4Rouleau3">
                      <div class="rouleau3 rouleau3Anim">
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>  
                  <div id="banditLvl4Rouleau4">
                      <div class="rouleau4 rouleau4Anim">
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <span class="r1els r1el13"></span>
                          <span class="r1els r1el12"></span>
                          <span class="r1els r1el11"></span>
                          <!-- retour -->
                          <span class="r1els r1el14"></span>
                          <span class="r1els r1el13"></span>
                      </div>
                  </div>  
              </div>
              <div id="banditLvl4AnimePieces"></div>
              <div id="banditLvl4Manche"></div>
              <span id="choix4Icons">Icons personnages</span>
              <span class="fenteAPiece2"><span></span></span>
          </div> <!-- end of .banditLvl4Container -->

          <div>
              <h1 id="resultat"></h1>
          </div>
          <p id="messageErreur"></p>
          <span id="scoreRe" class="score">Score : <h1><?php echo $_SESSION['score'];  ?></h1></span>
          <div id="explications">
              <div><p>100 clochettes</p><span  class="explic r1el01"></span></div>
              <div><p>250 clochettes</p><span  class="explic r1el02"></span></div>
              <div><p>500 clochettes</p><span  class="explic r1el03"></span></div>
              <div><p>1000 clochettes</p><span  class="explic r1el04"></span></div>
          </div>
        </span>
      </div>
      
      <!-- scripts -->    
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
      <!-- JS -->
      <script src="assets/js/script.js" async></script>
    </main>
    <?php
      }
    ?>
    <ul class="circles">
      <li><img src="https://cdn-icons-png.flaticon.com/512/247/247837.png" width="60" height="60"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/218/218362.png" width="25" height="25"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/247/247814.png" width="50" height="50"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/218/218362.png" width="100" height="100"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/247/247814.png" width="100" height="100"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/247/247837.png" width="75" height="75"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/247/247814.png" width="150" height="150"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/218/218362.png" width="200" height="200"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/247/247837.png" width="25" height="25"/></li>
      <li><img src="https://cdn-icons-png.flaticon.com/512/218/218362.png" width="50" height="50"/></li>
    </ul>

      <!-- scripts -->    
      <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- scripts
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>