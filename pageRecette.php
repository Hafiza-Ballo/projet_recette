<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?php echo $nom ?></title>
    <link rel="stylesheet" href="connexion.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="jquery-3.7.1.js"></script>
    <script src="affichage.js"></script>
    
<style>
    body {
        background-color: #f4f5ec;
        font-family: 'Poppins', sans-serif;
        color: #333;
        line-height: 1.6;
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
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 30px;
        width: 250px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }
    
    #ensemble_recherche input:focus {
        outline: none;
        border-color: #faab66;
        box-shadow: 0 0 0 2px rgba(250, 171, 102, 0.2);
    }
    
    .icone_recherche {
        height: 20px;
        width: 20px;
        cursor: pointer;
    }
    
    .choix_langue {
        position: absolute;
        right: 15%;
        top: 20px;
    }
    
    .choix_langue select {
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-family: 'Poppins', sans-serif;
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
        color: #333;
        transition: color 0.3s ease;
    }
    
    #mon_compte:hover {
        color: #ED4B5B;
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
        transition: color 0.3s ease;
        padding: 5px 0;
    }
    
    .conteneur_modif_c a:hover {
        color: #d43f4e;
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
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }
    
    h1 {
        text-align: center;
        color: #faab66;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 2.2rem;
    }
    
    .recette_principale {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    #carouselRecette {
        width: 100%;
        max-width: 500px;
        height: 400px;
        margin: 0 auto 30px;
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
        height: auto;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .content {
        width: 100%;
        text-align: left;
    }
    
    h4 {
        color: #faab66;
        margin-top: 25px;
        font-weight: 600;
        font-size: 1.4rem;
        border-bottom: 2px solid #faab6677;
        padding-bottom: 5px;
    }
    
    
    
    ul, ol {
        padding-left: 25px;
    }
    
    .ingredients {
        list-style: none;
    }
    
    .ingredients li::before {
        content: "•";
        color: #faab66;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
    
    li {
        margin: 12px 0;
        line-height: 1.6;
    }
    .btn_like {
        border: none;
        background: transparent;
        cursor: pointer;
        transition: transform 0.2s ease;
        margin: 20px 0;
    }
    
    .btn_like:hover {
        transform: scale(1.1);
    }
    
    .like, .dislike {
        width: 35px;
        height: 35px;
        transition: opacity 0.3s ease;
    }
    
    .like {
        display: block;
    }
    
    .dislike {
        display: none;
    }
    
    .btn_retour {
                position: fixed;
                bottom: 20px;
                left: 20px;
                background-color: #ED4B5B;
                color: white;
                border: none;
                border-radius: 30px;
                padding: 10px 20px;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
                font-size: 16px;
                transition: all 0.3s ease;
                z-index: 1000;
                box-shadow: 0 3px 10px rgba(237, 75, 91, 0.3);
            }
    
    .btn_retour:hover {
        background-color: #d43f4e;
        transform: translateY(-2px);
    }
    
    i {
        color: #777;
        font-size: 0.9em;
    }
    
    .comment-section {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }
    
    .comment-section a {
        display: inline-block;
        margin-bottom: 15px;
        color: #ED4B5B;
        text-decoration: none;
        font-weight: 500;
    }
    
    .comment-section a:hover {
        text-decoration: underline;
    }
    
    .comment-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 15px;
        font-family: 'Poppins', sans-serif;
        resize: vertical;
        min-height: 100px;
        transition: border-color 0.3s ease;
    }
    
    .comment-input:focus {
        outline: none;
        border-color: #faab66;
        box-shadow: 0 0 0 2px rgba(250, 171, 102, 0.2);
    }
    
    .comment-btn {
        background-color: #ED4B5B;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .comment-btn:hover {
        background-color: #d43f4e;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(237, 75, 91, 0.3);
    }
    
    .modal-content {
        padding: 20px;
        border-radius: 10px;
        border: none;
    }
    
    .modal-header {
        border-bottom: 1px solid #eee;
    }
    
    .modal-title {
        color: #faab66;
        font-weight: 600;
    }
    
    .comment-list {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .comment-item {
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }
    
    .comment-item:last-child {
        border-bottom: none;
    }
    
    .comment-author {
        font-weight: 600;
        color: #ED4B5B;
        margin-bottom: 5px;
    }
    
    .comment-date {
        font-size: 0.8em;
        color: #777;
        margin-left: 10px;
    }
    
    .comment-text {
        margin-top: 5px;
    }
    
    /* Section d'ajout de photos */
    .photo-upload-section {
        margin-top: 30px;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .photo-upload-section h4 {
        margin-top: 0;
        margin-bottom: 15px;
    }
    
    .upload-options {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .upload-option {
        flex: 1;
        min-width: 200px;
    }
    
    .upload-option label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }
    
    #photoInput {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
    }
    
    #photoUrl {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
    }
    
    #btn_like {
        background-color: #faab66;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        transition: all 0.3s ease;
        display: block;
        margin: 15px auto 0;
    }
    
    #btn_like:hover {
        background-color: #e89a50;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(250, 171, 102, 0.3);
    }
    
    #statut {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 10px 20px;
        border-radius: 30px;
        background-color: #ED4B5B;
        color: white;
        z-index: 1100;
        opacity: 0;
        transition: opacity 0.3s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    #statut.show {
        opacity: 1;
    }
    #box_preparation {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        margin: 10px 0;
    }
    
    .trad{
        width: 70%;
    }
    #btn_traduire{
        visibility: visible;
        display:block;
    
    }
    .trad_input_ingredients{
        width: max-content;
    }
    .steps{
        position: relative;
        list-style: none;
        padding-left: 30px;
        margin: 0;
    }
    .steps li {
        position: relative;
        margin-bottom: 30px;
        padding-left: 2%;
        
    }

    .steps li::before {
        content: "";
        position: absolute;
        left: -5px;
        top: 0;
        width: 15px;
        height: 15px;
        background-color: #faab66;
        box-shadow: 2px 2px 0px #bab5f8;
        box-shadow: 2px 2px 0px #bab5f8;
        border-radius: 50%;
    }

    .steps li::after {
        content: "";
        position: absolute;
        left: 4px;
        top: 15px;
        width: 2px;
        height: calc(100% + 20px); /* pour relier au suivant */
        background-color: #ccc;
    }

    .steps li:last-child::after {
    display: none;
    }
    button{
        border:solid 2px #ED4B5B;
        border-radius: 5px;
        background-color: white;
        padding: 5px 10px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        color: #ED4B5B;
    }
    button:hover{
        background-color: #ED4B5B;
        color: #fff;
    }
    #lettre{
        border:solid 1.5px #ED4B5B;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 3%;
        height: 5%;
        color:#ED4B5B;

    }
    .prep{
        height: 6%;
        width: 4%;
    }
    
    /*.box_traduction{
        border:solid 1px gainsboro;
        border-radius: 4px;
        margin-left: 30%;
        max-width: max-content;
        width: 100%;
    }*/
    
        
    </style>
