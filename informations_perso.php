<?php
session_start();

/*if (isset($_POST['id_user']) && isset($_POST['roleAjoute']) ){
    $role=$_POST['roleAjoute'];

    $id_user=$_POST['id_user'];
    var_dump( $_SESSION['role']);
    $f = fopen('utilisateurs.json', 'r+');
    if (!flock($f, LOCK_EX)){
        http_response_code(409);
    }

    $jsonString = fread($f, filesize('utilisateurs.json'));
    $data = json_decode($jsonString, true); 
    foreach($data as $index=> $u){
        
        if($u['id']==$id_user){
            echo 'i  ';
            if(!in_array($role, $data[$index]['role'])){
                $data[$index]['role'][] = $role;
                $_SESSION['role']=$data[$index]['role'];
                var_dump($data[$index]['role']);
                
            }
            else{
                echo 'Role existe deja';
            }
            $data[$index]['role'][] = $role;
            $_SESSION['role']=$data[$index]['role'];
            var_dump($data[$index]['role']);
            break;
            
        }
    }
    
    $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
    ftruncate($f, 0);
    fseek($f,0);
    fwrite($f, $newJsonString);
    flock($f, LOCK_UN);
    fclose($f);
}*/



$id_user= $_SESSION['idUser'];
$nom=$_SESSION['nom'];
$prenom=$_SESSION['prenom'];
$mail=$_SESSION['mail'];
$mdp=$_SESSION['mdp'];
$role=$_SESSION['role'];
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
            #supprimer{
                height:60%;
                width:40%;
            }
            .btn_supprimer:hover{
                background-color:#ED4B5B;
            }
            .btn_supprimer{
                height:40%;
                width:20%;
                border:solid 1px gray;
                background-color:white;
            }
            .container_role{
                display:flex;
            }
        </style>

        <body>
        <section>
            <label>Nom </label>
            <input type="text" value="'.$nom.'"><br>
            <label>Prenom </label>
            <input type="text" value="'.$prenom.'"><br>
            <label>Mail </label>
            <input type="email" value="'.$mail.'"><br>
            <label>Role </label>
            <section class="container_role">
                <div class="liste_role">';
                    
                    if(sizeof($role)>0){
                        echo '<ul>';
                        foreach($role as $r){
                            echo '<li>'.$r.' </li> <button class="btn_supprimer" onclick="supprimerRole()" ><img src="images/trash-solid.svg" alt="supprimer" id="supprimer" > </button>';
                        }
                    };
                    echo'</ul>
                </div>
                <div>
                    <select id="role" name="role" onchange="">
                        <option value="">Defaut</option>
                        <option value="DemandeTraducteur">DemandeTraducteur</option>
                        <option value="DemandeChef">DemandeChef</option>';
                        
                        
                    echo'   
                    </select>

                    <button onclick="ajouterRole('.$id_user.','.htmlspecialchars(json_encode($_SESSION['role'])).') "> Ajouter un role </button>
                </div>

        </section>';

echo ' </body>
</html>';
?>