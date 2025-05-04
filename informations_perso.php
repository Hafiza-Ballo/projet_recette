<!DOCTYPE html>
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
    body {
        background-color: #f4f5ec;
        font-family: 'Poppins', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
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

    .principale_ensemble {
        width: 80%;
        max-width: 1000px;
        margin: 100px auto 40px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
    }
    
    .container.mt-5 {
        padding: 0;
    }
    
    h2 {
        color: #faab66;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 2rem;
        text-align: center;
    }
    
    .form-label {
        font-weight: 500;
        color: #333;
        display: block;
        margin-bottom: 8px;
    }
    
    .mb-3 {
        margin-bottom: 20px;
    }
    
    .btn-primary {
        background-color: #ED4B5B;
        border: none;
        padding: 10px 25px;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #d43f4e;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(237, 75, 91, 0.3);
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
    
    ul {
        padding-left: 20px;
        list-style: none;
    }
    
    
    ul li::marker {
        content: "•";
        color: #faab66;
        font-weight: bold;
        display: inline-block;
        width: 1em;
    }
    ul li::before{
        margin-left: 10px;
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
    
    /* Styles pour les champs éditables */
    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
        transition: border-color 0.3s ease;
    }
    
    input[type="text"]:focus, input[type="email"]:focus {
        outline: none;
        border-color: #faab66;
        box-shadow: 0 0 0 2px rgba(250, 171, 102, 0.2);
    }
    .mb-3 {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .form-label {
        font-weight: 500;
        color: #333;
        margin-bottom: 0;
        min-width: 100px;
        text-align: right;
    }

    input[type="text"], 
    input[type="email"],
    select {
        flex: 1;
        max-width: 300px;
        padding: 10px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }
</style>
    </head>

    <body>
            
        <section class="haut">
        <?php
                echo $retourBtn;
            ?>
            <div id="ensemble_recherche">
                <input id="recherche_input" placeholder="recherche">
                <?php
                echo $rechercheBtn;
            ?>
            </div>
            <div>
                <form class="choix_langue">
                    <select name="">
                        <option value="fr" id="t">Fr </option>
                        <option value="eng" > Eng</option>

                    </select>
                </form>
                
                
                <button id="mon_compte" onclick="affichage_conteneur_modif()">
                    <img src="images/user-solid.svg" alt="user" id="user_mc"><?php echo $langue == 'fr' ? 'Mon compte' : 'My account'; ?>
                </button>                
            <div class="conteneur_modif_c">
                    <?php
                    echo $infosBtn;
                    ?>
                <a><img src="images/arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img"><?php echo $langue=='fr' ? 'Déconnexion' : 'Deconnexion' ; ?></a>
                </div>
                
    
            </div>
        </section>
        <section class="principale_ensemble">
        <div class="container mt-5">
    <h2>Mes Informations</h2>
    <form id="infoForm">
        <div id="statut" class="fixed-top"></div>
        <?php echo $id_user; ?>

        <!-- Champs éditables -->
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <?php echo $nom; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <?php echo $prenom; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <?php echo $mail; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Statut</label>
                <ul>
                    <?php echo $roles; ?>
                </ul>
            </div>
        
        
        <?php echo $demandeRoles?>

        <div class="mb-3" style="justify-content: flex-end; margin-top: 30px;">
            <button type="button" onclick="modifInfo()" class="btn btn-primary">
                Enregistrer
            </button>
        </div>
    </form>
</div>
</section>
    </body>
</html>