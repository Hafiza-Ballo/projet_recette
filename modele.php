<?php
function inscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier)
{
    $fichier = 'utilisateurs.json';
    if (file_exists($fichier)) {
        $utilisateurs = json_decode(file_get_contents($fichier), true);
        $newId = max(array_column($utilisateurs, 'id')) + 1;
    } else {
        $utilisateurs = [];
    }
    $new = [
        'id' => $newId,
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

function recupRecetteByMot($mot){
    if (file_exists('recettes.json')) {
        $f = fopen('recettes.json', 'r+');
    
        if (!flock($f, LOCK_EX)){
            http_response_code(409);
        } 
    
        $jsonString = fread($f, filesize('recettes.json'));
        $data = json_decode($jsonString, true); 
        $recettes = [];
        foreach ($data as $recette) {
            
            if (stripos($recette['name'], $mot) !== false || stripos($recette['nameFR'], $mot) !== false) {
                $recettes[] = $recette;
                continue; 
            }

            if (isset($recette['Without']) && !is_null($recette['Without']) && is_array($recette['Without'])) {
                foreach ($recette['Without'] as $restriction) {
                    if (stripos($restriction, $mot) !== false) {
                        $recettes[] = $recette;
                        continue 2;
                    }
                }
            }

            foreach ($recette['ingredients'] as $ing) {
                if (isset($ing['name']) && stripos($ing['name'], $mot) !== false) {
                    $recettes[] = $recette;
                    continue 2; 
                }
            }

            
            foreach ($recette['ingredientsFR'] as $ing) {
                if (isset($ing['name']) && stripos($ing['name'], $mot) !== false) {
                    $recettes[] = $recette;
                    continue 2;
                }
            }

            // Étapes anglais
            foreach ($recette['steps'] as $step) {
                if (stripos($step, $mot) !== false) {
                    $recettes[] = $recette;
                    continue 2;
                }
            }

            // Étapes français
            foreach ($recette['stepsFR'] as $step) {
                if (stripos($step, $mot) !== false) {
                    $recettes[] = $recette;
                    continue 2;
                }
            }
            
        
    }
    return $recettes;  
}
}

function modifInfo($id_user, $nom, $prenom, $mail, $roles){
    $f = fopen('utilisateurs.json', 'r+');
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }
    $jsonString = fread($f, filesize('utilisateurs.json'));
    $users = json_decode($jsonString, true);
    $trouve = false;
    foreach ($users as &$user) {
        if ($user['id'] == $id_user) {
            if (isset($nom)) $user['nom'] = $nom;
            if (isset($prenom)) $user['prenom'] = $prenom;
            if (isset($mail)) $user['mail'] = $mail;
            if (isset($roles) && is_array($roles)) {
                

                foreach ($roles as $newRole) {
                    if (is_string($newRole) && !in_array($newRole, $user['role'])) {
                        $user['role'][] = $newRole;
                    }
                
            }

            }
            $trouve = true;
            break;
        }
    }
    if (!$trouve) {
        flock($f, LOCK_UN);
        fclose($f);
        echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé']);
        return;
    }
    ftruncate($f, 0);
    fseek($f, 0);
    fwrite($f, json_encode($users, JSON_PRETTY_PRINT));
    flock($f, LOCK_UN);
    fclose($f);
    echo json_encode(['success' => true, 'message' => 'Modification réussie']);
}

function ajouterCommentaire($id_user, $id_recette, $commentaire, $nom, $prenom)
{
    $fichier = 'commentaires.json';
    if (file_exists($fichier)) {
        $commentaires = json_decode(file_get_contents($fichier), true);
    } else {
        $commentaires = [];
    }

    $nouveauCommentaire = [
        'id_user' => $id_user,
        'id_recette' => $id_recette,
        'commentaire' => $commentaire,
        'nom' => $nom,
        'prenom' => $prenom,
        'date' => date('Y-m-d H:i:s') 
    ];

    $commentaires[] = $nouveauCommentaire;
    $json = json_encode($commentaires, JSON_PRETTY_PRINT);
    file_put_contents($fichier, $json);
}

function recupCommentaires($id_recette) {
    $fichier = 'commentaires.json';
    if (file_exists($fichier)) {
        $commentaires = json_decode(file_get_contents($fichier), true);
        $result = [];
        foreach ($commentaires as $commentaire) {
            if ($commentaire['id_recette'] == $id_recette) {
                $result[] = $commentaire;
            }
        }
        return $result;
    }
    return [];
}

function recupUtilisateurs()
{
    if (file_exists('utilisateurs.json')) {
        $f = fopen('utilisateurs.json', 'r+');
    
        if (!flock($f, LOCK_EX)){
            http_response_code(409);
        } 
    
        $jsonString = fread($f, filesize('utilisateurs.json'));
        $data = json_decode($jsonString, true); 
        return $data;
    }
}
function ajoutTraduction($id_recette, $liste, $index_l, $valeur,$langueDeTrad)
{
    $f = fopen('recettes.json', 'r+');

    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }
    
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true); 
    $liste=str_replace(' ', '', $liste);
    foreach($data as $index=> $r){
        if($r['id']==$id_recette){
            
            if(trim($langueDeTrad)=='fr'){
                echo 'ic';
                if($liste=='ingredients'){
                    $valeur=explode(",",$valeur);
                    $new = [
                        "quantity" => trim($valeur[0]),
                        "name" => trim($valeur[1]),
                        "type" => trim($valeur[2])
                    ];
                    if(sizeof($data[$index][$liste])<=0){
                        for( $i=0; $i<sizeof($data[$index][$liste.'FR']);$i++){
                            if($i==$index_l-1 ){

                                echo trim($valeur[0]).'  '.trim($valeur[1]).' '.trim($valeur[2]);
                                $data[$index][$liste][] = $new;
                            }
                            else{
                                $data[$index][$liste][]=[];

                            }
                        }

                            
                    }
                    else{
                        for( $i=0; $i<sizeof($data[$index][$liste.'FR']);$i++){
                            if($i==$index_l-1 ){
                                $data[$index][$liste][$i]=$new;
                            }
                            
                        }
                    }
                         
                }
                else if($liste=='steps'){
                    if(sizeof($data[$index][$liste])<=0){
                        for( $i=0; $i<sizeof($data[$index][$liste.'FR']);$i++){
                            if($i==$index_l-1 ){
                                $data[$index][$liste][$i]=$valeur;
                            }
                            else{
                                $data[$index][$liste][$i]= "";
                            }
                        }
                    }
                    else{
                        for( $i=0; $i<sizeof($data[$index][$liste.'FR']);$i++){
                            if($i==$index_l-1 ){
                                $data[$index][$liste][$i]=$valeur;
                            }
                            
                        }
                    }
                    
                }
                else if($liste=='nomRecette'){
                    $data[$index]['name']=$valeur;
                }
                
                
            }
            
            else if(trim($langueDeTrad)=='eng'){
                echo 'uu';
                $liste=str_replace(' ', '', $liste);
                if($liste=='ingredients'){
                    $valeur=explode(",",$valeur);
                    $new = [
                        "quantity" => trim($valeur[0]),
                        "name" => trim($valeur[1]),
                        "type" => trim($valeur[2])
                    ];
                    if(sizeof($data[$index][$liste.'FR'])<=0){
                        for( $i=0; $i<sizeof($data[$index][$liste]);$i++){
                            if($i==$index_l-1 ){

                                echo trim($valeur[0]).'  '.trim($valeur[1]).' '.trim($valeur[2]);
                                $data[$index][$liste.'FR'][] = $new;
                            }
                            else{
                                $data[$index][$liste.'FR'][]=[];

                            }
                        }

                            
                    }
                    else{
                        for( $i=0; $i<sizeof($data[$index][$liste]);$i++){
                            if($i==$index_l-1 ){
                                $data[$index][$liste.'FR'][$i]=$new;
                            }
                            
                        }
                    }
                         
                }
                else if($liste=='steps'){
                    if(sizeof($data[$index][$liste.'FR'])<=0){
                        for( $i=0; $i<sizeof($data[$index][$liste]);$i++){
                            if($i==$index_l-1 ){
                                $data[$index][$liste.'FR'][$i]=$valeur;
                            }
                            else{
                                $data[$index][$liste.'FR'][$i]= "";
                            }
                        }
                    }
                    else{
                        for( $i=0; $i<sizeof($data[$index][$liste.'FR']);$i++){
                            if($i==$index_l-1 ){
                                $data[$index][$liste.'FR'][$i]=$valeur;
                            }
                            
                        }
                    }
                    
                }
                else if($liste=='nomRecette'){
                    $data[$index]['nameFR']=$valeur;
                }
                
            }
            
        }
    }
    $valeur="";
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f); 

}

