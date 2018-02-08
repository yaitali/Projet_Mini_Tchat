<?php
session_start();
    //$bdd = new PDO('mysql:host=localhost; dbname=id488221_minitchat', 'id488221_kahina', 'kahina2010' );
    $bdd = new PDO('mysql:host=localhost; dbname=mini_chat', 'root', '' );
    $visited_ip=$_SERVER['REMOTE_ADDR'];//recuperation de ip
	$iprequete=$bdd->prepare("SELECT * FROM ip_adresse  WHERE ip = ? ");
    $iprequete->execute(array($visited_ip));
    $date=new DateTime(date("Y-m-d H:i:s"));
    $timestamp=$date->getTimestamp();
    if( $iprequete->rowCount()==0)
    {

        $addiprequete=$bdd->prepare("INSERT INTO ip_adresse (ip,time_connexion) VALUES(?,?) " );//inserer ip bd
        $addiprequete->execute(array($visited_ip,$timestamp));
    }
    else
    {

        $updateip=$bdd->prepare("UPDATE ip_adresse set time_connexion=? WHERE ip =?");//modifier
        $updateip->execute(array($timestamp,$visited_ip));
    }

    
    $date->sub(new DateInterval('PT5M'));//calcul le temps - 5mn
    $suppip=$bdd->prepare("DELETE FROM ip_adresse WHERE time_connexion < ?"); //supprision les ip des connecté
    $suppip->execute(array($date->getTimestamp()));
    

?>

