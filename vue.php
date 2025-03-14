<?php

function afficherAccueil($user,$recette,$likes) {
    $id_user="";
    $id_user .= '<div>
    <input type="hidden" name="id_user" value="'.$user['id'].'">
    </div>';
    $liker="images\heart-regular.svg";
    $disliker="images\heart-plein.svg";
    $contenu = '';
    foreach ($recette as $d) {
                
        if(isset($d["imageURL"])){
            $a_licke = false;
            foreach ($likes as $l) {
                if ($l['id'] == $d['id'] && $l['id_user'] == $user['id']) {
                    $a_licke = true;
                    break;
                }
            }
            
            
            $contenu .= '<div id='.$d['id'].' >
                    <a href="page_recette.php?id='.$d['id'].'">
                        <img class="principale_image" src="'.$d["imageURL"].'" alt="'.$d['id'].'" >
                        <h4>'.$d["nameFR"].'</h4>
                        <button id="voir_r" >Voir la recette</button>
                    </a>

                    <button  class="btn_like" onclick="changeImgURL(this,\''.$d["id"].'\',\''.$user["id"].'\')">';
                    if ($a_licke) {
                        
                        $contenu .= '<img class="like" style="display:none" src="'.$liker.'" alt="like">
                                     <img class="dislike" style="display:block" src="'.$disliker.'" alt="dislike">';
                    } else {
                        
                        $contenu .= '<img class="like" style="display:block" src="'.$liker.'" alt="like">
                                     <img class="dislike" style="display:none" src="'.$disliker.'" alt="dislike">';
                    }
                        
            $contenu.=' </button>
                    </div>';

        }
       $contenu .= ' <br>';
        
        
    } 
require_once('accueilUsers.php');
}