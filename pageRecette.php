<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?php echo $nom ?></title>
    <link rel="stylesheet" href="connexion.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="jquery-3.7.1.js"></script>
    <script src="affichage.js"></script>
    <style>
        body {
            background-color: #f4f5ec;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .haut {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: #fff;
        padding: 15px 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
    }
    #ensemble_recherche {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 auto;
    }
    #ensemble_recherche input {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
    }
    .icone_recherche {
        height: 20px;
        width: 20px;
    }
    .choix_langue {
        position: absolute;
        right: 15%;
        top: 20px;
    }
    .choix_langue select {
        padding: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    #mon_compte {
        right: 20px;
        top: 10px;
        background-color: transparent;
        border: none;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 16px;
        cursor: pointer;
    }
    #user_mc {
        height: 25px;
        width: 25px;
    }
    .conteneur_modif_c {
        visibility: hidden;
        background-color: #fff;
        border-radius: 10px;
        width: 200px;
        padding: 15px;
        position: fixed;
        right: 20px;
        top: 50px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .conteneur_modif_c a {
        display: block;
        margin: 10px 0;
        color: #ED4B5B;
        text-decoration: none;
    }
    #deconnexion_img {
        height: 20px;
        width: 20px;
        vertical-align: middle;
        margin-right: 5px;
    }
        .page_recette {
            width: 80%;
            max-width: 1000px;
            margin: 100px auto 40px auto;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #ED4B5B;
            font-weight: 700;
            margin-bottom: 20px;
        }
        .recette_principale {
           
            text-align: center;
        }
        #carouselRecette {
            width: 400px; 
            height: 400px; 
            margin: 0 auto; 
            overflow: hidden; 
            border-radius: 10px; 
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); 
        }
        #carouselRecette .carousel-item img {
                    width: 100%;
                    height: 400px;
                    object-fit: cover;
                }
        .img_sec {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px; 
        }
        .content {
            min-width: 300px;
            text-align: left; 
        }
        h4 {
            color:#ED4B5B;
            margin-top: 20px;
            font-weight: 600;
        }
        ul {
            padding-left: 20px;
            list-style: circle;
        }
        li {
            margin: 10px 0;
            line-height: 1.6;
        }
        .btn_like {
            border: none;
            background: transparent;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        .btn_like:hover {
            transform: scale(1.1);
        }
        .like, .dislike {
            width: 30px;
            height: 30px;
            transition: opacity 0.3s ease;
        }
        .like {
            display: block;
        }
        .dislike {
            display: none;
        }
        .btn_retour {
    
    bottom: 20px;
    left: 20px;
    background-color: #ED4B5B;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    font-family: 'Poppins', sans-serif;
    font-size: 16px;
    transition: background-color 0.3s ease;
    z-index: 1000;
}
.btn_retour:hover {
    background-color: #d43f4e;
}
        #box_preparation {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }
        i {
            color: #777;
            font-size: 0.9em;
        }
        .trad{
            width: 70%;
        }
        #btn_traduire{
            visibility: visible;
            display:block;
        
        }
        
    </style>
</head>
<body>
<section class="haut">
<?php
            $langue = $_SESSION['langue'] ?? 'fr';
                echo $retourBtn;
            ?>
            <div id="ensemble_recherche">
                <input placeholder="recherche">
                <img alt="icone_recherce" src="images\magnifying-glass-solid.svg" class="icone_recherche"> 
            </div> 
            <div>
                <form class="choix_langue">
                    <select name="langue" onchange="changerLangue(this.value)">
                    <?php if ($langue=='fr'){
                                echo '<option value="fr" id="t" >Fr </option>
                                <option value="eng" > Eng</option>';
                            }
                            else{
                                echo '<option value="eng" > Eng</option>
                                <option value="fr" id="t" >Fr </option>
                                ';
                            }  ?>                  
                    </select>
                </form>
            
                <?php echo $langue=='fr' ? '<button id="mon_compte" onclick="affichage_conteneur_modif()"><img src="images/user-solid.svg" alt="user" id="user_mc">Mon compte</button>' : '<button id="mon_compte" onclick="affichage_conteneur_modif()"><img src="images/user-solid.svg" alt="user" id="user_mc">My account</button>'; ?>
                <!--<button id="mon_compte" onclick="affichage_conteneur_modif()"><img src="images/user-solid.svg" alt="user" id="user_mc">Mon compte</button>-->
                <div class="conteneur_modif_c">
                    <a href="informations_perso.php">Informations personnelles</a><br>
                    <a><img src="arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img">Deconnexion</a>
                </div>
                
    
            </div>
</section>
    <section class="page_recette">
        <h1><?php echo $nom; ?></h1>
        

        <div class="recette_principale">

            <div id="carouselRecette" class="carousel slide" data-bs-ride="carousel">
                
                <div class="carousel-inner">
                    <?php foreach ($images as $index => $image): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo $image; ?>" class="d-block w-100 img_sec" alt="recette">

                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselRecette" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselRecette" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
            <div class="content">
                <div>
                    <?php echo $liker_; ?>
                </div>
                <?php echo $contenu; ?>
            </div>
        </div>
        <input type="file" id="photoInput">
        <input type="text" id="photoUrl" placeholder="Ou entrez une URL">
        <button id="btn_like" onclick="ajouterPhoto(<?php echo  $id_user . ',' . $id_recette ?>)"><?php echo $langue =='fr' ? 'Ajouter' : 'Add'; ?></button>
        <div id="statut" class="fixed-top"></div>
    </section>
    
</body>
</html>