<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page de connexion</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </head>
    <body>
    
        <form class="inscription" method="post" action="controllerfrontal.php">
            <h1>Inscription</h1><br>
            <fieldset>
                <div>
                    <label for="nom">Nom: </label>
                    <input id="nom" name="nom" type="text" required>
                </div>
                
                <div>
                    <label for="prenom">Prénom: </label>
                    <input id="prenom" name="prenom" type="text" required><br>
                </div>

                <div>
                    <label for="mail">Adresse mail: </label>
                    <input id="mail" name="mail" type="email" required>
                </div>

                <div>
                    <label for="role">Role</label>
                    <select id="role" name="role">
                        <option value="">Defaut</option>
                        <option value="DemandeTraducteur">DemandeTraducteur</option>
                        <option value="DemandeChef">DemandeChef</option>
                    </select>
                </div>

                <div>
                    <label for="mdp">Mot de passe: </label>
                    <input id="mdp" name="mdp" type="password" >
                </div>
                
                <div>
                    <input id="isCuisinier" type="checkbox" name="isCuisinier" value="accepter"> 
                    <label for="isCuisinier">Etes vous cuisinier ?</label>
                </div>

                <input type="submit" value="Inscription" name="inscription">
                <p>Vous avez deja un compte? <a href="connexion.php">Connexion</a></p>
                
            </fieldset>
        </form>
    </body>
    
</html>