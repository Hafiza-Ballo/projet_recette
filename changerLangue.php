<?php
echo 'lll';
if(isset($_POST['langue'])){
    echo 'i';
    $_SESSION['langue']=$_POST['langue'];
}
if(isset($_POST['indexV'])&& isset($_POST['type_listeV']) && isset($_POST['langueV']) && isset($_POST['id_recetteV'])){
    $index_l= $_POST['indexV'];
    $liste=trim($_POST['type_listeV']);
    $id_recette=$_POST['id_recetteV'];
    $langue=$_POST['langueV'];
    echo $valeurInput." ".$liste." ".$id_recette." ".$langue ;
    
    $f = fopen('recettes.json', 'r+');
    
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    } 

    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true); 
    foreach($data as $index=> $r){
        if($r['id']==$id){
            if($langue==trim('fr')){
                if(strlen($data[$index][$liste][$index_l])>0){
                    return true;
                    break;
                }
            }
            if($langue==trim('eng')){
                if(strlen($data[$index][$liste.'FR'][$index_l])>0){
                    return true;
                    break;
                }
            }
            
        }
    }
}
?>