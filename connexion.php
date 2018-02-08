<?php
require_once("connexionbdd.php");

if(isset($_POST['connexionsubmit']) )
{
    if(!empty($_POST['pseudo'])&&!empty($_POST['mot_passe']))
    {
        $pseudo=$_POST['pseudo'];
        $mot_passe=sha1($_POST['mot_passe']);//hach�e le mot de passe(cript�)
        
        $utilisateurexist=$bdd->prepare("SELECT * FROM utilisateur WHERE  PSEUDO= '".$pseudo."' && MOT_PASSE='".$mot_passe."' ");
        $utilisateurexist->execute();
          
        if($utilisateurexist->rowCount()>0)
        {

            $utilisateur=$utilisateurexist->fetchObject();
            $_SESSION['userid']=$utilisateur->id;
            $_SESSION['pseudo']=$utilisateur->PSEUDO;
            $_SESSION['userpass']=$utilisateur->MOT_PASSE;
            header("Location:monespace.php");

        }else{
            $erreur="Invalide nom d'utilisateur ou mot de passe";
        }
    }
    else
    {
        $erreur='Veuillez saisir le login ou mot de passe';
    }

}
?>
<html lang="fr">
<head>
    <title>Mini Chat</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
  
</head>

<body>

<!--header-->
  <header>
    <?php require_once('header.php');?>
  </header>



<!--contenu-->

<section id="connexion" class="main">
    <h2 class="titre_registre" >Connexion</h2>
    <br/>
    <?php
    if (isset($erreur))
    {
        echo'<font color = "red">'.$erreur."</font>";
    }
    ?>


    <form id="form_s" action="connexion.php" method="post">
        <input name="pseudo" type="text"  placeholder="Pseudo">
        <input name="mot_passe" type="password" placeholder="Mot de passe">
        <input name="connexionsubmit" type="submit" value="OK">
    </form>



</section>
<div class="clr"></div>
<div class="shad"></div>

<!--footer-->
<footer id="footer">
  <?php require_once('footer.php');?>
</footer>
</body>
</html>