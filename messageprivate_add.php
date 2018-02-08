<?php
require_once("connexionbdd.php");
if(isset($_SESSION['userid'])&& isset($_GET['userid'])) {
    if(isset($_POST['envoiemessage']) && !empty($_POST['message']))
    {
        $message=htmlentities($_POST['message']) ;
        $date = date("Y-m-d H:i:s");
        $newmessage=$bdd->prepare("INSERT INTO messageprive (id_emeteur,id_recepteur,datecreate,message,etat)VALUES(?,?,?,?,false)");
        $newmessage->execute(array($_SESSION['userid'],$_GET['userid'],$date,$message));

    }
    header("location:private-message.php?userid=".$_GET['userid']);
}else{
    header("location:index.php");
}