</head>
<body>
    <?php $langue = $_SESSION['langue'] ?? 'fr';?>

    <section class="haut">
        <?php echo $retourBtn; ?>
        <div id="ensemble_recherche">
            <input placeholder="Rechercher...">
            <img alt="icone_recherche" src="images/magnifying-glass-solid.svg" class="icone_recherche"> 
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
                <?php echo $infosBtn; ?>
                <a><img src="arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img">Déconnexion</a>
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
                
                <div class="photo-upload-section">
                    <h4>Ajouter une photo</h4>
                    <div class="upload-options">
                        <div class="upload-option">
                            <label for="photoInput">Télécharger depuis votre appareil :</label>
                            <input type="file" id="photoInput" accept="image/*">
                        </div>
                        <div class="upload-option">
                            <label for="photoUrl">Ou via une URL :</label>
                            <input type="text" id="photoUrl" placeholder="https://example.com/image.jpg">
                        </div>
                    </div>
                    <button id="btn_like" onclick="ajouterPhoto(<?php echo $id_user . ',' . $id_recette ?>)">Ajouter une photo</button>
                </div>
                
                <div class="comment-section">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#commentModal">Voir les avis</a>
                    <textarea class="comment-input" id="commentText" placeholder="Partagez votre expérience avec cette recette..."></textarea>
                    <button class="comment-btn" onclick="posterCommentaire(<?php echo $id_user . ',' . $id_recette; ?>)">Poster un commentaire</button>
                </div>
            </div>
        </div>
        <div id="statut"></div>
    </section>
    
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentModalLabel">Avis sur <?php echo $nom; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body comment-list" id="commentList">
                    <!-- Les commentaires seront chargés ici -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $('#commentModal').on('show.bs.modal', function () {
            chargerCommentaires(<?php echo $id_recette; ?>);
        });
    </script>
</body>
</html>