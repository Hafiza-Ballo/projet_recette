<?php
echo 'hello';
$f = fopen('recettes.json', 'r+');

if (!flock($f, LOCK_EX)){
    http_response_code(409);
}
if(isset($_POST['name']) && isset($_POST['type'])){
    $name=$_POST['name'];
    $type=$_POST['type'];
    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true); 
    foreach($data as $index=>$valeur){
        if($valeur['nameFR']==$name){
            if($type=="ajout"){
                $data[$index]['like']+=1;
            }
            else{
                $data[$index]['like']-=1;
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
}
else{
    echo'rien';
}

?>