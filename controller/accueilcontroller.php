<?php
if(isset($_POST['mail_c']) && isset($_POST['mdp_c']))
    {
        $mail_c=$_POST['mail_c'];
        $mdp_c=$_POST['mdp_c'];
        
    }
elseif(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['role']) && isset($_POST['mdp']) && isset($_POST['isCuisinier']))
    {
        
    }
else 
    {
        require_once ('../connexion.php');
    }
?>