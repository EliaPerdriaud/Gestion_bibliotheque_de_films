<?php

    session_start();
    require_once("./bdd.php");

    if (isset($_SESSION['id']) AND isset($_SESSION['login'])){

        if ($_SESSION['connected']==true){
        $bonjour = 'Bonjour ' . $_SESSION['login'];
        }
    }
    function varDump($var){
        echo '<pre>', var_dump($var), '</pre>';
        return;
    }

    if (isset($_GET['statut'])){

        switch ($_GET['statut']) {
            case 'ok_ajout':
                $statut = "Le film a été créé !";
                break;
            case 'ok_supp':
                $statut = "La suppression a bien été effectuée !";
                break;
            case 'ok_modif':
                $statut = "La modification a bien été effectuée !";
                break;
            
            default:
            $statut = "erreur";
                break;
        }
    }



    $bddPDO=connectDb();

    $query=$bddPDO->prepare('SELECT * FROM film');
    $query->execute();
    
    
?>
    <html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <title> Films </title>
    </head>
        <body>
        <div class="statut">
            <?php if(isset($statut)) echo $statut;?>
        </div>

        <a href="session.php?statut2=0">
        <input class="bouton_add"
        type="button"
        value="Add Film"></a>

        <a href="inscription.php">
        <input class="bouton"
        type="button"
        value="Inscription"></a>

        <a href="connexion.php">
        <input class="bouton"
        type="button"
        value="Connexion"></a>

        <a href="deconnexion.php">
        <input class="bouton"
        type="button"
        value="Deconnexion"></a>

        <div class="bonjour">
            <?php if(isset($bonjour)) echo $bonjour;?>
        </div>  

            <table border=1>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>NOM</td>
                    <td>ANNEE</td>
                    <td>NOTE</td>
                    <td>NOMBRE DE VOTES</td>
                    <td>ACTION</td>
                </tr>
            </thead>
            <tbody>
            <?php while ($data=$query->fetch()){?>
                <tr>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['nom']; ?></td>
                <td><?php echo $data['annee']; ?></td>
                <td><?php echo $data['score']; ?></td>
                <td><?php echo $data['nbVotants']; ?></td>
                <td>
                    <a href="session.php?id=<?=$data['id']?>&amp;statut2=1">
                    <input class="bouton edit"
                    type="button"
                    value="Edit"></a>

                    <a href="session.php?id=<?=$data['id']?>&amp;statut2=2">
                    <input class="bouton delete"
                    type="button"
                    value="Delete">
                    </a>                    
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
        </body>
    </html>