function modifierRoles($id_user, $roles) {
    $fichier = 'utilisateurs.json';
    if (file_exists($fichier)) {
        $utilisateurs = json_decode(file_get_contents($fichier), true);
    } else {
        $utilisateurs = [];
    }

    foreach ($utilisateurs as &$utilisateur) {
        if ($utilisateur['id'] == $id_user) {
            $utilisateur['role'] = $roles; 
            break;
        }
    }

    $json = json_encode($utilisateurs, JSON_PRETTY_PRINT);
    file_put_contents($fichier, $json);
}

function ajouterRecette($id_user, $langue, $name, $nameFR, $ingredients, $ingredientsFR, $steps, $stepsFR, $without, $timers, $photo, $author) {
    $f = fopen('recettes.json', 'r+');
    if (!flock($f, LOCK_EX)) {
        http_response_code(409);
        return;
    }
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true);

    $newId = max(array_column($data, 'id')) + 1;
    $newRecette = [
        'name' => '',
        'nameFR' => '',
        'Author' => $author,
        'Without' => $without ? explode(', ', $without) : [],
        'ingredients' => [],
        'ingredientsFR' => [],
        'steps' => [],
        'stepsFR' => [],
        'timers' => array_map('intval', explode(',', $timers)),
        'imageURL' => $photo ?: '',
        'originalURL' => '',
        'like' => 0,
        'commentaires' => [],
        'id' => $newId,
        'statut' => 'attente',
        'id_auteur' => (int)$id_user
    ];

    // Traitement des ingrédients et étapes selon la langue
    if ($langue === 'eng') {
        $newRecette['name'] = $name;
        $ingredientLines = explode("\n", $ingredients);
        foreach ($ingredientLines as $line) {
            $parts = explode(',', trim($line));
            if (count($parts) >= 3) {
                $newRecette['ingredients'][] = [
                    'quantity' => trim($parts[0]) ?: null, 
                    'name' => trim($parts[1]) ?: null,
                    'type' => trim($parts[2]) ?: null
                ];
            }
        }
        $newRecette['steps'] = array_map('trim', explode("\n", $steps));
    }
    if ($langue === 'fr') {
        $newRecette['nameFR'] = $nameFR;
        $ingredientLines = explode("\n", $ingredientsFR);
        foreach ($ingredientLines as $line) {
            $parts = explode(',', trim($line));
            if (count($parts) >= 3) {
                $newRecette['ingredientsFR'][] = [
                    'quantity' => trim($parts[0]) ?: null, 
                    'name' => trim($parts[1]) ?: null,
                    'type' => trim($parts[2]) ?: null
                ];
            }
        }
        $newRecette['stepsFR'] = array_map('trim', explode("\n", $stepsFR));
    }

    $data[] = $newRecette;
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f, 0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
}

