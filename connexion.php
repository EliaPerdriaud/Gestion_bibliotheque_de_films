<?php
    require_once('./bdd.php');

//Connexion

if (isset($_POST['login'])) {
    $login=($_POST['login']);
    $req = $bddPDO->prepare('SELECT * FROM user WHERE login = ?');
    $req->execute(array($login));

    $result = $req->fetch();

    $pwd=($_POST['pwd']);
    $pwdBis=($_POST['pwdBis']);

    if ($pwd != $pwdBis) {
        $error ="Vous devez saisir le même mot de passe";
    }
    
    else{

        if ($pwd != $result['pwd']) {

            $error="Mot de passe incorect";
        }

        else{

            if ($login != $result['login']) {
                $error="Login incorect";
            }

            else {
                session_start();
                $_SESSION['id'] = $result['id'];
                $_SESSION['login'] = $result['login'];
                $_SESSION['connected'] =true;
                echo 'Vous êtes connecté !';

                header('location: ./index.php');
            }
        }

    }
}


 
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title> Connexion </title>
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
                <input class="bouton connexion" type="submit" value="Connexion"> 
            </div>
        </form>
    </body>
</html>



    