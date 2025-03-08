<?php
require_once ('controller.php');
session_start();

try {
    if(isset($_POST['inscription']))
    {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $role = $_POST['role'];
        $mdp = $_POST['mdp'];
        $isCuisinier = isset($_POST['isCuisinier']) ? 1 : 0;

        CtlInscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier);
        
    }
    else if(isset($_POST['connexion']))
    {
        $mail = $_POST['mail'];
        $mdp = $_POST['mdp'];
        CtlConnexion($mail, $mdp);
    }

else 
    {
        require_once ('connexion.php');
    }
} catch (Exception $e) {
    if (isset($_POST['inscription'])) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            {$e->getMessage()}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        require_once ('inscription.php');
    } elseif (isset($_POST['connexion'])) {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            {$e->getMessage()}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
        require_once ('connexion.php');
        
    }

    }
    

?>