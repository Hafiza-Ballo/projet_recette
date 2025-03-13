<?php
function inscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier)
{
    $fichier = 'utilisateurs.json';
    if (file_exists($fichier)) {
        $utilisateurs = json_decode(file_get_contents($fichier), true);
    } else {
        $utilisateurs = [];
    }
    $new = [
        'nom' => $nom,
        'prenom' => $prenom,
        'mail' => $mail,
        'role' => $role,
        'mdp' => $mdp,
        'isCuisinier' => $isCuisinier
    ];
    $utilisateurs[] = $new;
    $json = json_encode($utilisateurs, JSON_PRETTY_PRINT);
    file_put_contents($fichier, $json);
    return true;
}

function connexion($mail, $mdp)
{
    $fichier = 'utilisateurs.json';
    if (file_exists($fichier)) {
        $utilisateurs = json_decode(file_get_contents($fichier), true);
    } else {
        $utilisateurs = [];
    }
    foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['mail'] === $mail && password_verify($mdp, $utilisateur['mdp'])) {
            return $utilisateur;
        }
    }
    return [];
}

function recupRecette(){
    if (file_exists('recettes.json')) {
        $f = fopen('recettes.json', 'r+');
    
        if (!flock($f, LOCK_EX)){
            http_response_code(409);
        } 
    
        $jsonString = fread($f, filesize('recettes.json'));
        $data = json_decode($jsonString, true); 
        return $data;
    }
        
}