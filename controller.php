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

function CtlLike($id,$id_user,$type)
{
    gererLike($id,$id_user,$type);
}

?>