function modifierRecette($id_recette, $langue, $name, $nameFR, $without, $ingredients, $ingredientsFR, $steps, $stepsFR, $timers, $photo, $author) {
    $f = fopen('recettes.json', 'r+');
    if (!flock($f, LOCK_EX)) {
        http_response_code(409);
        return;
    }
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true);

    foreach ($data as &$recette) {
        if ($recette['id'] == $id_recette) {
            if ($langue === 'eng') {
                $recette['name'] = $name;
                $recette['ingredients'] = [];
                $ingredientLines = array_filter(explode("\n", $ingredients), 'strlen');
                foreach ($ingredientLines as $line) {
                    $parts = explode(',', trim($line));
                    if (count($parts) >= 3) {
                        $recette['ingredients'][] = [
                            'quantity' => trim($parts[0]) ?: 'null',
                            'name' => trim($parts[1]) ?: 'null',
                            'type' => trim($parts[2]) ?: 'null'
                        ];
                    }
                }
                $recette['steps'] = array_filter(explode("\n", $steps), 'strlen');
            } elseif ($langue === 'fr') {
                $recette['nameFR'] = $nameFR;
                $recette['ingredientsFR'] = [];
                $ingredientLines = array_filter(explode("\n", $ingredientsFR), 'strlen');
                foreach ($ingredientLines as $line) {
                    $parts = explode(',', trim($line));
                    if (count($parts) >= 3) {
                        $recette['ingredientsFR'][] = [
                            'quantity' => trim($parts[0]) ?: 'null',
                            'name' => trim($parts[1]) ?: 'null',
                            'type' => trim($parts[2]) ?: 'null'
                        ];
                    }
                }
                $recette['stepsFR'] = array_filter(explode("\n", $stepsFR), 'strlen');
            }
            $recette['Without'] = $without ? explode(', ', $without) : [];
            $recette['timers'] = array_map('intval', explode(',', $timers));
            $recette['imageURL'] = $photo;
            $recette['Author'] = $author;
            break;
        }
    }

    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f, 0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
}

