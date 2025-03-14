<?php
$f = fopen('recettes.json', 'r+');

if (!flock($f, LOCK_EX)){
    http_response_code(409);
}
echo $_POST['id'];
echo $_POST['type'];
if(isset($_POST['id']) && isset($_POST['type'])){
    $id=$_POST['id'];
    $type=$_POST['type'];
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true); 
    foreach($data as $index=> $r){
        if($r['id']==$id){
            if($type=="ajout"){
                $data[$index]['like']+=1;
            }
            else{
                $data[$index]['like']-=1;            
            }
            break;
        }
    }
    
    $newdata=[];
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f); 
}
else{
    echo'rien';
}

?>