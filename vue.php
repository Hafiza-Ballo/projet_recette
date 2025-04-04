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

    
    require_once('accueilUsers.php');
}

function afficherRecette($id_recette, $id_user, $recette, $like) {
    
    $liker = "images/heart-regular.svg";
    $disliker = "images/heart-plein.svg";
    $infosBtn = '<a href="controllerFrontal.php?action=infos-perso&id_user=' .$id_user . '">Informations personnelles</a>';
    $nblike=$recette['like'];
    $a_licke = false;
    $retourBtn = '<button class="btn_retour" onclick="window.location.href=\'controllerFrontal.php?action=retour_accueil&id_user=' . $id_user . '\'">Retour</button>';


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
                    </button> <span id="like-count-' . $recette["id"] . '">' . $nblike . '</span> j\'aime';
    } else {
        $liker_ .= '<img class="like" style="display:block" src="' . $liker . '" alt="like">
                    <img class="dislike" style="display:none" src="' . $disliker . '" alt="dislike">
                    </button> <span id="like-count-' . $recette["id"] . '">' . $nblike . '</span> j\'aime';
    }

    $nom = $recette["nameFR"];
    $images = [];
    $images = getImage($id_recette);
    $images[] = $recette["imageURL"];
    $author = $recette["Author"];
    $contenu = "";

    $without = implode(", ", $recette["Without"]);
    if (strlen($without) > 0) {
        $contenu .= '<h4>Spécificités</h4><p>' . $without . '</p>';
    }

    if (count($recette["ingredientsFR"]) > 0) {
        $nom_ingredientsFR = array_column($recette["ingredientsFR"], "name");
        $contenu .= '<h4>Ingrédients</h4><ul>';
        foreach ($nom_ingredientsFR as $n) {
            $contenu .= '<li>' . $n . '</li>';
        }
        $contenu .= '</ul>';
    }

    $timers = $recette["timers"];
    $total_t = array_sum($timers);
    
    $contenu .= '<h4>Préparation</h4>
                 <div id="box_preparation">
                     <p><b>Temps total : </b>' . $total_t . ' minutes</p>
                 </div>';
    if (count($recette["stepsFR"]) > 0) {
        $stepsFR = $recette["stepsFR"];
        $contenu .= '<ul>';
        foreach ($stepsFR as $index => $s) {
            $contenu .= '<li><h5>ÉTAPE ' . ($index + 1) . ' : </h5> ' . $s;
            if ($timers[$index] > 1) {
                $contenu .= ' (pendant ' . $timers[$index] . ' minutes)</li>';
            } else {
                $contenu .= '</li>';
            }
        }
        $contenu .= '</ul>';
    }

    $contenu .= ($author == "Unknown") ? '<i>Par Anonyme</i>' : '<i>Par ' . $author . '</i>';

    require_once('pageRecette.php');
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
    $retourBtn = '<button class="btn_retour" onclick="window.location.href=\'controllerFrontal.php?action=retour_accueil&id_user=' . $user['id'] . '\'">Retour</button>';
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
    $retourBtn = '<button class="btn_retour" onclick="window.location.href=\'controllerFrontal.php?action=retour_accueil&id_user=' . $user['id'] . '\'">Retour</button>';
    $infosBtn = '<a href="controllerFrontal.php?action=infos-perso&id_user=' .$user['id'] . '">Informations personnelles</a>';
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