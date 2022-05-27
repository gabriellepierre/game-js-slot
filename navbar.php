<nav class="fixed-top navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">
    <img class="img-fluid" src="assets/img/manchot.png" alt="Logo" height="50" width="50">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item">

        <a class=
          <?php
            if($page=='home'){
          ?>
              "nav-link active"
          <?php
            }
            else {
          ?>
              "nav-link"
          <?php
            }
          ?>
          href="index.php"><i class="fas fa-coins"></i> Jouer
        </a>
      </li>

      <li class="nav-item">
        <a class=
          <?php
            if($page=='rules'){
          ?>
              "nav-link active"
          <?php
            }
            else {
          ?>
              "nav-link"
          <?php
            }
          ?>
          href="rules.php"><i class="fas fa-file-alt"></i> Règles
        </a>
      </li>

      <li class="nav-item">
        <a class=
          <?php
            if($page=='credits'){
          ?>
              "nav-link active"
          <?php
            }
            else {
          ?>
              "nav-link"
          <?php
            }
          ?>
          href="credits.php"><i class="fas fa-info-circle"></i> Crédits
        </a>
      </li>
    </ul>
    <?php
      if (isset($_SESSION['login'])) {
        $requete = $bdd -> prepare('SELECT img FROM utilisateur WHERE pseudo = ?');
        $requete->execute(array($_SESSION['login']));

        while ($data = $requete->fetch()) {
            if($data["img"] != "") {
                $file = '<img src="data:image/jpeg;base64,' . base64_encode($data["img"]) . '" height="50" width="50" alt=""/>';
            }
            else {
                 $file = '<img src="assets/img/default.png" height="50" width="50" alt=""/>';
            }
        }
        if ($page == 'home') {
           echo '<ul class="account navbar-nav flex-fill justify-content-end align-items-center">
              ' . $file . '
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  ' . $_SESSION['login'] . '
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <div class="d-flex flex-column">
                    <a class="w-100 btn btn-logout btn-primary-outline" href="edit.php">Modifier mon profil</a></span>
                    <a href="logout.php" class="w-100 btn btn-logout btn-primary-outline">Me déconnecter</a>
                  </div>
                </div>
              </li>
            </ul>';
        }
        $requete->closeCursor();
    }  ?>
  </div>
</nav>
