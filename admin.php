<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Panel Administrateur</title>
    <link rel="stylesheet" href="connexion.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="jquery-3.7.1.js"></script>
    <script src="affichage.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f5ec;
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
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

        .btn-retour {
            position: fixed;
            left: 20px;
            bottom: 20px;
            background-color: #ED4B5B;
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(237, 75, 91, 0.3);
        }

        .btn-retour:hover {
            background-color: #d43f4e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(237, 75, 91, 0.4);
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
            padding: 5px 10px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        #mon_compte:hover {
            color: #ED4B5B;
            background-color: #f9f9f9;
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

        .admin-container {
            width: 90%;
            max-width: 1200px;
            margin: 100px auto 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        h1 {
            text-align: center;
            color: #faab66;
            font-weight: 700;
            margin-bottom: 30px;
            font-size: 2.2rem;
        }

        h2 {
            color: #faab66;
            font-weight: 600;
            font-size: 1.6rem;
            margin: 30px 0 20px;
            border-bottom: 2px solid #faab6677;
            padding-bottom: 5px;
        }

        .nav-tabs {
            border-bottom: 2px solid #faab66;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            color: #333;
            font-weight: 500;
            border: none;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #ED4B5B;
            background-color: #f9f9f9;
        }

        .nav-tabs .nav-link.active {
            color: #faab66;
            background-color: #fff;
            border-bottom: 3px solid #faab66;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th {
            background-color: #f9f9f9;
            color: #333;
            font-weight: 600;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #faab66;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .table td {
            padding: 15px;
            vertical-align: middle;
        }

        .btn-action {
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

        .btn-action:hover {
            background-color: #e89a50;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(250, 171, 102, 0.3);
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .pagination button {
            background-color: #fff;
            color: #ED4B5B;
            border: 1px solid #ED4B5B;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover {
            background-color: #ED4B5B;
            color: #fff;
        }

        .pagination button:disabled {
            background-color: #eee;
            color: #999;
            border-color: #ccc;
            cursor: not-allowed;
        }
        .modal-content {
        padding: 20px;
        border-radius: 10px;
        }

        .modal-header {
            border-bottom: 1px solid #eee;
        }

        .modal-title {
            color: #faab66;
            font-weight: 600;
        }

        .form-check {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <section class="haut">
        <div>
            <button class="btn-retour" onclick="window.location.href='controllerFrontal.php?action=retour_accueil&id_user=<?php echo $user['id']; ?>'">Retour</button>
        </div>
        <div>
            <button id="mon_compte" onclick="affichage_conteneur_modif()">
                <img src="images/user-solid.svg" alt="user" id="user_mc">Mon compte
            </button>
            <div class="conteneur_modif_c">
                <a href="controllerFrontal.php?action=infos-perso&id_user=<?php echo $user['id']; ?>">Informations personnelles</a>
                <a><img src="arrow-right-from-bracket-solid.svg" alt="deconnexion" id="deconnexion_img">Déconnexion</a>
            </div>
        </div>
    </section>

    <section class="admin-container">
        <h1>Panel Administrateur</h1>

        <ul class="nav nav-tabs" >
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#users" type="button">Utilisateurs</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#recette" type="button">Recettes</button>
            </li>
        </ul>

        <div class="tab-content" >
            <div class="tab-pane fade show active" id="users">
                <h2>Gestion des utilisateurs</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Rôles</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            $nombre_par_page = 10; 
                            $page_actuelle = isset($_GET['page_users']) ? (int)$_GET['page_users'] : 1;
                            $debut = ($page_actuelle - 1) * $nombre_par_page;
                            $utilisateurs_pagine = array_slice($utilisateurs, $debut, $nombre_par_page);
                            foreach ($utilisateurs_pagine as $u): 
                            if ($user['id'] === $u['id']) continue;?>
                                <tr>
                                    <td><?php echo $u['id']; ?></td>
                                    <td><?php echo $u['nom']; ?></td>
                                    <td><?php echo $u['prenom']; ?></td>
                                    <td><?php echo $u['mail']; ?></td>
                                    <td><?php echo implode(', ', $u['role']); ?></td>
                                    <td>
                                    <button class="btn-action" onclick="modifierRoles(<?php echo $u['id']; ?>, '<?php echo implode(',', $u['role']); ?>')">Modifier rôles</button>                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <?php
                    $total_utilisateurs = count($utilisateurs);
                    $nombre_pages = ceil($total_utilisateurs / $nombre_par_page);
                    if ($page_actuelle > 1): ?>
                        <button onclick="window.location.href='controllerFrontal.php?action=admin&id_user=<?php echo $user['id']; ?>&page_users=<?php echo $page_actuelle - 1; ?>'">Précédent</button>
                    <?php else: ?>
                        <button disabled>Précédent</button>
                    <?php endif; ?>
                    <span>Page <?php echo $page_actuelle; ?> sur <?php echo $nombre_pages; ?></span>
                    <?php if ($page_actuelle < $nombre_pages): ?>
                        <button onclick="window.location.href='controllerFrontal.php?action=admin&id_user=<?php echo $user['id']; ?>&page_users=<?php echo $page_actuelle + 1; ?>'">Suivant</button>
                    <?php else: ?>
                        <button disabled>Suivant</button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tab-pane fade" id="recette">
                <h2>Gestion des recettes</h2>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom (FR)</th>
                                <th>Auteur</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            $nombre_par_page_recettes = 10; 
                            $page_actuelle_recettes = isset($_GET['page_recettes']) ? (int)$_GET['page_recettes'] : 1;
                            $debut_recettes = ($page_actuelle_recettes - 1) * $nombre_par_page_recettes;
                            $recettes_pagine = array_slice($recettes, $debut_recettes, $nombre_par_page_recettes);
                            foreach ($recettes_pagine as $r): ?>
                                <tr>
                                    <td><?php echo $r['id']; ?></td>
                                    <td><?php echo $r['nameFR']; ?></td>
                                    <td><?php echo $r['Author']; ?></td>
                                    <td><?php echo isset($r['statut']) ? $r['statut'] : 'attente'; ?></td>
                                    <td>
                                        <button class="btn-action" onclick="validerRecette(<?php echo $r['id']; ?>)">Valider</button>
                                        <button class="btn-action" onclick="modifierRecette(<?php echo $r['id']; ?>)">Modifier</button>
                                        <button class="btn-action" onclick="supprimerRecette(<?php echo $r['id']; ?>)">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination">
                    <?php
                    $total_recettes = count($recettes);
                    $nombre_pages_recettes = ceil($total_recettes / $nombre_par_page_recettes);
                    if ($page_actuelle_recettes > 1): ?>
                        <button onclick="window.location.href='controllerFrontal.php?action=admin&id_user=<?php echo $user['id']; ?>&page_recettes=<?php echo $page_actuelle_recettes - 1; ?>'">Précédent</button>
                    <?php else: ?>
                        <button disabled>Précédent</button>
                    <?php endif; ?>
                    <span>Page <?php echo $page_actuelle_recettes; ?> sur <?php echo $nombre_pages_recettes; ?></span>
                    <?php if ($page_actuelle_recettes < $nombre_pages_recettes): ?>
                        <button onclick="window.location.href='controllerFrontal.php?action=admin&id_user=<?php echo $user['id']; ?>&page_recettes=<?php echo $page_actuelle_recettes + 1; ?>'">Suivant</button>
                    <?php else: ?>
                        <button disabled>Suivant</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Modale pour modifier les rôles -->
<div class="modal fade" id="roleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier les rôles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="roleForm">
                    <input type="hidden" id="userId" name="id_user">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="Chef" id="roleChef">
                        <label class="form-check-label" for="roleChef">Chef</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="Traducteur" id="roleTraducteur">
                        <label class="form-check-label" for="roleTraducteur">Traducteur</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="DemandeChef" id="roleDemandeChef">
                        <label class="form-check-label" for="roleDemandeChef">DemandeChef</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="DemandeTraducteur" id="roleDemandeTraducteur">
                        <label class="form-check-label" for="roleDemandeTraducteur">DemandeTraducteur</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="sauverRoles()">Sauver</button>
            </div>
        </div>
    </div>
</div>

    <script>
    

    function validerRecette(id_recette) {
        alert('Fonctionnalité de validation de la recette ' + id_recette + ' à venir');
    }

    function modifierRecette(id_recette) {
        alert('Fonctionnalité de modification de la recette ' + id_recette + ' à venir');
    }

    function supprimerRecette(id_recette) {
        alert('Fonctionnalité de suppression de la recette ' + id_recette + ' à venir');
    }
    </script>
</body>
</html>