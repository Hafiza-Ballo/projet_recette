<?php

function afficherAccueil($user,$recette) {
    $id_user="";
    $id_user .= '<div>
    <input type="hidden" name="id" value="'.$user['id'].'">
    </div>';
    $liker="images\heart-regular.svg";
    $disliker="images\heart-plein.svg";
    $contenu = '';
    foreach ($recette as $d) {
                
        if(isset($d["imageURL"])){
            
            
            $contenu .= '<div id='.$d['id'].' >
                    <a href="page_recette.php?id='.$d['id'].'">
                        <img class="principale_image" src="'.$d["imageURL"].'" alt="'.$d['id'].'" >
                        <h4>'.$d["nameFR"].'</h4>
                        <button id="voir_r" >Voir la recette</button>
                    </a>
                    <button  class="btn_like" onclick="changeImgURL(this,\''.$d["id"].'\')">
                        <img class="like" src='.$liker.' alt="like">
                        <img class="dislike" src='.$disliker.' alt="like" >
                    </button>
                    </div>';

        }
       $contenu .= ' <br>';
        
        
    } 
require_once('accueilUsers.php');
}