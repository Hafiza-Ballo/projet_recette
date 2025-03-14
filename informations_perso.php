<?php
session_start();
$idUser= $_SESSION['idUser'];
$nom=$_SESSION['nom'];
$prenom=$_SESSION['prenom'];
$mail=$_SESSION['mail'];
echo $nom;
?>