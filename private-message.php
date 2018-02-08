<?php
require_once("connexionbdd.php");
if(isset($_SESSION['userid']) && isset($_GET['userid'])) 
{
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Mini Chat</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <script src="js/jquery-3.1.1.js"></script>
</head>

<body>
<?php
$messagerequette = $bdd->prepare("SELECT max(id) FROM `messageprive` WHERE (`id_emeteur`=? or `id_emeteur`=?)and(`id_recepteur`=? or `id_recepteur`=?) ORDER BY datecreate DESC");
$messagerequette->execute([$_SESSION['userid'],$_GET['userid'],$_SESSION['userid'],$_GET['userid']]);
$maxid=$messagerequette->fetch()[0];
if($maxid==null)
    $maxid=0;

?>
    <script>
        $(document).ready(function() {
        var maxid=<?= $maxid?>;
        function loadmessage() {
            $.post("loadprivatemessage.php", {'userid':<?= $_GET['userid']?>, 'id':maxid},function( data ) {
                if(data.max!=null){
                    maxid=data.max;

                    $( "#messagelist" ).prepend( data.content);
                    $("#toscroll").animate({ scrollTop: 0}, 1000);
                }
            }, "json");
        };

        function loadmessagesate() {
            $('.nonlu').each(function() {
                var elem=this;
                $.post("loadmessagestate.php", {'userid':<?= $_GET['userid']?>, 'id':elem.id},function( data ) {
                    if (data.etat==1)
                       $('#'+elem.id).removeClass("nonlu");

                }, "json");

            });

        }

        function membermessage() {
            $('.membermessage').each(function() {
                var elem=this;
                $.post("loadusernewmassage.php", { 'id':elem.id},function( data ) {

                       $('#'+elem.id).html(' ('+data.count+')');

                }, "json");

            });

        }
        setInterval(loadmessage, 4000);
        setInterval(loadmessagesate, 5000);
        setInterval(membermessage, 5000);
});
    </script>

    <!--header-->
    <header>
        <?php require_once('header.php');?>
    </header>

    <!--contenu-->
    

    <section id="espace_prive" class="main">


            <div class="dec">
                <a href="deconnexion.php">Déconnexion</a>
            </div>

            </br><br/><br/>
             
             <div class="row_membre">
                <h2 class="titre_mem">Membres</h2>
                <div class="mem"><a href="monespace.php">Salon principal</a></div>
                <?php 

                    $membrerequette = $bdd->prepare("SELECT * FROM utilisateur where id<>? ORDER BY pseudo asc ");
                    $membrerequette->execute([$_SESSION['userid']]);
                    $membres=$membrerequette->fetchAll();
                    foreach ($membres as $membre) {
                      echo  '<div ><a href="private-message.php?userid='.$membre['id'].'">'.$membre['PSEUDO'].'<span class="membermessage" id="'.$membre['id'].'"></span></a></div>';
                    }


                ?>
            </div>

            <div class="tchat">
                <?php 
                    $personerequett = $bdd->prepare("SELECT * FROM utilisateur where id=? ");
                    $personerequett->execute([$_GET['userid']]);
                    $membres=$personerequett->fetch();?>
                <h2 class="titre_mem">Espace privé <?= $membres['PSEUDO'];?> </h2>


                <form id="form_s" action="messageprivate_add.php?userid=<?= $_GET['userid']?>" method="post">
                    <div class="tchat_pseu">
                        <input name="pseudo" type="text" placeholder="" value="<?= $_SESSION['pseudo'] ?>">
                    </div>
                    <div class="tchat_text">
                        <textarea name="message" cols="30" rows="5"></textarea>
                    </div>
                    <div class="clr"></div>
                    <div class="tchat_env">
                        <input name="envoiemessage" type="submit" value="Envoyer">
                    </div>
                </form>


                <div id="toscroll" style="height: 350px; overflow: auto">
                    <div id="messagelist" >

                        <?php
                        $messageread = $bdd->prepare("update `messageprive` set etat=true WHERE ( messageprive.id_emeteur=?)and( messageprive.id_recepteur=?)");
                        $messageread->execute([$_GET['userid'],$_SESSION['userid']]);
                        $messagerequette = $bdd->prepare("SELECT *,messageprive.id as messageid FROM `messageprive`, `utilisateur` WHERE (messageprive.id_emeteur=? or messageprive.id_emeteur=?)and(messageprive.id_recepteur=? or messageprive.id_recepteur=?) and messageprive.id_emeteur=utilisateur.id ORDER BY datecreate DESC");
                         $messagerequette->execute([$_SESSION['userid'],$_GET['userid'],$_SESSION['userid'],$_GET['userid']]);

                        $messages = $messagerequette->fetchAll();

                        foreach ($messages as $message) {

                            ?>
                            <div class="row_tchat"  data_id="<?= $message['messageid']?>" datauser="<?= $message['id_emeteur']?>">

                                <div class="date_tchat">  
                                    <?= $message['datecreate']; ?>
                                </div>

                                <div class="pseudo_tchat">
                                    <?= $message['PSEUDO']; ?>

                                </div>                              

                                <div class="message_tchat <?php if ($message['id_emeteur']==$_SESSION['userid'] && !$message['etat']) echo 'nonlu';?>" id="<?= $message['messageid']?>">
                                    <?= $message['message']; ?>
                                </div>

                                <div style="clear: both"></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>


                
            
            </div>

             

    </section>
    <div class="clr"></div>
    <div class="shad"></div>

    <!--footer-->
    <footer id="footer">
      <?php require_once('footer.php');?>
    </footer>
</body>
</html>

    <?php
        }else{
        header("location:index.php");
    }
    ?>