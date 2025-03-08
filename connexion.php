<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page de connexion</title>
        <link rel="stylesheet" href="connexion.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <div>
            <form class="connexion" method="post" action="controllerfrontal.php">
                <h1>Connexion</h1>
                <div>
                    <label for="mail">Adresse mail: </label>
                    <input id="mail" name="mail" type="email" required>
                </div>

                <div>
                    <label for="mdp">Mot de passe: </label>
                    <input id="mdp" name="mdp" type="password" required>
                </div>
                <input type="submit" value="Connexion" name="connexion">
                <p>Vous n'avez pas de compte? <a href="inscription.php">Inscription</a></p>
            </form>
        </div>
    </body>
</html>