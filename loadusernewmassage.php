<?php
require_once("connexionbdd.php");
if(isset($_SESSION['userid'])  && isset($_POST['id']))
{
    $messagerequette = $bdd->prepare("SELECT COUNT(*)FROM `messageprive` WHERE messageprive.id_emeteur=? and messageprive.id_recepteur =? and messageprive.etat=0");
    $messagerequette->execute([$_POST['id'],$_SESSION['userid']]);
    $count= $maxid=$messagerequette->fetch()[0];
    echo json_encode(['count'=>$count]);
}
