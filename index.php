<?php
require_once("connexionbdd.php");?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Kati TChat</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="css/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <!--header-->
  <header>
    <?php require_once('header.php');?>
  </header>
  <div class="shad"></div>
  <!--contenu-->
<section id="accueil" class="main">
        <h2 class="insi">
            <span style="color:#ed1d8c">Kati</span><span style="color:#058bcb">TChat</span> est un espace de <span style="color:#ed1d8c">bonne humeur</span> pour dialoguer <span style="color:#058bcb">librement</span>,<br/>
            échanger des affinités et se <span style="color:#058bcb">rencontrer</span>.
        </h2>
        <p class="pin">
          Pas encore membre ?
          Inscrivez-vous gratuitement
        </p>
        <div class="bouton_inscription"><a class="bin" href="inscription.php">S'inscrire maintenant!</a> </div>   
      <!--  <nav>
            <ul class="menu">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="inscription.php">Inscription</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="service.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
   <img src="images/x6Mrl.gif"  />-->
   <div class="bolc_nbs">
        <div class="bloc_nb_v2">
            <div class="flt"><img src="images/ligne.png"  /></div>
            <div class="flt">
              <div class="nb_v2">
                  <?php
                  $nbconnect=$bdd->prepare("SELECT * FROM ip_adresse ");
                  $nbconnect->execute();
                  echo $nbconnect->rowCount();///afficher le nb connecté
                  ?>
              </div>
              <div style="padding-left: 10px; font-weight: 600;">En ligne</div>
            </div>  
        </div>
        <div class="bloc_nb_v2">
            <div class="flt"><img src="images/inscrit.png"  /></div>
            <div class="flt">
              <div class="nb_v2">
                  <?php
                  $nbconnect=$bdd->prepare("SELECT  * FROM utilisateur ");
                  $nbconnect->execute();
                  echo $nbconnect->rowCount();///afficher le nb connecté
                  ?>
              </div>
              <div style="padding-left: 10px; font-weight: 600;">Membres</div>
            </div>
        </div>
        <div class="bloc_nb_v2">
            <div class="flt"><img src="images/message.png"  /></div>
            <div class="flt">
              <div class="nb_v2">
                  <?php
                  $nbconnect=$bdd->prepare("SELECT  * FROM messagetable ");
                  $nbconnect->execute();
                  echo $nbconnect->rowCount();///afficher le nb connecté
                  ?>
              </div>
              <div style="padding-left: 10px; font-weight: 600;">Messages</div>
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