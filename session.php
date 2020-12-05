<?php

    session_start();

    if(isset($_GET["statut2"])){

        $statut= $_GET["statut2"];


        if($_SESSION["connected"] == true) {

            if ($statut == 0){
                header("location:./formFilm.php?statut2=0");
            }

            if(isset($_GET["id"])){

                $id= $_GET["id"];

                if ($statut ==1){
                    header("location:./formFilm.php?statut2=1&id=".$id);
                }

                else if ($statut == 2){
                    header("location:./delFilm.php?id=".$id);
                }
            }
        }

        else {
            header("location:./formFilm.php?statut2=-1&error=1");
        }

    }
