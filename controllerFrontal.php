<?php
require_once ('controller.php');
session_start();

try {
    $jsonString = file_get_contents('utilisateurs.json');
    $data = json_decode($jsonString, true);
    
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
        $_SESSION['mail']=$mail;
        $_SESSION['mdp']=$mdp;
        CtlConnexion($mail, $mdp);
    }
    else if(isset($_POST['id']) && isset($_POST['type'] ) && isset($_POST['id_user'])){
        $id=$_POST['id'];
        $type=$_POST['type'];
        $id_user=$_POST['id_user'];
        CtlLike($id,$id_user,$type);
        
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