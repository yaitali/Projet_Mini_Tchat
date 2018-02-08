<?php
require_once("connexionbdd.php");
if(isset($_SESSION['userid']) && isset($_POST['userid'])  && isset($_POST['id']))
{
    $messageread = $bdd->prepare("update `messageprive` set etat=true WHERE ( messageprive.id_emeteur=?)and( messageprive.id_recepteur=?)");
    $messageread->execute([$_POST['userid'],$_SESSION['userid']]);
    $messagerequette = $bdd->prepare("SELECT * ,messageprive.id as messageid FROM `messageprive`, `utilisateur` WHERE (messageprive.id_emeteur=? or messageprive.id_emeteur=?)and(messageprive.id_recepteur=? or messageprive.id_recepteur=?) and messageprive.id_emeteur=utilisateur.id and messageprive.id >? ORDER BY datecreate DESC");
    $messagerequette->execute([$_SESSION['userid'],$_POST['userid'],$_SESSION['userid'],$_POST['userid'],$_POST['id']]);
    $messages = $messagerequette->fetchAll();
    $out='';
    foreach ($messages as $message) {

         $out.='<div class="row_tchat">

                                <div class="date_tchat">'.  
                                     $message['datecreate']
                                .'</div>

                                <div class="pseudo_tchat';
        if ($message['id_emeteur']==$_SESSION['userid'] && !$message['etat'])
            $out.= ' nonlu';

        $out.='" id="'.$message['messageid'].'">'.
                                     $message['PSEUDO']
                                .'</div>                              

                                <div class="message_tchat">'.
                                     $message['message']
                                .'</div>

                                <div style="clear: both"></div>
                            </div>';
    }


    $messagerequette = $bdd->prepare("SELECT max(id) FROM `messageprive` WHERE (`id_emeteur`=? or `id_emeteur`=?)and(`id_recepteur`=? or `id_recepteur`=?)and messageprive.id >?");
    $messagerequette->execute([$_SESSION['userid'],$_POST['userid'],$_SESSION['userid'],$_POST['userid'],$_POST['id']]);
    $maxid=$messagerequette->fetch()[0];

    echo json_encode(['max'=>$maxid,'content'=>$out]);


}
?>