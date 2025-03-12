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
            echo 'Connexion réussie';
            header("Location: vue.php");  
            exit();
        } else {
            throw new Exception('Un des champs est incorrect');
        }
    }
}

?>