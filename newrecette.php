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
    <style></style>
</head>
<body>
<?php $langue = $_SESSION['langue'] ?? 'fr'; ?>
    <section class="haut">
        <button class="btn_retour" onclick="window.location.href='controllerFrontal.php?action=retour_accueil&id_user=<?php echo $_GET['id_user']; ?>'"><?php echo $langue == 'fr' ? 'Retour' : 'Go back'; ?></button>
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

                <?php if($langue=='fr'){
                        echo '<option value="fr" selected>Français</option>
                                <option value="eng">Anglais</option>';
                    }
                    else{
                        echo '<option value="eng" selected>English</option>
                                <option value="fr">French</option>';
                    }
                ?>
                </select>
            </div>

            <!-- Champs français -->
            <div class="lang-fr">
                <div class="mb-3">
                    <label for="nameFR" class="form-label"><?php echo $langue=='fr' ? 'Nom' : 'Name'; ?></label>
                    <input type="text" class="form-control" id="nameFR" name="nameFR">
                </div>
                <div class="mb-3">
                    <label for="ingredientsFR" class="form-label"><?php echo $langue=='fr' ?'Ingrédients': 'Ingredients'; ?> (FR, format : quantité,nom,type par ligne)</label>
                    <textarea class="form-control" id="ingredientsFR" name="ingredientsFR" rows="5" placeholder="Exemple :\n1,roti de boeuf,Viande\n2 sachets,sauce,Aide culinaire"></textarea>
                </div>
                <div class="mb-3">
                    <label for="stepsFR" class="form-label"> <?php echo $langue=='fr' ?'Étapes': 'Steps'; ?> (FR, une par ligne)</label>
                    <textarea class="form-control" id="stepsFR" name="stepsFR" rows="5"></textarea>
                </div>
            </div>
</body>