<?php

function afficherAccueil($user, $recette, $likes) {
    if ($user)
    $id_user = '<div><input type="hidden" name="id_user" value="' . $user['id'] . '"></div>';
    $liker = "images/heart-regular.svg";
    $disliker = "images/heart-plein.svg";
    $infosBtn = '<a href="controllerFrontal.php?action=infos-perso&id_user=' .$user['id'] . '">Informations personnelles</a>';
    if (in_array('admin', $user['role']))
    {
        $infosBtn .= '<a href="controllerFrontal.php?action=admin&id_user=' .$user['id'] . '">Espace Admin</a>';
    }
    $contenu = '';
    $rechercheBtn = '<img alt="icone_recherche" src="images/magnifying-glass-solid.svg" class="icone_recherche" onclick="redirigerRecherche(' . $user['id'] . ')">';
    $proposerRecetteBtn="";
    $mesRecettesBtn = "";
    if (in_array('Chef', $user['role']))
    {
        $proposerRecetteBtn = '<a href="controllerFrontal.php?action=proposer_recette&id_user=' . $user['id'] . '" class="btn-action">Proposer une recette</a>' ;
        $mesRecettesBtn = '<a href="controllerFrontal.php?action=mes_recettes&id_user=' . $user['id'] . '" class="btn-action">Mes recettes</a>'; 
    }
      
    if(isset($_SESSION['langue']) ){
        $langue=$_SESSION['langue'];
    }
    else{
        $langue='fr';
    }
    foreach ($recette as $d) {
        $nblike = $d['like'];
        $images = getImage($d['id']); 
        $images[] = $d["imageURL"]; 

        
        $a_licke = false;
        foreach ($likes as $l) {
            if ($l['id'] == $d['id'] && $l['id_user'] == $user['id']) {
                $a_licke = true;
                break;
            }
        }

        
        $contenu .= '<div class="recette_card" id="' . $d['id'] . '">             
                            <div class="recette_principale">
                            <form method="post" action="controllerFrontal.php">
                            <input type="hidden" name="id_user" value="' . $user['id'] . '">
                            <input type="hidden" name="id_recette" value="' . $d['id'] . '">
                                <div id="carouselRecette_' . $d['id'] . '" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">';

        
        foreach ($images as $index => $image) {
            $active = ($index === 0) ? 'active' : '';
            $contenu .= '<div class="carousel-item ' . $active . '">
                            <img src="' . $image . '" class="d-block w-100 img_sec" alt="recette">
                         </div>';
        }

        $contenu .= '</div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRecette_' . $d['id'] . '" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselRecette_' . $d['id'] . '" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div>';
        
        if($langue=='fr'){
            $contenu.='<h4>' . $d["nameFR"] . '</h4>
                        <button id="voir_r" name="voir_recette">Voir la recette</button>';
        }
        else{
            $contenu.='<h4>' . $d["name"] . '</h4>
                        <button id="voir_r" name="voir_recette">See recipe</button>';
        }
        
                    $contenu.=  ' 
                    </form>
                    <div class="jaime">
                        <button class="btn_like" onclick="changeImgURL(this, \'' . $d["id"] . '\', \'' . $user["id"] . '\')">';

        
        if ($a_licke) {
            $contenu .= '<img class="like" style="display:none" src="' . $liker . '" alt="like">
                         <img class="dis" style="display:block" src="' . $disliker . '" alt="dislike">';
        } else {
            $contenu .= '<img class="like" style="display:block" src="' . $liker . '" alt="like">
                         <img class="dislike" style="display:none" src="' . $disliker . '" alt="dislike">';
        }

        $contenu .= '</button>
                     <span id="like-count-' . $d["id"] . '">' . $nblike . '</span>'.($langue == 'fr' ? ' J\'aime' : ' Like').'
                    </div>
                </div>
            </div>';
    }

    
    require_once('accueilUsers.php');
}

