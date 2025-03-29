
function changeImgURL(button,id,$id_user){
    $.ajax({
      method: "GET",
      url: "controllerFrontal.php",
      data: {"id":id}
    }).done(function(e) {
      let $btn = $(button);
      let $like=$btn.parent().find(".like");
      let $dislike=$btn.parent().find(".dislike");
      let $likeCount = $('#like-count-' + id);

      if($like.css("display")=="block"){
          $dislike.css("display","block");
          $like.css("display","none");
            
          ajoutlike(id,$id_user);
          $likeCount.text(parseInt($likeCount.text()) + 1);
        }
       else{
          $dislike.css("display","none");
          $like.css("display","block");
          supprimelike(id,$id_user);
          $likeCount.text(parseInt($likeCount.text()) - 1);
        }
    }).fail(function(e) {
      console.log(e);
     
    });
}
function ajoutlike(id,$id_user){
    $type="ajout";
    console.log($type);
    $.ajax({
      method: "POST",
      url: "controllerFrontal.php",
      data: {"id":id,"type":$type,"id_user":$id_user}
    }).done(function(e) {
      console.log(e);
    }).fail(function(e) {
      console.log(e);
     
    });
}
function supprimelike(id,$id_user){
    $type="supprime";
    console.log($type);
    $.ajax({
      method: "POST",
      url: "controllerFrontal.php",
      data: {"id":id,"type":$type,"id_user":$id_user}
      
    }).done(function(e) {
      console.log(e);
    }).fail(function(e) {
      console.log(e);
     
    });
}

function affichage_conteneur_modif(){
 let conteneur_modif_c=document.getElementsByClassName("conteneur_modif_c")[0];

 if(conteneur_modif_c.style.visibility==="visible"){
  conteneur_modif_c.style.visibility="hidden";
 }
 else{
  conteneur_modif_c.style.visibility="visible";
 }
  
}

function ajouterRole($id_user, $role){
  let roleAjoute=document.getElementById("role").value;
  if(roleAjoute=="Defaut"){
    console.log("aucun choix");
  }
  else{
    
    $.ajax({
      method: "POST",
      url: "controllerFrontal.php", 
      data: {"id_user":$id_user, "roleAjoute":roleAjoute}
      
    }).done(function(e) {
      if(e.success){
        $(".liste_role ul").append('<li>'+roleAjoute+' </li> <button class="btn_supprimer" onclick="supprimerRole()" ><img src="images/trash-solid.svg" alt="supprimer" id="supprimer" > </button>')

      }
      else{
        alert("Erreur lors de l'ajout du rôle.");
      }
      console.log(e);
    }).fail(function(e) {
      console.log(e);
     
    });
  }

}
function ajouterPhoto($idUser, $idRecette) {
  var photoInput = $('#photoInput')[0];
  var photoUrl = $('#photoUrl').val();
  var statut = $('#statut');

  if (photoInput && photoInput.files.length > 0) {
      var formData = new FormData();
      formData.append('photo', photoInput.files[0]);
      formData.append('id_user', $idUser);
      formData.append('id_recette', $idRecette);

      $.ajax({
          url: 'controllerFrontal.php',
          type: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            statut.html('<div class="alert alert-success alert-dismissible fade show" role="alert">Photo ajoutée !!! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
              photoInput.value = '';
          },
          error: function() {
            statut.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Erreur lors de l\'upload<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
          }
      });
  }
  
  else if (photoUrl) {
      $.ajax({
          url: 'controllerFrontal.php',
          type: 'POST',
          data: {"url": photoUrl, "id_recette": $idRecette, "id_user": $idUser},
          success: function(response) {
            statut.html('<div class="alert alert-success alert-dismissible fade show" role="alert">Photo ajoutée !!! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
              $('#photoUrl').val('');
          },
          error: function() {
            statut.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Erreur avec l\'url<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
          }
      });
  } else {
    statut.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Veuillez sélectionner un fichier ou entrer une URL.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
  }
}


function redirigerRecherche(idUser) {
  var mot = $('#recherche_input').val();
  if (mot.length > 0) {
      window.location.href = 'controllerFrontal.php?action=rechercher&mot=' + mot + '&id_user=' + idUser;
  }
}