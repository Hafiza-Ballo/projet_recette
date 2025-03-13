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


function recupLike(){
    if (file_exists('likes.json')) {
        $f = fopen('likes.json', 'r+');
    
        if (!flock($f, LOCK_EX)){
            http_response_code(409);
        } 
    
        $jsonString = fread($f, filesize('likes.json'));
        $data = json_decode($jsonString, true); 
        return $data;
    }
        
}

function gererLike($id,$id_user,$type)
{
    $f = fopen('recettes.json', 'r+');
    $l=fopen('likes.json', 'r+');
    if (!flock($l, LOCK_EX)){
        http_response_code(409);
    }

if (!flock($f, LOCK_EX)){
    http_response_code(409);
}
$jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true); 
    $jsonString2 = stream_get_contents($l);
    $data2 = json_decode($jsonString2, true); 
    foreach($data as $index=> $r){
        if($r['id']==$id){
            if($type=="ajout"){
                $data[$index]['like']+=1;
                $data2[] = [
                    'id' => $id,
                    'id_user' => $id_user,
                ];
            }
            else{
                $data[$index]['like']-=1;
                foreach($data2 as $index2=> $like){
                    if($like['id']==$id && $like['id_user']==$id_user){
                        unset($data2[$index2]);
                    }
                }            
            }
            break;
        }
    }
    
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f); 

    $newJsonString2 = json_encode($data2, JSON_PRETTY_PRINT);
    ftruncate($l, 0);
    fseek($l,0);
    fwrite($l, $newJsonString2);
    flock($l, LOCK_UN);
    fclose($l); 
    

}