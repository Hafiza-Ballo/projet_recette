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
        
    }else if(isset($_POST['voir_recette'])){
        $id_recette=$_POST['id_recette'];
        $id_user=$_POST['id_user'];
        CtlafficherRecette($id_recette,$id_user);
        
    }else if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['id']) ){
        $id_user = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $roles = json_decode($_POST['demande_roles'], true);
        CtlMofifInfo($id_user, $nom, $prenom, $mail, $roles);
        echo json_encode(['success' => true]);
    }
    else if(isset($_GET['action'])){
        switch ($_GET['action']) {
            case 'retour_accueil':
                $id_user=$_GET['id_user'];
                CtlaffAccueil($id_user);
                break;
            case 'rechercher':
                $id_user=$_GET['id_user'];
                $mot=$_GET['mot'];
                CtlRechercher($id_user,$mot);
                break;
            case 'infos-perso':
                $id_user=$_GET['id_user'];
                CtlAfficherInfo($id_user);
                break;
            default:
                require_once ('connexion.php');
                break;
        }
        
    }
    else if(isset($_POST['id_user'])  && isset($_POST['id_recette'] ) && isset($_FILES['photo'] )){
        $id_user=$_POST['id_user'];
        $id_recette=$_POST['id_recette'];
        $photo=$_FILES['photo'];
        CtlAjoutPhoto($id_user,$id_recette,$photo);
    }
    else if(isset($_POST['id_user'])  && isset($_POST['id_recette'] ) && isset($_POST['url'] )){
        $id_user=$_POST['id_user'];
        $id_recette=$_POST['id_recette'];
        $photo=$_POST['url'];
        CtlAjoutPhoto2($id_user,$id_recette,$photo);
    }
    else if (isset($_POST['id_user']) && isset($_POST['role'])){
        echo 'ici';
        $role=$_POST['role'];
        $id_user=$_POST['id_user'];
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