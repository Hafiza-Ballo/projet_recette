<?php
session_start();
echo '<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page principale</title>
        <link rel="stylesheet" href="connexion.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="jquery-3.7.1.js"></script>
        <script src="affichage.js"></script>
        <style>
            .connexion{
                text-align: center;
                border-radius: 2px;
                border: solid 2px rgb(164, 163, 163);
                padding: 0;
                box-sizing: content-box;
            }
            body{
                background-color: rgb(244, 245, 236);
            }
            .principale_image{
                height: 30%;
                width: 30%;
            }
            .principale_ensemble{
                width: 70%;
                background-color: white;
                border-radius: 5px;
                margin-left: 20%;
                text-align:center;
            }
            .like{
                display:block;
                height: 10%;
                width: 10%;
            }
            .dislike{
                display:none;
                height: 10%;
                width: 10%;
            }
            #btn_like{
                
            }
            button {
    
    color: white;
}
        </style> 
    </head>

    <body>
        <section>
            <input placeholder="recherche">
            <img alt="icone_recherce" src=""> 
        </section>
        <section class="principale_ensemble">';
if (file_exists('recettes.json')) {
    $f = fopen('recettes.json', 'r+');

    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    } 

    $jsonString = fread($f, filesize('recettes.json'));
    $data = json_decode($jsonString, true); 
    // ICI ON MODIFIE LE CONTENU COMME UN TABLEAU ASSOCIATIF
    $newdata=[];
    $liker="images\heart-regular.svg";
    $disliker="images\heart-plein.svg";

      
            foreach ($data as $d) {
                
                if(isset($d["imageURL"])){
                    if(strlen($d["nameFR"])>0){
                        $id_recette=str_replace(' ', '-', $d["nameFR"]);
                    }
                    else{
                        $id_recette=str_replace(' ', '-', $d["name"]);
                    }
                    
                    echo'<div id='.$id_recette.' >
                            <a href="page_recette.php?id='.$id_recette.'">
                                <img class="principale_image" src="'.$d["imageURL"].'" alt="'.$id_recette.'" >
                                <h4>'.$d["nameFR"].'</h4>
                                <button >Voir la recette</button>
                                </a>
                                <button  id="btn_like" onclick="changeImgURL(this,\''.$d["nameFR"].'\')">
                                <img class="like" src='.$liker.' alt="like">
                                <img class="dislike" src='.$disliker.' alt="like" >
                                </button>
                            </div>';

                    $newdata[]=$d;  
                }
               echo' <br>';
                
                
            } 
        } 
    $newJsonString = json_encode($newdata, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);   
        
echo'         
        </section>
    </body>
</html>';


?>