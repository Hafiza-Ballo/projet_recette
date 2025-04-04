
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
function modifInfo() {
  const form = document.getElementById('infoForm');
  
  var statut = $('#statut');

  const id = form.querySelector('input[name="id"]')?.value;
  const nom = form.querySelector('input[name="nom"]')?.value.trim();
  const prenom = form.querySelector('input[name="prenom"]')?.value.trim();
  const mail = form.querySelector('input[name="mail"]')?.value.trim();

  
  const demandeRoles = Array.from(
      form.querySelectorAll('input[name="demande_roles[]"]:checked')
  ).map(checkbox => checkbox.value);

  

  console.log("Données à envoyer:", { id, nom, prenom, mail, demandeRoles });

  
  const formData = new FormData();
  formData.append('id', id);
  formData.append('nom', nom);
  formData.append('prenom', prenom);
  formData.append('mail', mail);
  formData.append('demande_roles', JSON.stringify(demandeRoles)); 

  $.ajax({
      url: 'controllerFrontal.php',
      type: 'POST',
      data: formData,
      processData: false, 
      contentType: false, 
      success: function(response) {
        statut.html('<div class="alert alert-success alert-dismissible fade show" role="alert">Modification réussie !!! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
        setTimeout(() => {
          window.location.reload();
      }, 1500);
      },
      error: function() {
        statut.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Erreur lors de la modification<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
      }
  });
}

function changerLangue(langue){
  $.ajax({
    method: "POST",
    url: "changerLangue.php",
    data: { langue: langue },
    success: function() {
        location.reload(); // Recharge la page après le changement
    },
    error:function(){
      console.log("erreur");
    }

  })
}
function traduction(button,index, langue,id_recette,type_liste){
  let btn=document.getElementById("btn_traduire"+index);
  let divSuivante = button.nextElementSibling;
  let box_traduction=document.querySelector(".box_traduction");
  $.ajax({
    method: "POST",
    url: "changerLangue.php", 
    success: function(){
      if(type_liste=='ingredients' ){
        console.log('la');
        if(langue=='fr'){
          divSuivante.innerHTML='<div id="test'+type_liste+index+'"><label>Quantité: </label><input class="trad" name="'+type_liste+','+index+'"  ><br><label>Nom: </label><input class="trad" name="'+type_liste+','+index+'" ><br><label>Type: </label><input class="trad" name="'+type_liste+','+index+'"  ><br> <button id="idb'+index+'" onclick="appliquerTradIngr('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Appliquer</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Annuler</button> </div>';
        }
        else if(langue.trim()=='eng'){
          console.log('i');
          divSuivante.innerHTML='<div id="test'+type_liste+index+'"><label>Quantity: </label><input class="trad" name="q'+index+'" id="q'+index+'" ><br><label>Name: </label><input class="trad" name="n'+index+'" id= "n'+index+'"><br><label>Type: </label><input class="trad" name="t'+index+'" id="t'+index+'" ><br> <button id="idb'+index+'" onclick="appliquerTradIngr('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Appliquer</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Annuler</button> </div>';
        }


      }
      else{
        divSuivante.innerHTML='<div id="test'+type_liste+index+'"><input class="trad" name="'+type_liste+','+index+'" id="id'+index+'" ><br> <button id="idb'+index+'" onclick="appliquerTrad('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Appliquer</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Annuler</button> </div>';

      }
      btn.style.display="none";
     

    },
    error:function() {
      console.log("erreur");

    }
   
  })
}
function appliquerTrad(index,type_liste,id_recette,langue){
  let valeurInput= document.getElementById("id"+index).value;
  if(valeurInput.length >0){
    $.ajax({
      method: "POST",
      url: "controllerFrontal.php", 
      data: {"index":index, "valeurInput": valeurInput, "type_liste":type_liste,"id_recette":id_recette, "langue":langue},
      success: function(e){
        console.log(e);
        alert("Traduction ajoutée avec succès !");
        let btn = document.getElementById("btn_traduire" + index);
        btn.style.display = "none";

      let idSansesapace=("test"+type_liste+index).replace(/\s+/g, '');
        let traductionDiv = document.getElementById(idSansesapace);
        traductionDiv.remove();
      },
      error:function() {
        console.log("erreur");
      }
    })
  }
  
}
function appliquerTradIngr(index,type_liste,id_recette,langue){
  let valeurq= document.getElementById("q"+index).value;
  let valeurn= document.getElementById("n"+index).value;
  let valeurt= document.getElementById("t"+index).value;

  let valeurInput=valeurq+','+valeurn+','+valeurt;
  if(valeurInput.length>2){
    $.ajax({
      method: "POST",
      url: "controllerFrontal.php", 
      data: {"index":index, "valeurInput": valeurInput, "type_liste":type_liste,"id_recette":id_recette, "langue":langue},
      success: function(e){
        console.log(e);
        alert("Traduction ajoutée avec succès !");
        let btn = document.getElementById("btn_traduire" + index);
        btn.style.display = "none";

      let idSansesapace=("test"+type_liste+index).replace(/\s+/g, '');
        let traductionDiv = document.getElementById(idSansesapace);
        traductionDiv.remove();
      },
      error:function() {
        console.log("erreur");
      }
    })
  }
  
}
function annulerTrad(index, type_liste){
  let t=document.getElementById("test"+type_liste+index);
  let btn=document.getElementById("btn_traduire"+index);
  btn.style.display="block";
  t.style.display="none";

}