<?php

function afficherAccueil($user) {
    $contenu="";
    $contenu .= '<div>
    <input type="text" name="id" value="'.$user['id'].'">
    </div>';
require_once('accueilUsers.php');
}