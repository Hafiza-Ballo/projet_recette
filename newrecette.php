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
        /* Section d'ajout de photos */
        .photo-upload-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .photo-upload-section h5 {
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
        h5 {
            color: #faab66;
            margin-top: 25px;
            font-weight: 600;
            font-size: 1.4rem;
            border-bottom: 2px solid #faab6677;
            padding-bottom: 5px;
        }
        .autre_proposition{
            display: inline-block;
            margin-top: 2%;
        }
        
        .boxIngr, .boxStep{
            border: solid 0.5px #ccc;
            border-radius: 5px;
            margin-bottom: 2%;
            box-shadow: 2.5px 2.5px 0px #ccc;
            
        }
        
        .st_ligne{
            display: flex;
            align-items: center;     /* aligne verticalement le label et le textarea */
            gap: 8px;                /* espace entre eux */
            margin-bottom: 10px;
        }
        .step, .without{
            height: 30px;
            min-height: 0;
            width: 60%;
        }
    </style>
</head>
<body>
<?php $langue = $_SESSION['langue'] ?? 'fr'; ?>
    <section class="haut">
        <button class="btn_retour" onclick="window.location.href='controllerFrontal.php?action=retour_accueil&id_user=<?php echo $_GET['id_user']; ?>'"><?php echo $langue == 'fr' ? 'Retour' : 'Go back'; ?></button>
        <div id="ensemble_recherche">
            <input placeholder="<?php echo $langue=='fr' ? 'Rechercher' : 'Search'; ?>...">
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
                <img src="images/user-solid.svg" alt="user" id="user_mc"><?php echo $langue=='fr' ? 'Mon compte':' My account'; ?>
            </button>
            <div class="conteneur_modif_c">
                <a href="controllerFrontal.php?action=infos-perso&id_user=<?php echo $_GET['id_user']; ?>"><?php echo $langue=='fr' ? 'Informations personnelles': 'Personal information'; ?></a>
                <a href="controllerFrontal.php?action=deconnexion"><img src="arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img"><?php echo $langue=='fr' ? 'Déconnexion' : 'Deconnexion' ; ?></a>
                </div>
        </div>
    </section>
    <div class="form-container">
        <h1><?php echo $langue=='fr' ? 'Proposer une nouvelle recette' : 'Suggest a new recipe'  ;?></h1>

        <div id="AjoutRecette">
                <h5><?php echo $langue=='fr' ? 'Nom recette' : 'Recipe name' ;?></h5><input type="text" class="nomR "  ><br>
                <h5><?php echo $langue=='fr' ? 'Spécificité' : 'Specificity' ;?></h5><textarea type="text" class="without " ></textarea><br>
                <h5><?php echo $langue=='fr' ? 'Ingrédients' : 'Ingredients' ;?></h5>
                <div id="containerIngr">
                    <div id="nouvelIngr" class="proposerIngr">
                        <div class="boxIngr">
                            <label><?php echo $langue=='fr' ? 'Quantité': 'Quantity'; ?>: </label><input class="quantite"  type="text"><br>
                            <label><?php echo $langue=='fr' ? 'Nom': 'Name'?>: </label><input class="nomI"  type="text"><br>
                            <label>Type: </label><input class="type"  type="text" ><br>
                            <button onclick="autreIngr(langue,'Ingr')" class="autre_proposition" type="submit"><?php echo $langue=='fr' ? 'Autre ingrédient': 'Other ingredient'; ?></button>
                        </div>
                    </div> 
                </div> 
                <h5>Etapes</h5>
                <div id="containerStep">
                    <div  id="nouvelStep" class="proposerStep">
                        <div class="boxStep">
                            <span class="st_ligne"><label id="st"><?php echo $langue=='fr' ? 'Etape' : 'Step' ;?>: </label><textarea class="step long"  type="text" ></textarea><br></span>
                            <label><?php echo $langue=='fr' ? 'Temps' : 'Time' ; ?>(minute): </label><input class="temps"  type="number" value="0" ><br>
                            <button onclick="autreIngr(langue,'Step')" class="" type="submit"><?php echo $langue=='fr' ? 'Autre étape': 'Other step'; ?></button>

                        </div>
                    </div>  
                </div>
        </div>
        <div class="photo-upload-section">
                <h5>Photo</h5>
                <div class="upload-options">
                    <div class="upload-option">
                        <label for="photo_url"><?php echo $langue=='fr' ? 'Entrez une URL :' : 'Enter a URL :' ;?></label>
                        <input type="text" class="form-control" id="photo_url" name="photo_url" placeholder="<?php echo $langue=='fr' ? 'Exemple' : 'Example' ;?> : https://example.com/image.jpg">
                    </div>
                </div>
        </div>
        <button onclick="AjouterRecette(langue)" class="btn_submit" type="submit"><?php echo $langue=='fr' ? 'Créer recette' : 'Create recipe'; ?></button>
        
    </div>
    <script>
        const langue = "<?php echo $langue; ?>";
        const id_u="<?php echo $id_user; ?>";
        
    </script>
</body>