function recupRecettesByAuteur($id_auteur) {
    if (file_exists('recettes.json')) {
        $f = fopen('recettes.json', 'r+');
        if (!flock($f, LOCK_EX)) {
            http_response_code(409);
            return [];
        }
        $jsonString = fread($f, filesize('recettes.json'));
        $data = json_decode($jsonString, true);
        flock($f, LOCK_UN);
        fclose($f);
        return array_filter($data, function($recette) use ($id_auteur) {
            return $recette['id_auteur'] == $id_auteur;
        });
    }
    return [];
}

function modifRecette($id_recette,$langue,$nomR,$without,  $ingredients, $steps,$indexStep){
    $f = fopen('recettes.json', 'r+');
    if (!flock($f, LOCK_EX)) {
        http_response_code(409);
        return;
    }
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true);
    $quantite = array_column(json_decode($ingredients), 'quantite');
    $nom = array_column(json_decode($ingredients), 'nom');
    $type = array_column(json_decode($ingredients), 'type');

    $temps = array_column(json_decode($steps), 'temps');
    $step = array_column(json_decode($steps), 'step');
    
    foreach($data as $index => $r) {
        if($r['id'] == $id_recette) {
            $data[$index]['Without']=explode(", ", $without);

            if(trim($langue) == 'fr') {
                $data[$index]['nameFR'] = $nomR;
            
                foreach($quantite as $in => $q) {
                    if(isset($data[$index]['ingredientsFR'][$in])) {
                        $data[$index]['ingredientsFR'][$in] = [
                            'quantity' => $quantite[$in],
                            'name' => $nom[$in],
                            'type' => $type[$in]
                        ];
                    } else {
                        if(strlen($quantite[$in]) > 0 || strlen($nom[$in]) > 0 || strlen($type[$in]) > 0) {
                            $data[$index]['ingredientsFR'][] = [
                                'quantity' => $quantite[$in],
                                'name' => $nom[$in],
                                'type' => $type[$in]
                            ];
                        }
                    }
                }

                if($indexStep != -1 && $step[$indexStep] > 0) {
                    array_splice($data[$index]['stepsFR'], $indexStep + 1, 0, $step[$indexStep + 1]);
                    array_splice($data[$index]['steps'], $indexStep + 1, 0, "");
                    array_splice($data[$index]['timers'], $indexStep + 1, 0, (int)$temps[$indexStep + 1]);
                } else {
                    $data[$index]['stepsFR'] = [];
                    $data[$index]['timers'] = [];
                    
                    $nbSteps = count($data[$index]['steps']);
                    
                    for($i = 0; $i < count($step); $i++) {
                        if($step[$i] != "...") {
                            $data[$index]['stepsFR'][] = $step[$i];
                            $data[$index]['timers'][] = (int)$temps[$i];
                            
                            if($i == $nbSteps) {
                                $data[$index]['steps'][] = "";
                            }
                        }
                    }
                }
            } else {
                $data[$index]['name'] = $nomR;
                if(sizeof($r['ingredients']) > 0) {
                    foreach($r['ingredients'] as $in => $i) {
                        $data[$index]['ingredients'][$in] = [
                            'quantity' => $quantite[$in],
                            'name' => $nom[$in],
                            'type' => $type[$in]
                        ];
                    }
                } else {
                    foreach($quantite as $in => $q) {
                        $data[$index]['ingredients'][] = [
                            'quantity' => $quantite[$in],
                            'name' => $nom[$in],
                            'type' => $type[$in]
                        ];
                    }
                }

                if(sizeof($r['steps']) > 0) {
                    for($i = 0; $i < sizeof($data[$index]['steps']); $i++) {
                        $data[$index]['steps'][$i] = $step[$i];
                        $data[$index]['timers'][$i] = $temps[$i];
                    }
                } else {
                    for($i = 0; $i < sizeof($step); $i++) {
                        $data[$index]['steps'][] = $step[$i];
                        $data[$index]['timers'][$i] = (int)$temps[$i];
                    }
                }
            }
        }
    }

    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f, 0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
}


