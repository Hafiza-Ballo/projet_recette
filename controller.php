<?php
require_once ('modele.php');
require_once ('vue.php');
function CtlInscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier)
{
    if (empty($nom) || empty($prenom) || empty($mail) || empty($mdp)) {
        throw new Exception('Tous les champs ne sont pas remplis !');
    }
    else {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $result = inscription($nom, $prenom, $mail, $role, $mdp, $isCuisinier);
        if ($result) {
            require_once ('connexion.php');
        } else {
            throw new Exception('Erreur lors de l\'inscription');
        }
    }
}

function CtlConnexion($mail, $mdp)
{
    if (empty($mail) || empty($mdp)) {
        throw new Exception('Tous les champs ne sont pas remplis !');
    }
    else {
        $result = connexion($mail, $mdp);
        if ($result) {
            $recette = recupRecette();
            $like=recupLike();
            afficherAccueil($result,$recette,$like);
        } else {
            throw new Exception('Erreur lors de la connexion');
        }
        
        
    }
}

function CtlaffAccueil($id_user){
    $user=recupUserById($id_user);
    $recette = recupRecette();
    $like=recupLike();
    afficherAccueil($user,$recette,$like);
}

function CtlLike($id,$id_user,$type)
{
    gererLike($id,$id_user,$type);
}
function CtlAfficherRecette($id_recette,$id_user){
    $recette = recupRecetteById($id_recette);
    $like=recupLike();
    afficherRecette($id_recette,$id_user,$recette,$like);
}

function CtlAjoutPhoto($id_user,$id_recette,$photo){
    
    ajoutPhoto($id_user,$id_recette,$photo);
}
function CtlAjoutPhoto2($id_user,$id_recette,$photo){
    
    ajoutPhoto2($id_user,$id_recette,$photo);
}

function CtlRechercher($id_user,$mot){
    $recette = recupRecetteByMot($mot);
    $like=recupLike();
    $user=recupUserById($id_user);
    afficherRecherche($user,$recette,$like,$mot);
}
function CtlAfficherInfo($id_user){
    $user=recupUserById($id_user);
    afficherInfo($user);
}

function CtlMofifInfo($id,$nom, $prenom, $mail, $roles){
    $user=modifInfo($id,$nom, $prenom, $mail, $roles);
}

function  CtlAjouterCommentaire($id_user, $id_recette, $commentaire) 
{
    $user = recupUserById($id_user);
    if (empty($user)) {
        throw new Exception('Utilisateur non trouvé.');
    }
    ajouterCommentaire($id_user, $id_recette, $commentaire, $user['nom'], $user['prenom']);
    echo json_encode(['success' => true]);
}

function CtlRecupCommentaires($id_recette)
{
    return recupCommentaires($id_recette);
}
function CtlAfficherAdmin($id_user)
{
    $user = recupUserById($id_user); 
    if (!in_array('admin', $user['role'])) {
        throw new Exception('Accès refusé : vous n\'êtes pas administrateur.');
    }
    $utilisateurs = recupUtilisateurs() ;
    $recettes = recupRecetteAll(); 
    afficherAdmin($user, $utilisateurs, $recettes);
}

function CtlAjoutTraduction($id_recette, $liste, $index_l, $valeur, $langueDeTrad){
    ajoutTraduction($id_recette, $liste, (int)$index_l, $valeur,$langueDeTrad);
}

function CtlModifierRoles($id_user, $roles) {
    $user = recupUserById($id_user);
    if (empty($user)) {
        throw new Exception('Utilisateur non trouvé.');
    }
    modifierRoles($id_user, $roles);
    echo json_encode(['success' => true]);
}

function CtlAjouterRecette($id_user, $langue, $name, $nameFR, $ingredients, $ingredientsFR, $steps, $stepsFR, $without, $timers, $photo_file, $photo_url) {
    $user = recupUserById($id_user);
    if (!in_array('Chef', $user['role'])) {
        throw new Exception('Accès refusé : vous n\'êtes pas chef.');
    }
    if (($langue === 'fr' && (empty($nameFR) || empty($ingredientsFR) || empty($stepsFR))) || 
        ($langue === 'eng' && (empty($name) || empty($ingredients) || empty($steps)))) {
        throw new Exception('Tous les champs obligatoires doivent être remplis pour la langue choisie.');
    }
    if (empty($timers)) {
        throw new Exception('Les temps sont obligatoires.');
    }

    $photo = '';
    if ($photo_file) {
        $uploadDir = 'images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $photo = $uploadDir . basename($photo_file['name']);
        move_uploaded_file($photo_file['tmp_name'], $photo);
    } elseif (!empty($photo_url)) {
        $photo = $photo_url;
    }

    ajouterRecette($id_user, $langue, $name, $nameFR, $ingredients, $ingredientsFR, $steps, $stepsFR, $without, $timers, $photo, $user['nom'] . ' ' . $user['prenom']);
    echo '<script>alert("Recette proposée avec succès !"); window.location.href="controllerFrontal.php?action=retour_accueil&id_user=' . $id_user . '";</script>';
}

function CtlAfficherMesRecettes($id_user) {
    $user = recupUserById($id_user);
    if (!in_array('Chef', $user['role'])) {
        throw new Exception('Accès refusé : vous n\'êtes pas chef.');
    }
    $recettes = recupRecettesByAuteur($id_user); 
    $likes = recupLike();
    afficherAccueil($user, $recettes, $likes); 
}

function CtlModifierRecette($id_user, $id_recette, $langue, $name, $nameFR, $without, $ingredients, $ingredientsFR, $steps, $stepsFR, $timers, $photo_file, $photo_url, $author) {
    $user = recupUserById($id_user);
    $recette = recupRecetteById($id_recette);
    if (!in_array('Chef', $user['role']) || $recette['id_auteur'] != $id_user) {
        throw new Exception('Accès refusé : vous ne pouvez pas modifier cette recette.');
    }
    if (($langue === 'fr' && (empty($nameFR) || empty($ingredientsFR) || empty($stepsFR))) || 
        ($langue === 'eng' && (empty($name) || empty($ingredients) || empty($steps)))) {
        throw new Exception('Tous les champs obligatoires doivent être remplis.');
    }
    if (empty($timers)) {
        throw new Exception('Les temps sont obligatoires.');
    }

    $photo = $recette['imageURL'];
    if ($photo_file) {
        $uploadDir = 'images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $photo = $uploadDir . basename($photo_file['name']);
        move_uploaded_file($photo_file['tmp_name'], $photo);
    } elseif (!empty($photo_url)) {
        $photo = $photo_url;
    }

    modifierRecette($id_recette, $langue, $name, $nameFR, $without, $ingredients, $ingredientsFR, $steps, $stepsFR, $timers, $photo, $author);
    echo json_encode(['success' => true]);
}

function CtlModifRecette($id_recette,$langue,$nomR,$without, $ingredients,  $steps,$index){
    modifRecette($id_recette,$langue, $nomR,$without, $ingredients,$steps,$index);

}

function CtlAjoutRecette($langue, $nomR,$without, $ingredients,$steps, $div, $id_user,$photo_url){
    error_log("ok");
    ajoutRecette($langue, $nomR,$without, $ingredients,$steps, $div,$id_user,$photo_url);
}

function CtlValiderOuSupRecette($id_recette,$valider){
    validerOuSupRecette($id_recette,$valider);
}

function  CtlSuprimerIngrStepModif($type,$index, $id_recette){
    suprimerIngrStepModif($type,$index, $id_recette);
}

?>