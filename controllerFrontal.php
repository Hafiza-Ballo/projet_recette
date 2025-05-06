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
    }else if (isset($_GET['action']) && $_GET['action'] === 'admin') {
        $id_user = $_GET['id_user'];
        CtlAfficherAdmin($id_user);
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
    }else if (isset($_POST['id_user']) && isset($_POST['id_recette']) && isset($_POST['commentaire'])) {
        $id_user = $_POST['id_user'];
        $id_recette = $_POST['id_recette'];
        $commentaire = $_POST['commentaire'];
        CtlAjouterCommentaire($id_user, $id_recette, $commentaire);
    }
    else if (isset($_POST['action']) && $_POST['action'] === 'get_commentaires' && isset($_POST['id_recette'])) {
        $id_recette = $_POST['id_recette'];
        $commentaires = CtlRecupCommentaires($id_recette);
        echo json_encode($commentaires);
    }
    /*else if (isset($_POST['action']) && $_POST['action'] === 'ajouter_recette') {
        $id_user = $_POST['id_user'];
        $langue = $_POST['langue'];
        $name = ($langue === 'eng') ? $_POST['name'] : '';
        $nameFR = ($langue === 'fr') ? $_POST['nameFR'] : '';
        $ingredients = ($langue === 'eng') ? $_POST['ingredients'] : '';
        $ingredientsFR = ($langue === 'fr') ? $_POST['ingredientsFR'] : '';
        $steps = ($langue === 'eng') ? $_POST['steps'] : '';
        $stepsFR = ($langue === 'fr') ? $_POST['stepsFR'] : '';
        $without = $_POST['without'];
        $timers = $_POST['timers'];
        $photo_file = isset($_FILES['photo_file']) && $_FILES['photo_file']['error'] === UPLOAD_ERR_OK ? $_FILES['photo_file'] : null;
        $photo_url = $_POST['photo_url'] ?? '';
        CtlAjouterRecette($id_user, $langue, $name, $nameFR, $ingredients, $ingredientsFR, $steps, $stepsFR, $without, $timers, $photo_file, $photo_url);
    }*/
    else if (isset($_GET['action']) && $_GET['action'] === 'proposer_recette') {
        $id_user = $_GET['id_user'];
        $user = recupUserById($id_user); 
        if (!in_array('Chef', $user['role'])) {
            throw new Exception('Accès refusé : vous n\'êtes pas chef.');
        }
        require_once('newrecette.php'); 
    }
    else if (isset($_GET['action']) && $_GET['action'] === 'mes_recettes') {
        $id_user = $_GET['id_user'];
        CtlAfficherMesRecettes($id_user);
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
            case 'deconnexion':
                session_unset();
                session_destroy();
                require_once ('connexion.php');
                break;
            default:
                require_once ('connexion.php');
                break;
        }
        
    }
    /*else if (isset($_POST['action']) && $_POST['action'] === 'modifier_recette') {
        $id_user = $_POST['id_user'];
        $id_recette = $_POST['id_recette'];
        $langue = $_SESSION['langue'] ?? 'fr';
        $name = ($langue === 'eng') ? $_POST['name'] : '';
        $nameFR = ($langue === 'fr') ? $_POST['nameFR'] : '';
        $without = $_POST['without'];
        $ingredients = ($langue === 'eng') ? $_POST['ingredients'] : '';
        $ingredientsFR = ($langue === 'fr') ? $_POST['ingredientsFR'] : '';
        $steps = ($langue === 'eng') ? $_POST['steps'] : '';
        $stepsFR = ($langue === 'fr') ? $_POST['stepsFR'] : '';
        $timers = $_POST['timers'];
        $photo_file = isset($_FILES['photo_file']) && $_FILES['photo_file']['error'] === UPLOAD_ERR_OK ? $_FILES['photo_file'] : null;
        $photo_url = $_POST['photo_url'] ?? '';
        $author = $_POST['author'];
        CtlModifierRecette($id_user, $id_recette, $langue, $name, $nameFR, $without, $ingredients, $ingredientsFR, $steps, $stepsFR, $timers, $photo_file, $photo_url, $author);
    }*/
    

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
    else if (isset($_POST['action']) && $_POST['action'] === 'modifier_roles') {
        $id_user = $_POST['id_user'];
        $roles = $_POST['roles'];
        CtlModifierRoles($id_user, $roles);
    }
    
    else if(isset($_POST['index']) && isset($_POST['valeurInput']) && isset($_POST['type_liste']) && isset($_POST['langue']) && isset($_POST['id_recette'])){
        $index= $_POST['index'];
        $valeurInput= $_POST['valeurInput'];
        $liste=$_POST['type_liste'];
        $id_recette=$_POST['id_recette'];
        $langue=$_POST['langue'];
        echo $valeurInput." ".$liste." ".$id_recette." ".$langue ;
        CtlAjoutTraduction($id_recette, $liste, $index, $valeurInput, $langue);
    }
    else if(isset($_POST['id_recette']) && isset($_POST['langue']) && isset($_POST['ingredients']) &&  isset($_POST['nomR']) &&isset($_POST['steps']) &&isset($_POST['without'])){
        $id_recette=$_POST['id_recette'];
        $langue=$_POST['langue'];
        $ingredients=$_POST['ingredients'];
        $nomR=$_POST['nomR'];
        $steps=$_POST['steps'];
        $without=$_POST['without'];
        if(isset($_POST['index'])){$index=$_POST['index']; error_log($index);}
        else{$index=-1;}
        if(isset($_POST['div']) && $_POST['div']=='AjoutRecette' && isset($_POST['id_u']) && isset($_POST['photo_url'])  ){
            $div=$_POST['div'];
            $id_user= $_POST['id_u'];
            $photo_url=$_POST['photo_url'];
            CtlAjoutRecette($langue, $nomR,$without, $ingredients,$steps, $div, $id_user, $photo_url);
        }
        else{
            CtlModifRecette($id_recette,$langue, $nomR,$without, $ingredients,$steps, $index);
        }
    }
    
    elseif(isset($_POST['id_recette']) && isset($_POST['valider'])){
        $id_recette=$_POST['id_recette'];
        $valider=$_POST['valider'];
        CtlValiderOuSupRecette($id_recette,$valider);
    }
    elseif(isset($_POST['type']) && isset($_POST['index']) && isset($_POST['sup']) && isset($_POST['id_recette'])){
        $type=$_POST['type'];
        $index=$_POST['index'];
        error_log($index);
        $id_recette=$_POST['id_recette'];
        CtlSuprimerIngrStepModif($type,$index, $id_recette);
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