<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Proposer une recette</title>
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
        .form-container {
            width: 80%;
            max-width: 800px;
            margin: 100px auto 40px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #faab66;
            text-align: center;
        }
        .form-control {
            margin-bottom: 15px;
        }
        .btn-submit {
            background-color: #ED4B5B;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 20px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #d43f4e;
        }
        .lang-fr, .lang-eng {
            display: none;
        }
        .upload-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .upload-option {
            flex: 1;
            min-width: 200px;
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
    </style>
</head>
<body>
    <?php $langue = $_SESSION['langue'] ?? 'fr'; ?>
    <section class="haut">
        <button class="btn_retour" onclick="window.location.href='controllerFrontal.php?action=retour_accueil&id_user=<?php echo $_GET['id_user']; ?>'">Retour</button>
        <div id="ensemble_recherche">
            <input placeholder="Rechercher...">
            <img alt="icone_recherche" src="images/magnifying-glass-solid.svg" class="icone_recherche" onclick="redirigerRecherche(<?php echo $_GET['id_user']; ?>)">
        </div>
        <div>
            <form class="choix_langue">
                <select name="langue" onchange="changerLangue(this.value)">
                    <?php
                    if ($langue == 'fr') {
                        echo '<option value="fr" selected>Fr</option><option value="eng">Eng</option>';
                    } else {
                        echo '<option value="eng" selected>Eng</option><option value="fr">Fr</option>';
                    }
                    ?>
                </select>
            </form>
            <button id="mon_compte" onclick="affichage_conteneur_modif()">
                <img src="images/user-solid.svg" alt="user" id="user_mc">Mon compte
            </button>
            <div class="conteneur_modif_c">
                <a href="controllerFrontal.php?action=infos-perso&id_user=<?php echo $_GET['id_user']; ?>">Informations personnelles</a>
                <a><img src="images/arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img">Déconnexion</a>
            </div>
        </div>
    </section>

    <div class="form-container">
        <h1>Proposer une nouvelle recette</h1>
        <form id="proposerRecetteForm" method="post" action="controllerFrontal.php" enctype="multipart/form-data">
            
            <input type="hidden" name="id_user" value="<?php echo $_GET['id_user']; ?>">
            <input type="hidden" name="action" value="ajouter_recette">
            <div class="mb-3">
                <label for="langue" class="form-label">Langue de la recette</label>
                <select class="form-control" id="langue" name="langue" onchange="toggleLangue()">
                    <option value="fr" selected>Français</option>
                    <option value="eng">Anglais</option>
                </select>
            </div>

            <!-- Champs français -->
            <div class="lang-fr">
                <div class="mb-3">
                    <label for="nameFR" class="form-label">Nom (FR)</label>
                    <input type="text" class="form-control" id="nameFR" name="nameFR">
                </div>
                <div class="mb-3">
                    <label for="ingredientsFR" class="form-label">Ingrédients (FR, format : quantité,nom,type par ligne)</label>
                    <textarea class="form-control" id="ingredientsFR" name="ingredientsFR" rows="5" placeholder="Exemple :\n1,roti de boeuf,Viande\n2 sachets,sauce,Aide culinaire"></textarea>
                </div>
                <div class="mb-3">
                    <label for="stepsFR" class="form-label">Étapes (FR, une par ligne)</label>
                    <textarea class="form-control" id="stepsFR" name="stepsFR" rows="5"></textarea>
                </div>
            </div>

            <!-- Champs anglais -->
            <div class="lang-eng">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom (EN)</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ingrédients (EN, format : quantité,nom,type par ligne)</label>
                    <textarea class="form-control" id="ingredients" name="ingredients" rows="5" placeholder="Exemple :\n1,beef roast,Meat\n2 packages,gravy mix,Baking"></textarea>
                </div>
                <div class="mb-3">
                    <label for="steps" class="form-label">Étapes (EN, une par ligne)</label>
                    <textarea class="form-control" id="steps" name="steps" rows="5"></textarea>
                </div>
            </div>

            <!-- Champs communs -->
            <div class="mb-3">
                <label for="without" class="form-label">Sans (séparé par des virgules)</label>
                <input type="text" class="form-control" id="without" name="without" placeholder="Exemple : NoGluten, NoMilk">
            </div>
            <div class="mb-3">
                <label for="timers" class="form-label">Temps (minutes, séparé par des virgules)</label>
                <input type="text" class="form-control" id="timers" name="timers" required placeholder="Exemple : 5,10">
            </div>
            <div class="mb-3">
                <label class="form-label">Photo</label>
                <div class="upload-options">
                    <div class="upload-option">
                        <label for="photo_file">Uploader un fichier :</label>
                        <input type="file" class="form-control" id="photo_file" name="photo_file" accept="image/*">
                    </div>
                    <div class="upload-option">
                        <label for="photo_url">Ou entrer une URL :</label>
                        <input type="text" class="form-control" id="photo_url" name="photo_url" placeholder="Exemple : https://example.com/image.jpg">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-submit">Ajouter la recette</button>
        </form>
    </div>

    <script>
        

        changerLangue2();
    </script>
</body>
</html>