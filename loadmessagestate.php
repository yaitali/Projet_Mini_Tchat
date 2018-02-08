<?php
require_once("connexionbdd.php");
if(isset($_SESSION['userid'])  && isset($_POST['id']))
{
    $messagerequette = $bdd->prepare("SELECT etat FROM `messageprive` WHERE messageprive.id_emeteur=? and messageprive.id =? ");
    $messagerequette->execute([$_SESSION['userid'],$_POST['id']]);
    $etat = $maxid=$messagerequette->fetch()[0];
    echo json_encode(['etat'=>$etat]);
}
