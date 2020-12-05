<?php
    require_once('./bdd.php');
    session_start();

    if (isset ($_GET["error"])){

        $error = $_GET['error'];
        if ($error==1){
            $error = "Vous devez être connecté pour pouvoir effectuer cette action";
        }
    }

    if(isset($_GET['statut2'])){

        $statut = $_GET['statut2'];
        
        if(isset($_GET['id'])){
            $id_get = $_GET['id'];
        }
    }


    if($statut == 1 ){ // modification--------------------------
        $verif = $bddPDO->prepare('SELECT * FROM film WHERE id = ?');
        $verif->execute(array($id_get));

        $result = $verif->rowCount();

        if ($result == 1) {
            
            $query=$bddPDO->prepare("SELECT * from film where id = ?");
            $query->execute(array($id_get));
            $data=$query->fetch();

            $nom=$data['nom'];
            $annee=$data['annee'];
            $score=$data['score'];
            $nbVotants=$data['nbVotants'];

        }else{
            
            $error="erreur";
            //header('Location: ./../index.php');
        }

        if (isset($_POST['id'])) {
            if($_POST['id'] == $id_get){
                $query=$bddPDO->prepare('UPDATE film SET nom=?,annee=?,score=?, nbVotants=? WHERE id = ?');
                $query->execute(array($_POST['nom'], $_POST['annee'], $_POST['score'], $_POST['nbVotants'], $id_get));
                header('Location:./index.php?statut=ok_modif');
            }
            else{
                $query = $bddPDO->prepare('SELECT * FROM film WHERE id = ?');
                $query->execute(array($_POST['id']));
                $result=$query->rowCount();
                if ($result == 1) {
                    $error = "id utilisé";
                }
                else{
                    $query=$bddPDO->prepare('UPDATE film SET id = ?, nom=?,annee=?,score=?, nbVotants=? WHERE id = ?');
                    $query->execute(array($_POST['id'], $_POST['nom'], $_POST['annee'], $_POST['score'], $_POST['nbVotants'], $id_get));
                    header('Location:./index.php?statut=ok_modif');
                }
            }
        } 
    }
    else{ // creation ---------------------------------------------
        if (isset($_POST['id'])) {
            $verif = $bddPDO->prepare('SELECT * FROM film WHERE id = ?');
            $verif->execute(array($_POST['id']));

            $result = $verif->rowCount();

            if ($result == 1) {
                $error = "id utilisé";
            }else{
                $query=$bddPDO->prepare('INSERT INTO film(id,nom,annee,score, nbVotants) VALUES (?, ?, ?, ?, ?)');
                $query->execute(array($_POST['id'], $_POST['nom'], $_POST['annee'], $_POST['score'], $_POST['nbVotants']));
                $result = $query->rowCount();

                header('Location:./index.php?statut=ok_ajout');
            }
        }
    }




?>


<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title> <?php if($statut == 0) echo"Creation film"; else echo"Modification film";?></title>
    </head>
    <body>
        <div class="erreur">
            <p>
                <?php if(isset($error)) echo $error;?>
                <a href="./index.php">
                <input class="bouton retour" type="button" value="Retour"></a>
            </p>
        </div>

    <?php if($statut == 1){ //modif------------------?> 
        <form action="" class="form" method="post">
            <div>
                <label for="id">id :</label>
                <input type="number" id="id" name="id" value="<?php if(isset($_POST['id'])) echo($_POST['id']); else echo $id_get;?>">
            </div>
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php if(isset($_POST['nom'])) echo($_POST['nom']); else echo $nom;?>">
            </div>
            <div>
                <label for="annee">Annee :</label>
                <input type="number" id="annee" name="annee" value="<?php if(isset($_POST['annee'])) echo($_POST['annee']); else echo $annee;?>">
            </div>
            <div>
                <label for="score">Score :</label>
                <input type="number" id="score" name="score" step="0.1" value="<?php if(isset($_POST['score'])) echo($_POST['score']); else echo $score;?>">
            </div>  
            <div>
                <label for="nbVotants">Nombre de votants :</label>
                <input type="number" id="nbVotants" name="nbVotants" value="<?php if(isset($_POST['nbVotants'])) echo($_POST['nbVotants']); else echo $nbVotants;?>"">
            </div> 
            <div>
                <input class="bouton ok" type="submit" value="OK"> 
            </div>
        </form>
        <?php }
        else if ($statut==0) { // création ---------------------?>
        <form action="" class="form" method="post">
            <div>
                <label for="id">id :</label>
                <input type="number" id="id" name="id" value="<?php if(isset($_POST['id'])) echo($_POST['id']);?>"> 
            </div>
            <div>
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" value="<?php if(isset($_POST['nom'])) echo($_POST['nom']);?>" >
            </div>
            <div>
                <label for="annee">Annee :</label>
                <input type="number" id="annee" name="annee" value="<?php if(isset($_POST['annee'])) echo($_POST['annee']);?>">
            </div>
            <div>
                <label for="score">Score :</label>
                <input type="number" id="score" name="score" step="0.1" value="<?php if(isset($_POST['score'])) echo($_POST['score']);?>">
            </div>  
            <div>
                <label for="nbVotants">Nombre de votants :</label>
                <input type="number" id="nbVotants" name="nbVotants" value="<?php if(isset($_POST['nbVotants'])) echo($_POST['nbVotants']);?>">
            </div> 
            <div>
                <input class="bouton ok" type="submit" value="OK"> 
            </div>
        </form>
    </body>
    <?php }?>
</html>