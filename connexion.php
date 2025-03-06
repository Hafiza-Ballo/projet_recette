<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page de connexion</title>
        <link rel="stylesheet" href="connexion.css" type="text/css">
    </head>
    <body>
        <div>
            <form class="connexion" method="post" action="accueilcontroller.php">
                <h1>Connexion</h1>
                <br>
                <label for="mail_c">Adresse mail: </label>
                <input id="mail_c" name="mail_c" type="email" required>
                <br>
                <label for="mdp_c">Mots de passe: </label>
                <input id="mdp_c" name="mdp_c" type="password" required>
                <br><br>
                <button type="submit">Se connecter</button>
                <br><br>
                <p>Vous n'avez pas de compte? <a href="inscription.php">Inscription</a></p>
            </form>
        </div>
    </body>
</html>