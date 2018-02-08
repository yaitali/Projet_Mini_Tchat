<div class="row-header">
    <div class="main">
        <h1 class="logo">
            <a href="index.php">
              <img src="images/logo.png"/>
              <div class="clr"></div>
              <span class="rose">Kati</span><span class="bleu">TChat</span>
            </a>
        </h1>
        <!--<div class="bloc_nb_v">
            <div style="float: left;">Nombre d'inscrits : </div>
            <div class="nb_v">
                <?php
                $nbconnect=$bdd->prepare("SELECT  * FROM utilisateur ");
                $nbconnect->execute();
                echo $nbconnect->rowCount();///afficher le nb connecté
                ?>
            </div>
        </div>
        <div class="bloc_nb_v">
            <div style="float: left;">Messages sur le forum principal : </div>
            <div class="nb_v">
                <?php
                $nbconnect=$bdd->prepare("SELECT  * FROM messagetable ");
                $nbconnect->execute();
                echo $nbconnect->rowCount();///afficher le nb connecté
                ?>
            </div>
        </div>-->
        <div class="bloc_nb_v">
            <div style="float: left;">En ligne : </div>
            <div class="nb_v">
                <?php
                $nbconnect=$bdd->prepare("SELECT * FROM ip_adresse ");
                $nbconnect->execute();
                echo $nbconnect->rowCount();///afficher le nb connecté
                ?>
            </div>
        </div>
        <div class="connexion">
            
            <br/>
              <?php
              if(!isset($_SESSION['userid']))
              {
              ?>
                <span style="padding-right: 277px;font-size: 14px;color: #faf9fa;">
                  Déjà membre ?
                </span>
                  <form id="form_s" action="connexion.php" method="post">
                      <input name="pseudo" type="text"  placeholder="Pseudo">
                      <input name="mot_passe" type="password" placeholder="Mot de passe">
                      <input name="connexionsubmit" type="submit" value="OK">
                  </form>
              <?php
              }
              else
              {
                  echo' <a href="monespace.php">'.$_SESSION['pseudo'].'</a>';
              }
              ?>
        </div>
        <div class="clr"></div>
    </div>
</div>
