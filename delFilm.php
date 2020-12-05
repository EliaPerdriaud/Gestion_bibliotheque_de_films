<?php
require_once("./bdd.php");

if(isset($_GET['id'])){
    
    $query=$bddPDO->prepare('DELETE FROM film WHERE id = ?');
    $query->execute(array($_GET['id']));
    
    header("Location: ./index.php?statut=ok_supp");
}