<?php
    require_once('./bdd.php');

//inscription

if (isset($_POST['login'])) {
    $login=($_POST['login']);
    $verif = $bddPDO->prepare('SELECT * FROM user WHERE login = ?');
    $verif->execute(array($login));

    $result = $verif->rowCount();

    if ($result == 1) {
        $error = "login déjà utilisé";
    }

    else{
        $pwd=($_POST['pwd']);
        $pwdBis=($_POST['pwdBis']);

        if ($pwd != $pwdBis) {
            $error ="Vous devez saisir le même mot de passe";
        }

        else{
            $req = $bddPDO->prepare('INSERT INTO user(login, pwd, email) VALUES(?, ?, ?)');
            $req->execute(array($_POST['login'], $_POST['pwd'], $_POST['email']));
        }
    }
}


 
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title> Inscription</title>
    </head>
    <body>
        <div class="erreur">
            <p>
                <?php if(isset($error)) echo $error;?>
                <a href="./index.php">
                <input class="bouton retour" type="button" value="Retour"></a>
            </p>
        </div>
        
        <p>
            <?php if(isset($error)) echo $error;?>
        </p>
        <form action="" class="form" method="post">
            <div>
                <label for="login">login :</label>
                <input type="text" id="login" name="login" >
            </div>
            <div>
                <label for="pwd">Mot de passe :</label>
                <input type="password" id="pwd" name="pwd" >
            </div>
            <div>
            <label for="pwdBis">Retapez votre mot de passe :</label>
            <input type="password" id="pwdBis" name="pwdBis" >
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="text" id="email" name="email" >
            </div>  
            <div>
                <input class="bouton inscription" type="submit" value="S'inscrire"> 
            </div>
        </form>
    </body>
</html>



    