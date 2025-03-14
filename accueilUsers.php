<!doctype html>
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
                height: 40%;
                width: 40%;
            }
            .principale_ensemble{
                width: 70%;
                background-color: white;
                border-radius: 5px;
                margin-left: 20%;
                text-align:center;
                padding-top: 2%;
            }
            .like{
                display:block;
                height: 100%;
                width: 100%;
            }
            .dislike{
                display:none;
                height: 100%;
                width: 100%;
            }
            .btn_like{
                width: 5%;
                border: none;
                background-color: transparent;
                vertical-align: middle;
            }
            #voir_r{
                background-color: #ED4B5B;
                color: white;
                border: none;
                border-radius: 5px;
            }
            a{
                text-decoration: none;
                color: #ED4B5B;
            }
            .icone_recherche{
                height:2%;
                width: 2%;
            
            }
            .hat{
                position:fixed;
                top:0;
            }
            #user_mc{
                height: 15%;
                width:15%;
            }
            #mon_compte{
                position:fixed;
                right: 1%;
                top:0;
                border: none;
                background-color:white;
                width: 10%;
                float: right;
            }
            #t{
                background-color: yellow;
            }
            .conteneur_modif_c{
                visibility: hidden;
                background-color: white;
                border: none;
                border-radius: 5px;
                width: 20%;
                padding-bottom: 2%;
                position:fixed;
                right: 1%;
                top:5%;
            }
            #deconnexion_img{
                height: 8%;
                width:8%;
                vertical-align: middle;
            }
            .choix_langue{
                top: 0;
                right: 15%;
            }
            
        </style> 
    </head>

    <body>
            
        <section class="haut">
            <div id="ensemble_recherche">
                <input placeholder="recherche">
                <img alt="icone_recherce" src="images\magnifying-glass-solid.svg" class="icone_recherche"> 
            </div> 
            <div>
                <form class="choix_langue">
                    <select name="">
                        <option value="fr" id="t">Fr </option>
                        <option value="eng" > Eng</option>

                    </select>
                </form>
                
                
                <button id="mon_compte" onclick="affichage_conteneur_modif()"><img src="images/user-solid.svg" alt="user" id="user_mc">Mon compte</button>
                <div class="conteneur_modif_c">
                    <a href="informations_perso.php">Informations personnelles</a><br>
                    <a><img src="arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img">Deconnexion</a>
                </div>
    
            </div>
        </section>
        <section class="principale_ensemble">';
        <?php
        echo $contenu;
        ?>
        </section>
    </body>
</html>';


?>