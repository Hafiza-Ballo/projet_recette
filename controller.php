<?php
require_once ('modele.php');
require_once ('vue.php');
function CtlInscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier)
{
    if (empty($nom) || empty($prenom) || empty($mail) || empty($mdp)) {
        throw new Exception('Tous les champs ne sont pas remplis !');
    }
    else {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $result = inscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier);
        if ($result) {
            require_once ('connexion.php');
        } else {
            throw new Exception('Erreur lors de l\'inscription');
        }
    }
}

function CtlConnexion($mail, $mdp)
{
    if (empty($mail) || empty($mdp)) {
        throw new Exception('Tous les champs ne sont pas remplis !');
    }
    else {
        $result = connexion($mail, $mdp);
        if ($result) {
            $recette = recupRecette();
            $like=recupLike();
            afficherAccueil($result,$recette,$like);
        } else {
            throw new Exception('Erreur lors de la connexion');
        }
        
        
    }
}

function CtlaffAccueil($id_user){
    $user=recupUserById($id_user);
    $recette = recupRecette();
    $like=recupLike();
    afficherAccueil($user,$recette,$like);
}

function CtlLike($id,$id_user,$type)
{
    gererLike($id,$id_user,$type);
}
function CtlAfficherRecette($id_recette,$id_user){
    $recette = recupRecetteById($id_recette);
    $like=recupLike();
    afficherRecette($id_recette,$id_user,$recette,$like);
}

function CtlAjoutPhoto($id_user,$id_recette,$photo){
    
    ajoutPhoto($id_user,$id_recette,$photo);
}
function CtlAjoutPhoto2($id_user,$id_recette,$photo){
    
    ajoutPhoto2($id_user,$id_recette,$photo);
}

function CtlRechercher($id_user,$mot){
    $recette = recupRecetteByMot($mot);
    $like=recupLike();
    $user=recupUserById($id_user);
    afficherRecherche($user,$recette,$like,$mot);
}

/*function CtlAjoutRole($id_user,$role){
    AjoutRole($id_user, $role);
}

?>