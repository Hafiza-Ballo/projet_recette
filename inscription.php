<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Page de connexion</title>
    </head>
    <body>
        <form class="inscription" method="post" action="accueilcontroller.php">
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
                    <input id="mdp" name="mdp" type="password" required>
                </div>
                
                <div>
                    <input id="isCuisinier" type="checkbox" name="isCuisinier" value="accepter"> 
                    <label for="isCuisinier">Etes vous cuisinier ?</label>
                </div>
                
                <p>Vous avez deja un compte? <a href="connexion.php">Connexion</a></p>
                <button type="submit">S'inscrire</button>
            </fieldset>
        </form>
    </body>
</html>