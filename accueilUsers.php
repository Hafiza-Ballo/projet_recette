<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page principale</title>
        <link rel="stylesheet" href="connexion.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="jquery-3.7.1.js"></script>
        <script src="affichage.js" defer></script>
        <style>
    body {
        background-color: #f4f5ec;
        font-family: 'Poppins', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
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

    .principale_ensemble {
    width: 90%;
    max-width: 1200px;
    margin: 100px auto 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    display: grid;
    grid-template-columns: repeat(2, 1fr); 
    gap: 30px;
    box-sizing: border-box; 
}
.jaime {
    display: flex;
    justify-content: center; 
    align-items: center; 
    gap: 8px; 
}
#carouselRecette {
    width: 600px; 
    height: 350px; 
    margin: 0 auto; 
    overflow: hidden; 
    border-radius: 10px; 
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); 
}

#carouselRecette .carousel-item img {
    width: 100%;
    height: 350px; 
    object-fit: cover; 
}

.carousel-item {
    height: 350px;
}
.recette_card {
    width: 100%; 
    max-width: none; 
    margin: 0; 
    background-color: #fff;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.2s ease;
    box-sizing: border-box;
}
    .recette_card:hover {
        transform: translateY(-5px);
    }
    .principale_image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    h4 {
        color: #faab66;
        margin: 10px 0;
        font-weight: 600;
    }
    .btn_like {
        border: none;
        background: transparent;
        cursor: pointer;
        transition: transform 0.2s ease;
        width: 30px;
        height: 30px;
        display: inline-block;
    }
    .btn_like:hover {
        transform: scale(1.1);
    }
    .like, .dislike {
        width: 100%;
        height: 100%;
        transition: opacity 0.3s ease;
    }
    .like {
        display: block;
    }
    .dislike {
        display: none;
    }
    #voir_r {
        background-color: #ED4B5B;
        color: white;
        border: none;
        border-radius: 5px;
        padding: 8px 15px;
        margin-top: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    #voir_r:hover {
        background-color: #d43f4e;
    }
    a {
        text-decoration: none;
        color: #ED4B5B;
    }
</style> 
    </head>

    <body>
            <?php $langue = $_SESSION['langue'] ?? 'fr';?>

        <section class="haut">
            <div id="ensemble_recherche">
                <input id="recherche_input" placeholder="recherche">
                <?php
                echo $rechercheBtn;
            ?>
            </div>
            <div>
                <form class="choix_langue">
                <select name="langue" onchange="changerLangue(this.value)">
                    <?php
                        if ($langue=='fr'){
                            echo '<option value="fr" id="t" >Fr </option>
                            <option value="eng" > Eng</option>';
                        }
                        else{
                            echo '<option value="eng" > Eng</option>
                            <option value="fr" id="t" >Fr </option>
                            ';
                        }
                    ?>
                    </select>
                </form>
                
                
                <button id="mon_compte" onclick="affichage_conteneur_modif()"><img src="images/user-solid.svg" alt="user" id="user_mc">Mon compte</button>
                <div class="conteneur_modif_c">
                    <?php
                    echo $infosBtn;
                    ?>
                    <a><img src="arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img">Deconnexion</a>
                </div>
                
    
            </div>
        </section>
        <section class="principale_ensemble">
        <?php
        echo $contenu;
        ?>
        </section>
    </body>
</html>