function afficherRecette($id_recette, $id_user, $recette, $like) {
    
    $liker = "images/heart-regular.svg";
    $disliker = "images/heart-plein.svg";
    $user = recupUserById($id_user);
    $infosBtn = '<a href="controllerFrontal.php?action=infos-perso&id_user=' .$id_user . '">Informations personnelles</a>';
    if (in_array('admin', $user['role']))
    {
        $infosBtn .= '<a href="controllerFrontal.php?action=admin&id_user=' .$user['id'] . '">Espace Admin</a>';
    }
    $nblike=$recette['like'];
    $a_licke = false;

    $divModifRecette='';
    $steps=[];
    $nom_ingredients=[];

    if(isset($_SESSION['langue'])){
        $langue=$_SESSION['langue'];
    }
    else{
        $langue='fr';
    }    
    $retourBtn = '<button class="btn_retour" onclick="window.location.href=\'controllerFrontal.php?action=retour_accueil&id_user=' . $id_user . '\'">' . ($langue == "fr" ? "Retour" : "Go back") . '</button>';

    foreach ($like as $l) {
        if ($l['id'] == $recette['id'] && $l['id_user'] == $id_user) {
            $a_licke = true;
            break;
        }
    }

    $liker_ = '<button class="btn_like" onclick="changeImgURL(this,\'' . $recette["id"] . '\',\'' . $id_user . '\')">';
    if ($a_licke) {
        $liker_ .= '<img class="like" style="display:none" src="' . $liker . '" alt="like">
                    <img class="dislike" style="display:block" src="' . $disliker . '" alt="dislike">
                    </button> <span id="like-count-' . $recette["id"] . '">' . $nblike . '</span> '.($langue == 'fr' ? ' J\'aime' : ' Like');
    } else {
        $liker_ .= '<img class="like" style="display:block" src="' . $liker . '" alt="like">
                    <img class="dislike" style="display:none" src="' . $disliker . '" alt="dislike">
                    </button> <span id="like-count-' . $recette["id"] . '">' . $nblike . '</span>'.($langue == 'fr' ? ' J\'aime' : ' Like');
    }
    
    if($langue=='fr'){
        $nom = $recette["nameFR"];
        $images = []; 
        $images = getImage($id_recette);
        $images[] = $recette["imageURL"];
        $author = $recette["Author"];
        $contenu = "";
        $divModifRecette.='<button onclick="ModifierRecette()" id="btn_modifRecette">  Modifier recette</button>
        <section id="content">
            <div id="divModifRecette">
                <h5>Nom</h5><input type="text" class="nomR" value="'.$nom.'"><br>';

        $without = implode(", ", $recette["Without"]);
        if (strlen($without) > 0) {
            $contenu .= '<h4>Spécificités</h4><p>' . $without . '</p>';
        }
        $contenu .= '<h4> <img src="images\grocery-cart.png" alt="ustensile" class="prep">Ingrédients</h4>';
        if (count($recette["ingredientsFR"]) > 0) {
            $nom_ingredients = array_column($recette["ingredientsFR"], "name");
            $quantite_ingredients=array_column($recette["ingredientsFR"], "quantity");
            $type_ingredients=array_column($recette["ingredientsFR"], "type");
            $strIngr=htmlspecialchars(json_encode($nom_ingredients), ENT_QUOTES, "UTF-8");
            $nom_ingredientsENG = array_column($recette["ingredients"], "name");
            
            $divModifRecette.='<h5>Ingrédients</h5><div >';
        
            $contenu.='<ul class="ingredients">';
            foreach ($nom_ingredients as $index=>$n) {
                if(isset($quantite_ingredients[$index])){
                    $q=$quantite_ingredients[$index];
                    $contenu .= '<li>'.$q.' de '. $n . '</li>';
                    $divModifRecette.='<div class="boxIngr">
                                        <label>Quantité</label><input class="quantite"  type="text" value="'.$q.'"><br>
                                        <label>Nom</label><input class="nomI"  type="text" value="'.$n.'"><br>
                                        <label>Type</label><input class="type"  type="text" value="'.$type_ingredients[$index].'"><br>
                                    </div>';
                }
                if(traducteur($id_user)){
                    if((isset($nom_ingredientsENG[$index])&&strlen($nom_ingredientsENG[$index])<=0)|| $recette["ingredients"]==[] ){
                        $contenu.='<button  onclick="traduction(this,'.($index+1).',\''.$langue.'\','.$id_recette.', \'ingredients\')" id="btn_traduireingredients'.($index+1).'">Traduire</button>
                        <div class="box_traduction tr_'.($index+1).'">
                        </div>';
                    }
                    else if(isset($recette["ingredients"][$index]) && array_key_exists($index,$nom_ingredientsENG)&& $nom_ingredientsENG[$index]==null){
                        $x='testingredients'.($index+1);
                        $contenu.='<button  onclick="traduction2(this,'.($index+1).',\' '.$langue.' \','.$id_recette.', \'ingredients\')" id="btn_traduireingredients'.($index+1).'">Translate</button>
                        <div class="box_traduction tr_'.($index+1).'" style="display:none;">
                            <div id="'.$x.'" >
                                <label>Quantity: </label><input value="'.array_column($recette["ingredients"], "quantity")[$index].'" class=" trad_input_ingredients" name="\'ingredients\','.$index.'" id="q'.$index.'"><br>
                                <label>Name: </label><input class=" trad_input_ingredients" name="\'ingredients\','.$index.'"  id="n'.($index+1).'"><br>
                                <label>Type: </label><input value="'.array_column($recette["ingredients"], "type")[$index].'" class=" trad_input_ingredients" name="\'ingredients\','.$index.'" id="t'.($index+1).'"><br>
                                <button id="idb'.($index+1).'" onclick="appliquerTradIngr('.($index+1).',\'ingredients\','.$id_recette.',\' '.$langue.' \' )"> Appliquer</button> <button  id="idann'.($index+1).'"onclick="annulerTrad('.($index+1).',\'ingredients\')">Annuler</button> </div>
                            </div>
                        </div>';
                    }
                }
                
            }
            $divModifRecette.='<button onclick="fctnouvelAjout(\'Ingr\', -1)" id="btn_nouvelIngr" >Nouvel ingrédient</button> 
                            <div id="nouvelIngr">
                                <div class="boxIngr">
                                    <label>Quantité</label><input class="quantite"  type="text" value=""><br>
                                    <label>Nom</label><input class="nomI"  type="text" value=""><br>
                                    <label>Type</label><input class="type"  type="text" value=""><br>
                                    <button id="btn_ajoutIngr" onclick="fctajout('.$id_recette.',\'fr\',\'Ingr\',-1)">Ajouter ingrédient</button><button onclick="annulerNouvelAjout(\'Ingr\',-1)">Annuler</button>
                                </div>
                            </div> 
                            </div>
                            <hr>';
            $contenu .= '</ul>';
        }
        else{
            $contenu.='<i>Ingrédients indisponible en francais</i><br><br>';
        
        }

        $timers = $recette["timers"];
        $total_t = array_sum($timers);
        
        $contenu .= '<h4><img src="images\bake.png" alt="ustensile" class="prep">Préparation</h4>
                    <div id="box_preparation">
                        <p><b>Temps total : </b>' . $total_t . ' minutes</p>
                    </div>';
        if (count($recette["stepsFR"]) > 0) {
            $steps = $recette["stepsFR"];
            $strStep=htmlspecialchars(json_encode($steps), ENT_QUOTES, "UTF-8");
            $divModifRecette.='<h5>Etapes</h5><div >';

            $contenu .= '<ul class="steps">';
            foreach ($steps as $index => $s) {
                $contenu .= '<li><h5>ÉTAPE ' . ($index + 1) . ' : </h5> ' . $s;
                $divModifRecette.='<div class="boxStep">
                                    <label>Etape</label><input class="step"  type="text" value="'.$s.'"><br>
                                    <label>Temps</label><input class="temps"  type="text" value="'.$timers[$index].'"><br>
                                </div>
                                <button  onclick="fctnouvelAjout(\'Etape\', '.$index.')" id="btn_new'.$index.'">Nouvelle étape</button>
                                <div id="new'.$index.'" style="display:none">
                                    <div class="boxStep">
                                        <label>Etape</label><input class="step"  type="text" value=""><br>
                                        <label>Temps(en minute)</label><input class="temps"  type="text" value=""><br>
                                        <button id="btn_ajoutEtape" onclick="fctajout('.$id_recette.',\'fr\',\'Etape\', '.$index.')">Ajouter l\'étape</button> <button onclick="annulerNouvelAjout(\'Etape\','.$index.')">Annuler</button>
                                    </div>
                                </div>';
                if(traducteur($id_user)){
                    if((isset($recette["steps"][$index])&&strlen($recette["steps"][$index])<=0)|| $recette["steps"]==[]){
                        $contenu.='<br><button  onclick="traduction(this,'.($index+1).',\' '.$langue.' \','.$id_recette.', \'steps\')" id="btn_traduiresteps'.($index+1).'">Traduire</button>
                        <div class="box_traduction tr_'.($index+1).'">
                        </div>';
                        
                    }
                }
                
                
                if ($timers[$index] > 1) {
                    $contenu .= ' (pendant ' . $timers[$index] . ' minutes)</li>';
                } else {
                    $contenu .= '</li>';
                }
            }
            $divModifRecette.='</div><button id="btn_a_modif"  onclick="appliquerModif('.$id_recette.',\'fr\')">Appliquer</button>  <button onclick="annulerModif()">Annuler</button></div>
             </div>
             </section>';
            $contenu .= '</ul>';
        }
        else{
            $contenu.='<i>Etapes indisponible en francais</i> <br><br>';
            $divModifRecette.='<label>Ingrédients</label>
            <div class="boxIngr">
                    <label>Quantité</label><input type="text" ><br>
                    <label>Nom</label><input type="text" value=><br>
                    <label>Type</label><input type="text" value=><br>
                    <button>Ajouter l\'étape</button> 
            </div>';
        }
        
    }
    else {
        $nom = $recette["name"];
        $images = [];
        $images = getImage($id_recette);
        $images[] = $recette["imageURL"];
        $author = $recette["Author"];
        $contenu = "";

        $divModifRecette.='<button onclick="ModifierRecette()" id="btn_modifRecette">  Edit recipe</button>
        <section id="content">
            <div id="divModifRecette">
                <h5>Name</h5><input type="text" class="nomR" value="'.$nom.'"><br>';

        $without = implode(", ", $recette["Without"]);
        if (strlen($without) > 0) {
            $contenu .= '<h4>Specificity</h4><p>' . $without . '</p>';
        }
        $contenu .= '<h4> <img src="images\grocery-cart.png" alt="ustensile" class="prep">Ingredients</h4>';
        if (count($recette["ingredients"]) > 0) {
            $nom_ingredients = array_column($recette["ingredients"], "name");
            $quantite_ingredients=array_column($recette["ingredients"], "quantity");
            $type_ingredients=array_column($recette["ingredients"], "type");

            $nom_ingredientsFR = array_column($recette["ingredientsFR"], "name");

            $strIngr=htmlspecialchars(json_encode($nom_ingredients), ENT_QUOTES, "UTF-8");
            $divModifRecette.='<h5>Ingredients</h5><div >';

            $contenu.='<ul class="ingredients">';
            foreach ($nom_ingredients as $index=>$n) {
                if(isset($quantite_ingredients[$index])){
                    $q=$quantite_ingredients[$index];
                    $contenu .= '<li>'.$q.' of '. $n . '</li>';
                    $divModifRecette.='<div class="boxIngr">
                                        <label>Quantity</label><input class="quantite"  type="text" value="'.$q.'"><br>
                                        <label>Name</label><input class="nomI"  type="text" value="'.$n.'"><br>
                                        <label>Type</label><input class="type"  type="text" value="'.$type_ingredients[$index].'"><br>
                                    </div>';
                }
                if(traducteur($id_user)){
                    if((isset($nom_ingredientsFR[$index]) && strlen($nom_ingredientsFR[$index])<=0) ||$recette["ingredientsFR"]==[]){
                        $contenu.='<button  onclick="traduction(this,'.($index+1).',\' '.$langue.' \','.$id_recette.', \'ingredients\')" id="btn_traduireingredients'.($index+1).'">Translate</button>
                        <div class="box_traduction tr_'.($index+1).'">
                        </div>'; 
                    }
                    else if(isset($recette["ingredientsFR"][$index]) && array_key_exists($index,$nom_ingredientsFR)&& $nom_ingredientsFR[$index]==null){
                        $x='testingredients'.($index+1);
                        $contenu.='<button  onclick="traduction2(this,'.($index+1).',\' '.$langue.' \','.$id_recette.', \'ingredients\')" id="btn_traduireingredients'.($index+1).'">Translate</button>
                        <div class="box_traduction tr_'.($index+1).'" style="display:none;">
                            <div id="'.$x.'" >
                                <label>Quantity: </label><input value="'.array_column($recette["ingredientsFR"], "quantity")[$index].'" class=" trad_input_ingredients" name="\'ingredients\','.$index.'" id="q'.$index.'"><br>
                                <label>Name: </label><input class=" trad_input_ingredients" name="\'ingredients\','.$index.'"  id="n'.($index+1).'"><br>
                                <label>Type: </label><input value="'.array_column($recette["ingredientsFR"], "type")[$index].'" class=" trad_input_ingredients" name="\'ingredients\','.$index.'" id="t'.($index+1).'"><br>
                                <button id="idb'.($index+1).'" onclick="appliquerTradIngr('.($index+1).',\'ingredients\','.$id_recette.',\' '.$langue.' \' )"> Apply</button> <button  id="idann'.($index+1).'"onclick="annulerTrad('.($index+1).',\'ingredients\')">Cancel</button> </div>
                            </div>
                        </div>';
                    }
                }
                
            }

            $contenu .= '</ul>';
        }
        else{
            $contenu.='<i>Ingredients unavailable in English</i><br><br>';
            $divModifRecette.='<label>Ingredients</label>
                                <div class="boxIngr">
                                        <label>Quantity</label><input type="text" ><br>
                                        <label>Name</label><input type="text" value=><br>
                                        <label>Type</label><input type="text" value=><br>
                                        <button>Add ingredients</button> <button>Cancel</button>
                                </div>';
        }

        $timers = $recette["timers"];
        $total_t = array_sum($timers);
        
        $contenu .= '<h4><img src="images\bake.png" alt="ustensile" class="prep">Preparation</h4>
                    <div id="box_preparation">
                        <p><b>Total time : </b>' . $total_t . ' minutes</p>
                    </div>';
        if (count($recette["steps"]) > 0) {
            $steps = $recette["steps"];
            $strStep=htmlspecialchars(json_encode($steps), ENT_QUOTES, "UTF-8");
            $divModifRecette.='<h5>Steps</h5><div >';

            $contenu .= '<ul class="steps">';
            foreach ($steps as $index => $s) {
                $contenu .= '<li><h5>STEP ' . ($index + 1) . ' : </h5> ' . $s;
                $divModifRecette.='<div class="boxStep">
                                    <label>Step</label><input class="step"  type="text" value="'.$s.'"><br>
                                    <label>Time</label><input class="temps"  type="text" value="'.$timers[$index].'"><br>
                                </div>';
                
                if ($timers[$index] > 1) {
                    $contenu .= ' (for ' . $timers[$index] . ' minutes)';
                } 
                if(traducteur($id_user)){
                    if((isset($recette["stepsFR"][$index]) && strlen($recette["stepsFR"][$index])<=0) ||$recette["stepsFR"]==[]){
                        $contenu.='<br><button  onclick="traduction(this,'.($index+1).',\' '.$langue.' \','.$id_recette.', \'steps\')" id="btn_traduiresteps'.($index+1).'">Translate</button>
                        <div class="box_traduction tr_'.($index+1).'">
                        </div>';
                        
                    }
                }
                $contenu .= '</li>';
            }
            $divModifRecette.='</div><button id="btn_a_modif"  onclick="appliquerModif('.$id_recette.',\'eng\')">Apply</button> <button onclick="annulerModif()">Cancel</button></div>
             </div>
             </section>';
            $contenu .= '</ul>';
        }
        else{
            $contenu.='<i>Steps unavailable in English</i><br><br>';
        }
        
        
    }

    
    
    $lettre=substr($author, 0, 1);
    $contenu .= ($author == "Unknown" ) ? '<i>Par Anonyme</i><br>' : '<span id="lettre">'.$lettre.'</span><i>Par ' . $author . '</i><br>';
    

    require_once('pageRecette.php');
}
function traducteur($id_user){
    $role=recupUserById($id_user)['role'];
    if(in_array("Traducteur",$role)){
        return true;
    }
}


