<?php
require_once("connexionbdd.php");
if(isset($_SESSION['userid'])) {
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
<script>
    $(document).ready(function() {



        function membermessage() {
            $('.membermessage').each(function() {
                var elem=this;
                $.post("loadusernewmassage.php", { 'id':elem.id},function( data ) {

                    $('#'+elem.id).html(' ('+data.count+')');

                }, "json");

            });

        }

        setInterval(membermessage, 5000);
    });
</script>
    <!--header-->
    <header>
        <?php require_once('header.php');?>
    </header>

    <!--contenu-->
    

    <section id="espace" class="main">


            <div class="dec">
                <a href="deconnexion.php">Déconnexion</a>
            </div>
            
            </br>


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
                <h2 class="titre_mem">Salon principal</h2>

                <form id="form_s" action="message_add.php" method="post">
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




                <?php
                if (isset($_GET['page']) && $_GET['page'] > 0)
                    $page = $_GET['page'];
                else
                    $page = 1;
                $nbmessagepage = 5;

                $messagerequette = $bdd->prepare("SELECT * FROM messagetable ORDER BY datecreate DESC ");
                $messagerequette->execute();
                $totalmessage = $messagerequette->rowCount();
                
                $nbpage = ceil($totalmessage / $nbmessagepage);
                $start = ($page - 1) * $nbmessagepage;
                
                
                $messagerequette = $bdd->prepare("SELECT * FROM messagetable ORDER BY datecreate DESC Limit $start,$nbmessagepage ");//recuperer 5 message
                $messagerequette->execute();
                $messages = $messagerequette->fetchAll();

                foreach ($messages as $message) {
                    ?>
                    <div class="row_tchat">

                        <div class="date_tchat">   
                            <?= $message['datecreate']; ?>
                        </div>
                        <div class="pseudo_tchat">
                            <?= $message['pseudo']; ?>
                        </div>
                        <div class="message_tchat">
                            <?= $message['message']; ?>
                        </div>
                        
                        <div style="clear: both"></div>
                    </div>
                    <?php
                }
                ?>
                <div class="page">

                    <?php

                        for ($i = 1; $i <= $nbpage; $i++) {
                            ?>
                            <a href='monespace.php?page=<?= $i ?>' style='padding:5px;'><?= $i ?></a>

                            <?php
                        }
                    ?>
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