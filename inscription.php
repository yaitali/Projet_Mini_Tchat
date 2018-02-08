<?php

require_once("connexionbdd.php");
    //var_dump($_POST);
    if(isset($_POST['inscription']))
    {
        $sexe = htmlspecialchars($_POST['sexe']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $nom = htmlspecialchars($_POST['nom']);
        $jour = htmlspecialchars($_POST['jour']);
        $mois = htmlspecialchars($_POST['mois']);
        $annee = htmlspecialchars($_POST['annee']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $mdp = sha1($_POST['mdp']);
        $mdp2 = sha1($_POST['mdp2']);


        if( !empty($_POST['prenom']) AND !empty($_POST['nom']) AND !empty($_POST['prenom']) 
            AND !empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) 
            AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['sexe']) 
            AND !empty($_POST['jour']) AND !empty($_POST['mois']) AND !empty($_POST['annee']) 
        ) 
        {

            $pseudolength = strlen($pseudo);
            if ($pseudolength <= 255) 
            {
                if ($mail == $mail2) 
                {
                    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) 
                    {
                        $reqmail = $bdd-> prepare("SELECT * FROM utilisateur WHERE mail = ?");
                        $reqmail ->execute(array($mail));

                        //
                        if($reqmail->rowCount()>0)
                        {
                            $erreur ="Un compte existe deja avec cette adresse mail";
                        }
                        else{
                            if ($mdp == $mdp2)
                            {
                                $datenaissance=$_POST['annee']."-".$_POST['mois']."-".$_POST['jour'];
                                $insertmbr = $bdd->prepare("INSERT INTO utilisateur(PSEUDO, PRENOM, NOM,DATENAISSANCE, MAIL, MOT_PASSE,SEXE) values (?,?,?,?,?,?,?)");
                                $insertmbr->execute(array($pseudo, $prenom, $nom, $datenaissance, $mail, $mdp,$sexe));
                                header("Location:connexion.php");
                            }
                            else
                            {
                                $erreur = "Vos mots de passes ne correspondent pas !";
                            }

                        }
                    

                    }
                    else
                    {
                        $erreur = "Votre adresse mail n'est pas valide !";
                    }    
                }
                else
                {
                    $erreur = "Vos adresses mail ne correspondent pas !";
                }
            }
            else
            {
                $erreur = "Votre pseudo ne doit pas dépasser 255 caractéres !";
            }
        }
        else
        {
            $erreur = "Tous les champs doivent être complétés !";
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

<section id="register" class="main">
<h2 class="titre_registre">Crée un nouveau profil sur <span style="color:#ed1d8c">Kati</span><span style="color:#058bcb">TChat</span></h2>

    <form id="form" action="" method="post">             

        <!--label>
            <span>Je suis : </span> 
            <input type="radio" name="sexe" value="1" />Une Femme
        </label>

        <label>
           <input type="radio" name="sexe" value="2" />Un Homme
        </label-->

        <label><span>Je suis : </span>   
            <select name="sexe" style="width: 215px;margin-left: 5px;padding: 2px;" >
                <option></option>
                <option value="1">Je suis une femme</option>
                <option value="2">Je suis un homme</option>
            </select>
        </label>       
         
        <br/>
        <br/>
         
        <label><span>Prénom : </span>    
            <input name="prenom" type="text" placeholder="Votre Prénom" id="prenom" value= "<?php if(isset($prenom)) { echo $prenom;} ?>" />
        </label>
         
        <br/>
        <br/>
         
        <label><span>Nom : </span>   
            <input name="nom" type="text" placeholder="Votre Nom" value= "<?php if(isset($nom)) { echo $nom;} ?>" />
        </label>
         
        <br/>
        <br/>
         
         
        <label><span>Né(e) le : </span> 
            <select style="margin-left: 5px;color:#a9a9a9;padding: 2px;" name="jour">
                <option>Jour</option>
                <option>01</option>
                <option>02</option>
                <option>03</option>
                <option>04</option>
                <option>05</option>
                <option>06</option>
                <option>07</option>
                <option>08</option>
                <option>09</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                <option>13</option>
                <option>14</option>
                <option>15</option>
                <option>16</option>
                <option>17</option>
                <option>18</option>
                <option>19</option>
                <option>20</option>
                <option>21</option>
                <option>22</option>
                <option>23</option>
                <option>24</option>
                <option>25</option>
                <option>26</option>
                <option>27</option>
                <option>28</option>
                <option>29</option>
                <option>30</option>
                <option>31</option>
            </select>
            <select style="color:#a9a9a9;padding: 2px;" name="mois">
                <option >Mois</option>
                <option value="01">Janvier</option>
                <option value="02">Février</option>
                <option value="03">Mars</option>
                <option value="04">Avril</option>
                <option value="05">Mai</option>
                <option value="06">Juin</option>
                <option value="07">Juillet</option>
                <option value="08">Aout</option>
                <option value="09">Septembre</option>
                <option value="10">Octobre</option>
                <option value="11">Novembre</option>
                <option value="12">Décembre</option>
            </select>
            <select style="color:#a9a9a9;padding: 2px;" name="annee">
                <option>Année</option>
                <option>2000</option>
                <option>1999</option>
                <option>1998</option>
                <option>1997</option>
                <option>1996</option>
                <option>1995</option>
                <option>1994</option>
                <option>1993</option>
                <option>1992</option>
                <option>1991</option>
                <option>1990</option>
                <option>1989</option>
                <option>1988</option>
                <option>1987</option>
                <option>1986</option>
                <option>1985</option>
                <option>1984</option>
                <option>1983</option>
                <option>1982</option>
                <option>1981</option>
                <option>1980</option>
                <option>1979</option>
                <option>1978</option>
                <option>1977</option>
                <option>1976</option>
                <option>1975</option>
                <option>1974</option>
                <option>1973</option>
                <option>1972</option>
                <option>1971</option>
                <option>1970</option>
                <option>1969</option>
            </select>
        </label>
         
        <br/>
        <br/>
         
        <label ><span>Pseudo : </span>   
            <input name="pseudo" type="text" placeholder="Votre Pseudo" id="pseudo" value= "<?php if(isset($pseudo)) { echo $pseudo;} ?>" />
        </label>
         
        <br/>
        <br/>
          
        <label ><span>E-mail : </span>   
            <input name="mail" type="email" placeholder="Votre E-mail" value= "<?php if(isset($mail)) { echo $mail;} ?>" >
        </label>
         
        <br/>
        <br/>

        <label ><span>E-mail : </span>   
            <input name="mail2" type="email" placeholder="Confirmez votre E-mail" id="" value= "<?php if(isset($mail2)) { echo $mail2;} ?>"/>
        </label>
         
        <br/>
        <br/>

        <label><span>Mot de passe : </span>
            <input name="mdp" type="password" placeholder="Votre mot de passe" id="" />
        </label>


        <br/>
        <br/>

        <label><span>Confirmer votre mot de passe : </span>
            <input name="mdp2" type="password" placeholder="Confirmez votre mot de passe" />
        </label>


        <br/>
        <br/>
        <br/>

        <label class="bt_register" >
           <input  type="submit" name="inscription" value="Je m'inscris" />
        </label>     
         
    </form>

    <?php
        if (isset($erreur)) 
        {
            echo'<font color = "red">'.$erreur."</font>";
        }
    ?>
  
    
</section>
<div class="clr"></div>
<div class="shad"></div>

<!--footer-->
<footer id="footer">
  <?php require_once('footer.php');?>
</footer>
</body>
</html>