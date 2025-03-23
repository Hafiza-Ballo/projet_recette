<?php
session_start();

$f = fopen('recettes.json', 'r+');

if (!flock($f, LOCK_EX)){
    http_response_code(409);
}
$jsonString = fread($f, filesize('recettes.json'));
$data = json_decode($jsonString, true); 

$ligne_recette;
if(isset($_GET['id'])){
    $id_recette=$_GET['id'];
    foreach($data as $recette){
    
        if($id_recette==$recette['id']){
            $ligne_recette=$recette;
            break;
        }
    }

    $author=$ligne_recette["Author"];
    $without=implode(", ", $ligne_recette["Without"]);
    $timers=$ligne_recette["timers"];
    $total_t=0;
    foreach($timers as $t){
        $total_t+=$t;
    } 
    $like=$ligne_recette["like"];
    $commentaires=$ligne_recette["commentaires"];
    
   

    echo '<!doctype html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <title>Page principale</title>
                <link rel="stylesheet" href="connexion.css" type="text/css">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <style>
                    body{
                        background-color: rgb(244, 245, 236);
                    }
                    h1{
                        text-align:center;
                    }
                    .page_recette{
                        width: 70%;
                        border-radius: 7px;
                        background-color:white;
                        margin-left:15%;
                        padding-left:2%;
                        
                    }
                    .img_sec{
                        height:120%;
                        width:70%;
                        margin-left:15%
                    }
                    #aime{
                        
                    }
                    .btn_a_c{
                        display: flex;         
                        flex-direction: column; 
                        align-items: flex-end; 
                        gap: 5px;        

                    }
                    .btn_a{
                        border:none;
                        background-color:white;
                        color:#faab66;
                    }
                    
                    
                </style>
            </head>

            <body>
                <section>
                    
                </section>
                <section class="page_recette">
                    <h1>'.$ligne_recette["nameFR"].'</h1> 
                        <div class="recette_principale">
                            <img class="img_sec" src="'.$ligne_recette["imageURL"].'">
                            <br>
                            <div class="btn_a_c">
                                <button class="btn_a"><img class="" src="images\heart-plein.svg" alt="like">'.$like.' j\'aime</button>
                                <button ><img class="" src="" alt="commentaire"> Commentaires</button>
                            </div>
                        <h4>Spécificités</h4>';
                        if(strlen($without)>0){
                            echo '<p>'.$without.'</p>';
                        }
                        echo'
                        <h4>Ingredients</h4>';
                        if(count($ligne_recette["ingredientsFR"])>0){
                            $nom_ingredientsFR=array_column($ligne_recette["ingredientsFR"], "name");
                            echo '<ul>';
                            foreach($nom_ingredientsFR as $n){
                                echo '<li>'.$n.'</li>';
                            } 
                            echo '</ul>';
                        }
                        echo '<h4>Préparation</h4>
                                <div id="box_preparation">
                                    <p><b>Temps total: </b>'.$total_t.' minutes</p>
                                </div>';

                        if(count($ligne_recette["stepsFR"])>0){
                            $stepsFR=$ligne_recette["stepsFR"];
                            echo '<ul>';
                            foreach($stepsFR as$index=> $s){
                                echo '<li><h5>ETAPE '.($index+1).' : </h5> '.$s;
                                if($timers[$index]>1){
                                    echo ' (pendant '.$timers[$index].' minutes) </li>';
                                }
                            } 
                            echo '</ul>';
                        }
                        if($author=="Unknown"){
                            echo '<i> By Anonyme</i>';
                        }
                        else{
                            echo '<i> By'.$author.'</i>';
                        }
                        
                        
                      echo'  
                    </div>
                    <div class="autres_recettes">
                       <h3>Autres recettes</h3> 
                    </div>';

                echo'         
                </section>
            </body>
        </html>';
    
}
else{
    echo 'recette pas trouvée';
}

?>