function ajoutRecette($langue, $nomR,$without, $ingredients,$steps, $div, $id_user,$photo){
    error_log("recette");
    $f = fopen('recettes.json', 'r+');
    if (!flock($f, LOCK_EX)) {
        http_response_code(409);
        return;
    }
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true);

    $fU = fopen('utilisateurs.json', 'r+');
    if (!flock($fU, LOCK_EX)) {
        http_response_code(409);
        return;
    }
    $jsonStringU = fread($fU, filesize('utilisateurs.json'));
    $dataU = json_decode($jsonStringU, true);
    foreach($dataU as $i=>$u){
        if($u['id']==$id_user){
            $nomU=$u['prenom'];
            break;
        }
    }

    $quantite = array_column(json_decode($ingredients), 'quantite');
    $nom = array_column(json_decode($ingredients), 'nom');
    $type = array_column(json_decode($ingredients), 'type');
    $in=[];
    error_log(sizeof($nom));
    for($i=0; $i<sizeof($nom); $i++){
        $l=[
            'quantity'=>$quantite[$i],
            'name'=>$nom[$i],
            'type'=>$type[$i]
        ];
        $in[]=$l;
    }

    $temps = array_column(json_decode($steps), 'temps');
    $step = array_column(json_decode($steps), 'step');
    $s=[];
    $t=[];
    for($i=0; $i<sizeof($step); $i++){
        array_push($s,$step[$i]);
        array_push($t,(int)$temps[$i]);
    }
    $newId = max(array_column($data, 'id')) + 1;
    if($langue=='fr'){
        $new=[
            'name' =>"",
            'nameFR' =>$nomR,
            'Author'=> $nomU,
            'Without'=>explode(", ", $without),
            'ingredients'=>[],
            'ingredientsFR' =>$in,
            'steps'=>[],
            'stepsFR'=>$s,
            'timers' =>$t,
            'imageURL'=> $photo ?: '',
            'originalURL'=> "",
            'like' =>0,
            'commentaires'=> [],
            'id'=> $newId,
            'statut'=> "attente",
            'id_auteur'=> (int)$id_user
        ];
    }
    else{
        $new=[
            'name' =>$nomR,
            'nameFR' =>"",
            'Author'=> $nomU,
            'Without'=>explode(", ", $without),
            'ingredients'=>$in,
            'ingredientsFR' =>[],
            'steps'=>$s,
            'stepsFR'=>[],
            'timers' =>$t,
            'imageURL'=> $photo ?: '',
            'originalURL'=> "",
            'like' =>0,
            'commentaires'=> [],
            'id'=> $newId,
            'statut'=> "attente",
            'id_auteur'=> (int)$id_user
        ];
    }
    $data[]=$new;
   // error_log("ici ".$new);
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f, 0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
}
