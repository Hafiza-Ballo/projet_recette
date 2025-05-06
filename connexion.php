<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page de connexion</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="jquery-3.7.1.js"></script>
        <script src="affichage.js"> </script>
        <style>
            .connexion{
                text-align: center;
                border-radius: 2px;
                border: solid 1px rgb(164, 163, 163);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                box-sizing: content-box;
                width: 40%;
                height: 80%;
                margin-top: 10%;
                margin-left: 30%;
                padding-bottom: 1%;
            }
            h1 {
                text-align: center;
                color: #faab66;
                font-weight: 700;
                margin-bottom: 30px;
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
                margin: 0 5px;
            }
            #btn_connexion:hover{
                background-color: #e89a50;
                transform: translateY(-2px);
                box-shadow: 0 3px 10px rgba(250, 171, 102, 0.3);
            }
            input{
                margin-bottom: 4%;
            }
            p{
                margin-top: 4%;
            }
            a{
                color: #ED4B5B;
            }
            body{
                background-color: rgb(244, 245, 236);
            }
            
            .choix_langue{
                position:fixed;
                right: 5px;
                top: 5px
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

        <div>
            <form class="connexion" method="post" action="controllerfrontal.php">
                <h1>Connexion</h1>
                <div>
                    <label for="mail"><?php echo $langue =='fr' ? 'Adresse mail' : 'Mail adress' ;?>: </label>
                    <input id="mail" name="mail" type="email" required>
                </div>

                <div>
                    <label for="mdp"><?php echo $langue =='fr' ? 'Mot de passe' : 'Password' ; ?> : </label>
                    <input id="mdp" name="mdp" type="password" required>
                </div>
                <input id="btn_connexion" type="submit" value="Connexion" name="connexion">
                <p><?php echo $langue =='fr' ? 'Vous n\'avez pas de compte': 'Don\'t have an account' ; ?>? <a href="controllerfrontal.php?page=inscription">Inscription</a></p>
            </form>
        </div>
    </body>
</html>