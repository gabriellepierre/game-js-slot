<?php
$page = 'edit';
ini_set('display_errors', 1);
include('connexionbdd.php');
session_start();


if (isset($_SESSION['login'])) {
    $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE pseudo = ?");
    $requser->execute(array($_SESSION['login']));
    $user = $requser->fetch();

    $_SESSION['id'] = $user['id'];

    $requser->closeCursor();

    if (isset($_POST['nouveau_pseudo']) AND !empty($_POST['nouveau_pseudo'])) {


        $pseudo = strip_tags((String) $_POST['nouveau_pseudo']);
        $req = $bdd->prepare('SELECT pseudo FROM utilisateur WHERE pseudo=?');
        $req->execute(array($pseudo));
        if ($donnees = $req ->fetch())
        {
            $_SESSION['msg_pseudo_unavailable_2'] = '<div class="msg_pseudo_unavailable w-100 text-center">Il y a déjà une personne qui utilise ce pseudo !</div>';
        }
        else {
            $newpseudo = strip_tags((String) $_POST['nouveau_pseudo']);
            $insertpseudo = $bdd->prepare("UPDATE utilisateur SET pseudo = ? WHERE id=?");
            $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
            $insertpseudo->closeCursor();

            $new = $bdd->prepare("SELECT pseudo FROM utilisateur WHERE id=?");
            $new->execute(array($_SESSION['id']));
            $result = $new->fetch();
            $_SESSION['login'] = $result['pseudo'];
            $new->closeCursor();

            header('Location: index.php');
        }

    }

    if (isset($_FILES['nouveau_avatar']) AND !empty($_FILES['nouveau_avatar']['name'])) {
        $nouvelle_img = file_get_contents($_FILES['nouveau_avatar']['tmp_name']);
        $requeteImage = $bdd->prepare('UPDATE utilisateur SET img = :nouvelle_image WHERE pseudo = :pseudo');
        $requeteImage->execute(array(
            'pseudo' 			=> $_SESSION['login'],
            'nouvelle_image'=> $nouvelle_img
        ));
        $requeteImage->closeCursor();
    }

    if (isset($_POST['account_del'])) {
        $drop_user = $bdd->prepare('DELETE FROM utilisateur WHERE pseudo = ?');
        $drop_user->execute(array($_SESSION['login']));
        $drop_user->closeCursor();
        header('Location: logout.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="assets/img/logo.png"/>
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bandit Manchot - Modifier mon profil</title>
</head>

<body>
    <?php
        include('navbar.php');
    ?>


    <main>
        <section class="d-flex flex-column edit-section justify-content-center align-items-center">
            <h1 class="w-100 text-center">Modifier mon profil</h1>
            <form method="post" class="edit-form" enctype="multipart/form-data">
                <label for="nouveau_pseudo">Pseudo : </label>
                <input class="change-name" type="text" name="nouveau_pseudo" placeholder="<?php echo $_SESSION['login'] ?>">
                <br>
                <?php
                    if (isset($_SESSION['msg_pseudo_unavailable_2'])) {
                        echo $_SESSION['msg_pseudo_unavailable_2'];
                    }
                ?><br>
                <label for="nouveau_avatar">Avatar : </label>
                <input class="file" type="file" name="nouveau_avatar">
                <br><br>
                <input class="btn btn-edit-profile" type="submit" value="Modifier mon profil">
                <input class="btn btn-delete-account" type="submit" name="account_del" value="Supprimer mon compte">
                <a href="index.php" class="btn btn-back-home">Retourner à l'accueil</a>


            </form>

            <form method="post">
            </form>
        </section>
    </main>

</body>

</html>

<?php
    }
    else {
        header('Location: index.php');
    }
?>