<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page de connexion</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="jquery-3.7.1.js"></script>
    <script src="affichage.js"> </script>
    <style>
        .inscription{
                border-radius: 2px;
                border: solid 1px rgb(164, 163, 163);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                box-sizing: content-box;
                width: 50%;
                height: 80%;
                margin-top: 5%;
                margin-left: 25%;
                padding-bottom: 1%;
            }
            fieldset{
                margin-left: 20%;
            }
        
            h1 {
                text-align: center;
                color: #faab66;
                font-weight: 700;
                margin-bottom: 20px;
                font-size: 2.2rem;
            }
            #btn_connexion{
                background-color: #faab66;
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 20px;
                cursor: pointer;
                font-family: 'Poppins', sans-serif;
                font-weight: 500;
                transition: all 0.3s ease;
                margin: 4% 28%;
            }
            #btn_connexion:hover{
                background-color: #e89a50;
                transform: translateY(-2px);
                box-shadow: 0 3px 10px rgba(250, 171, 102, 0.3);
            }
            input{
                margin-bottom: 2%;
            }
            .label_style{
                width: 23%;
                text-align: right;
            }
            #role{
                width: 30%;
                margin-bottom: 2%;
                height: 30px;
            }
            p{
                margin-top: 4%;
                margin-left: 12%;
            }
            a{
                color: #ED4B5B;
            }
            #div_checkbox{
                margin-left: 24%;
                margin-top: 2%;
            }
            body{
                background-color: rgb(244, 245, 236);
            }
            .choix_langue{
                position:fixed;
                right:5px;
                top: 5px;
            }
            .choix_langue select {
                padding: 5px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
    </style>

    </head>
    <body>
    <?php $langue = $_SESSION['langue'] ?? 'fr';?>
        <section class="haut">
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
        </div>
        </section>
    
        <form class="inscription" method="post" action="controllerfrontal.php">
            <h1>Inscription</h1><br>
            <fieldset>
                <div>
                    <label for="nom" class="label_style"><?php echo $langue =='fr' ? 'Nom': 'Last name' ; ?>: </label>
                    <input id="nom" name="nom" type="text" required>
                </div>
                
                <div>
                    <label for="prenom" class="label_style"><?php echo $langue =='fr' ? 'Prénom' : 'First name'; ?>: </label>
                    <input id="prenom" name="prenom" type="text" required><br>
                </div>

                <div>
                    <label for="mail" class="label_style" ><?php echo $langue =='fr' ? 'Adresse mail': 'Mail Adress'; ?>: </label>
                    <input id="mail" name="mail" type="email" required>
                </div>

                <div>
                    <label for="role" class="label_style" >Role: </label>
                    <select id="role" name="role">
                        <option value=""><?php echo $langue =='fr' ? 'Defaut' : 'Default'; ?></option>
                        <option value="DemandeTraducteur"><?php echo $langue =='fr' ? 'DemandeTraducteur' : 'TranslatorResquest' ; ?></option>
                        <option value="DemandeChef"><?php echo $langue =='fr' ? 'DemandeChef': 'ChefRequest' ; ?></option>
                    </select>
                </div>

                <div>
                    <label for="mdp" class="label_style" ><?php echo $langue =='fr' ? 'Mot de passe' : 'Password' ; ?>: </label>
                    <input id="mdp" name="mdp" type="password" >
                </div>
                
               

                <input id="btn_connexion" type="submit" value="Inscription" name="inscription">
                <p><?php echo $langue =='fr' ? 'Vous avez déja un compte': 'Do you already have an account' ; ?>? <a href="controllerfrontal.php?page=connexion">Connexion</a></p>
                
            </fieldset>
        </form>
    </body>
    
</html>