function afficherRecherche($user,$recette,$likes,$mot){
   
    $id_user = '<div><input type="hidden" name="id_user" value="' . $user['id'] . '"></div>';
    $liker = "images/heart-regular.svg";
    $disliker = "images/heart-plein.svg";
    $infosBtn = '<a href="controllerFrontal.php?action=infos-perso&id_user=' .$user['id'] . '">Informations personnelles</a>';
    if (!in_array('admin', $user['role']))
    {
        $infosBtn .= '<br><a href="controllerFrontal.php?action=admin&id_user=' .$user['id'] . '">Espace Admin</a>';
    }
    $contenu = '';
    if(isset($_SESSION['langue'])){
        $langue=$_SESSION['langue'];
    }
    else{
        $langue='fr';
    } 
    $retourBtn = '<button class="btn_retour" onclick="window.location.href=\'controllerFrontal.php?action=retour_accueil&id_user=' . $user['id'] . '\'">' . ($langue == "fr" ? "Retour" : "Go back") . '</button>';
    $rechercheBtn = '<img alt="icone_recherche" src="images/magnifying-glass-solid.svg" class="icone_recherche" onclick="redirigerRecherche(' . $user['id'] . ')">';
    if (empty($recette)) {
        $contenu .= '<p>Aucune recette trouvée.</p>';
    } else {
    foreach ($recette as $d) {
        $nblike = $d['like'];
        $images = getImage($d['id']); 
        $images[] = $d["imageURL"]; 

        
        $a_licke = false;
        foreach ($likes as $l) {
            if ($l['id'] == $d['id'] && $l['id_user'] == $user['id']) {
                $a_licke = true;
                break;
            }
        }

        
        $contenu .= '<div class="recette_card" id="' . $d['id'] . '">             
                            <div class="recette_principale">
                            <form method="post" action="controllerFrontal.php">
                            <input type="hidden" name="id_recette" value="' . $d['id'] . '">
                                <div id="carouselRecette_' . $d['id'] . '" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">';

        
        foreach ($images as $index => $image) {
            $active = ($index === 0) ? 'active' : '';
            $contenu .= '<div class="carousel-item ' . $active . '">
                            <img src="' . $image . '" class="d-block w-100 img_sec" alt="recette">
                         </div>';
        }

        $contenu .= '</div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselRecette_' . $d['id'] . '" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Précédent</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselRecette_' . $d['id'] . '" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Suivant</span>
                            </button>
                        </div>
                        <h4>' . $d["nameFR"] . '</h4>
                        <button id="voir_r" name="voir_recette">Voir la recette</button> 
                    </form>
                    <div class="jaime">
                        <button class="btn_like" onclick="changeImgURL(this, \'' . $d["id"] . '\', \'' . $user["id"] . '\')">';

        
        if ($a_licke) {
            $contenu .= '<img class="like" style="display:none" src="' . $liker . '" alt="like">
                         <img class="dislike" style="display:block" src="' . $disliker . '" alt="dislike">';
        } else {
            $contenu .= '<img class="like" style="display:block" src="' . $liker . '" alt="like">
                         <img class="dislike" style="display:none" src="' . $disliker . '" alt="dislike">';
        }

        $contenu .= '</button>
                     <span id="like-count-' . $d["id"] . '">' . $nblike . '</span> j\'aime
                    </div>
                </div>
            </div>';
    }
    }
        require_once('afficheRecherche.php');
}
function afficherInfo($user){
    if(isset($_SESSION['langue'])){
        $langue=$_SESSION['langue'];
    }
    else{
        $langue='fr';
    } 
    $retourBtn = '<button class="btn_retour" onclick="window.location.href=\'controllerFrontal.php?action=retour_accueil&id_user=' . $user['id'] . '\'">' . ($langue == "fr" ? "Retour" : "Go back") . '</button>';
    $infosBtn = '<a href="controllerFrontal.php?action=infos-perso&id_user=' .$user['id'] . '">Informations personnelles</a>';
    if (in_array('admin', $user['role']))
    {
        $infosBtn .= '<a href="controllerFrontal.php?action=admin&id_user=' .$user['id'] . '">Espace Admin</a>';
    }
    $rechercheBtn = '<img alt="icone_recherche" src="images/magnifying-glass-solid.svg" class="icone_recherche" onclick="redirigerRecherche(' . $user['id'] . ')">';
    $id_user= '<input type="hidden" name="id" value="' .$user['id'] .'">';
    $nom = '<input type="text" class="form-control" name="nom" value="'. $user['nom'] . '" required>';
    $prenom = '<input type="text" class="form-control" name="prenom" value=" ' .  $user['prenom'] . '" required>';
    $mail = '<input type="email" class="form-control" name="mail" value="'.  $user['mail'] . '" required>';
    $roles = '';
    foreach ($user['role'] as $role): 
        $roles .= '<li>'. $role .'</li>';
    endforeach;
    $demandeRoles = '';
    if (!in_array('DemandeChef', $user['role']) && !in_array('Chef', $user['role'])) {
        $demandeRoles .= '
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="demande_roles[]" id="demande-chef" value="DemandeChef">
            <label class="form-check-label" for="demande-chef">Demander le rôle Chef</label>
        </div>';
    }
    if (!in_array('DemandeTraducteur', $user['role']) && !in_array('Traducteur', $user['role'])) {
        $demandeRoles .= '
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="demande_roles[]" id="demande-traducteur" value="DemandeTraducteur">
            <label class="form-check-label" for="demande-traducteur">Demander le rôle Traducteur</label>
        </div>';
    }
    $btn = '<button type="button" onclick="modifInfo()">Modifier</button>';

    require_once('informations_perso.php');
}

function afficherAdmin($user, $utilisateurs, $recettes) {
    require_once('admin.php');
}
