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

function recupUserById($id_user){
    $fichier = 'utilisateurs.json';
    if (file_exists($fichier)) {
        $utilisateurs = json_decode(file_get_contents($fichier), true);
    } else {
        $utilisateurs = [];
    }
    foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['id'] == $id_user ) {
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

function recupRecetteById($id_recette){
    if (file_exists('recettes.json')) {
        $f = fopen('recettes.json', 'r+');
    
        if (!flock($f, LOCK_EX)){
            http_response_code(409);
        } 
    
        $jsonString = fread($f, filesize('recettes.json'));
        $data = json_decode($jsonString, true); 
        foreach($data as $recette){
            if($id_recette==$recette['id']){
                return $recette;
            }
        }
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

function ajoutPhoto($id_user,$id_recette,$photo){
    $uploadDir = 'images/';
    $uploadPath = $uploadDir . $photo['name'];

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    move_uploaded_file($photo['tmp_name'], $uploadPath);
    $f = fopen('photos.json', 'r+');
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }
    $jsonString = fread($f, filesize('photos.json'));
    
    $data = json_decode($jsonString, true);
    $new = [
        'id_user' => $id_user,
        'id_recette' => $id_recette,
        'photo' => $uploadPath
    ];
    $data[] = $new;
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Photo ajoutée avec succès !</strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}
function ajoutPhoto2($id_user,$id_recette,$photo){
    $f = fopen('photos.json', 'r+');
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }
    $jsonString = fread($f, filesize('photos.json'));
    
    $data = json_decode($jsonString, true);
    $new = [
        'id_user' => $id_user,
        'id_recette' => $id_recette,
        'photo' => $photo
    ];
    $data[] = $new;
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Photo ajoutée avec succès !</strong>
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
  </div>";
}


function getImage($id_recette){
    $f = fopen('photos.json', 'r+');
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }
    $jsonString = fread($f, filesize('photos.json'));
    $data = json_decode($jsonString, true); 
    $images = [];
    foreach($data as $photo){
        if($photo['id_recette']==$id_recette){
            $images[] = $photo['photo'];
        }
    }
    return $images;
}

function AjoutRole($id_user,$newrole){
    
    $f = fopen('utilisateurs.json', 'r+');
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }

    $jsonString = fread($f, filesize('utilisateurs.json'));
    $data = json_decode($jsonString, true); 
    $ajoute=false;
    foreach($data as $index=> $u){
        if($u['id']==$id_user){
            if(!in_array($newrole, $data[$index]['role'])){
                $data[$index]['role'][] = $newrole;
                $_SESSION['role']=$data[$index]['role'];
                $ajoute=true;
                break;
            }
            else{
                echo 'Role existe deja';
            }
            
        }
    }
    if($ajoute){
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        ftruncate($f, 0);
        fseek($f,0);
        fwrite($f, $newJsonString);
    }
    
    flock($f, LOCK_UN);
    fclose($f);

    echo json_encode(["success" => true, "newrole" => $newrole]);
}