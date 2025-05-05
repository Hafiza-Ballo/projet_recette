// Gère le like/dislike d’une recette via AJAX, en basculant l’icône et en mettant à jour le compteur.
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
//ajouter un like a la recette dans le JSON
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
//supprimer un like a la recette dans le JSON
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
      }, 100);
      },
      error: function() {
        statut.html('<div class="alert alert-danger alert-dismissible fade show" role="alert">Erreur lors de la modification<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
      }
  });
}

function posterCommentaire(id_user, id_recette) {
  let commentaire = document.getElementById('commentText').value;
  if (commentaire.trim() === '') {
      alert('Veuillez entrer un commentaire !');
      return;
  }

  $.ajax({
      url: 'controllerFrontal.php',
      type: 'POST',
      data: {
          id_user: id_user,
          id_recette: id_recette,
          commentaire: commentaire
      },
      success: function(response) {
          document.getElementById('commentText').value = '';
          alert('Commentaire posté avec succès !');
          chargerCommentaires(id_recette); 
      },
      error: function() {
          alert('Erreur lors de l\'envoi du commentaire.');
      }
  });
}

function chargerCommentaires(id_recette) {
  $.ajax({
      url: 'controllerFrontal.php',
      type: 'POST',
      data: {
          action: 'get_commentaires',
          id_recette: id_recette
      },
      success: function(response) {
          let commentaires = JSON.parse(response);
          let commentList = document.getElementById('commentList');
          commentList.innerHTML = '';
          commentaires.forEach(function(comment) {
              commentList.innerHTML += '<div class="comment-item">' + comment.prenom + ' ' + comment.nom + ': ' + comment.commentaire + '</div>';
          });
      }
  });
}
//changer la langue du site
function changerLangue(langue){
  console.log(langue);
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
//afficher les div pour traduire un element de la recette dans la langue opposée
function traduction(button,index, langue,id_recette,type_liste){
  let btn=document.getElementById("btn_traduire"+type_liste+index);
  let divSuivante = button.nextElementSibling;
  $.ajax({
    method: "POST",
    url: "changerLangue.php", 
    success: function(){
      if(type_liste=='ingredients' ){
        if(langue=='fr'){
          divSuivante.innerHTML='<div id="test'+type_liste+index+'"><label>Quantité: </label><input class=" trad_input_ingredients" name="'+type_liste+','+index+'"  ><br><label>Nom: </label><input class=" trad_input_ingredients" name="'+type_liste+','+index+'" ><br><label>Type: </label><input class="trad_input_ingredients" name="'+type_liste+','+index+'"  ><br> <button id="idb'+index+'" onclick="appliquerTradIngr('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Appliquer</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Annuler</button> </div>';
        }
        else if(langue.trim()=='eng'){
          console.log('i');
          divSuivante.innerHTML='<div id="test'+type_liste+index+'"><label>Quantity: </label><input class=" trad_input_ingredients" name="q'+index+'" id="q'+index+'" ><br><label>Name: </label><input class=" trad_input_ingredients" name="n'+index+'" id= "n'+index+'"><br><label>Type: </label><input class="trad_input_ingredients" name="t'+index+'" id="t'+index+'" ><br> <button id="idb'+index+'" onclick="appliquerTradIngr('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Apply</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Cancel</button> </div>';
        }
      }
      else if(type_liste=='steps'){
        if(langue.trim()=='fr'){
          divSuivante.innerHTML='<div id="test'+type_liste+index+'"><input class="trad" name="'+type_liste+','+index+'" id="id'+index+'" ><br> <button id="idb'+index+'" onclick="appliquerTrad('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Appliquer</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Annuler</button> </div>';

        }
        else if(langue.trim()=='eng'){
          divSuivante.innerHTML='<div id="test'+type_liste+index+'"><input class="trad" name="'+type_liste+','+index+'" id="id'+index+'" ><br> <button id="idb'+index+'" onclick="appliquerTrad('+index+',\' '+type_liste+' \','+id_recette+',\' '+langue+' \' )"> Apply</button> <button  id="idann'+index+'"onclick="annulerTrad('+index+',\''+type_liste+'\')">Cancel</button> </div>';

        }

      }
      
      divSuivante.style.display = "block";

      if(btn)btn.style.display="none";
      else{console.log('no');}
     

    },
    error:function() {
      console.log("erreur");

    }
   
  })
}

//afficher les div pour traduire les ingredients qui ont certaines caractéristiques traduites
// et d'autres non
function traduction2(button,index, langue,id_recette,type_liste){
  let btn=document.getElementById("btn_traduire"+type_liste+index);
  let divSuivante = button.nextElementSibling;
  let box_traduction=document.querySelector(".tr_"+index);
  console.log("btn_traduire"+type_liste+index);
  if(btn)btn.style.display="none";
  box_traduction.style.display="block";
  $.ajax({
    method: "POST",
    url: "changerLangue.php", 
    success: function(){

    },
    error:function() {
      console.log("erreur");

    }
   
  })
}

//appliquer la traduction du nom de la recette dans la langue opposée
function appliquerTrad(index,type_liste,id_recette,langue){
  let btn= document.getElementById("id"+index);
  let valeurInput= btn.value;
  if(valeurInput.length >0){
    $.ajax({
      method: "POST",
      url: "controllerFrontal.php", 
      data: {"index":index, "valeurInput": valeurInput, "type_liste":type_liste,"id_recette":id_recette, "langue":langue},
      success: function(e){
        console.log(e);
        if(langue.trim()=='fr'){
          alert("Traduction ajoutée avec succès !");
        }
        else if(langue.trim()=='eng'){
          alert("Translation added successfully !");
        }
        let btn = document.getElementById("btn_traduire"+type_liste+index);
        if(btn)btn.style.display = "none";
        else{
          console.log('no');
        }

      let idSansesapace=("test"+type_liste+index).replace(/\s+/g, '');
      
      let traductionDiv = document.getElementById(idSansesapace);
      if(traductionDiv)traductionDiv.remove();
      else{console.log('ptv');}
        
      },
      error:function() {
        console.log("erreur");
      }
    })
  }
  
}

//appliquer la traduction d'un ingredient ou d'une etape dans la langue opposée
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
        alert(langue.trim()=== 'fr' ?   'Traduction ajoutée avec succès !': 'Translation added successfully !');
               
        let btn = document.getElementById("btn_traduire"+type_liste+index);
        if(btn){btn.style.display = "none";}
        else{console.log('no');}

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

//cacher la div de traduction de'un element de la recette
// et afficher le bouton de traduction
function annulerTrad(index, type_liste){
  let btn=document.getElementById("btn_traduire"+type_liste+index);
  if(btn){btn.style.display="inline-block";}
  else{console.log('no');}
  let box_traduction=document.querySelector(".tr_"+index);
  if(box_traduction)box_traduction.style.display="none";
  
}


// afficher la div de traduction du nom de la recette
function effacerBtn(){
  let btn = document.getElementById("btn_traduirenomRecette0");
  let divSuivante = document.querySelector(".tr_0");
  if(btn) btn.style.display = "none";
  if(divSuivante) {
    divSuivante.style.display = "inline-block";
  } else {
    console.log('no');
  }
}

function modifierRoles(id_user, roles) {
    document.getElementById('userId').value = id_user;

    document.getElementById('roleChef').checked = false;
    document.getElementById('roleTraducteur').checked = false;
    document.getElementById('roleDemandeChef').checked = false;
    document.getElementById('roleDemandeTraducteur').checked = false;

    // Cocher les rôles actuels
    var rolesArray = roles.split(',');
    if (rolesArray.includes('Chef')) document.getElementById('roleChef').checked = true;
    if (rolesArray.includes('Traducteur')) document.getElementById('roleTraducteur').checked = true;
    if (rolesArray.includes('DemandeChef')) document.getElementById('roleDemandeChef').checked = true;
    if (rolesArray.includes('DemandeTraducteur')) document.getElementById('roleDemandeTraducteur').checked = true;

    
    var modal = new bootstrap.Modal(document.getElementById('roleModal'));
    modal.show();
}

function sauverRoles() {
    var id_user = document.getElementById('userId').value;
    var roles = [];
    if (document.getElementById('roleChef').checked) roles.push('Chef');
    if (document.getElementById('roleTraducteur').checked) roles.push('Traducteur');
    if (document.getElementById('roleDemandeChef').checked) roles.push('DemandeChef');
    if (document.getElementById('roleDemandeTraducteur').checked) roles.push('DemandeTraducteur');

    $.ajax({
        url: 'controllerFrontal.php',
        type: 'POST',
        data: {
            action: 'modifier_roles',
            id_user: id_user,
            roles: roles
        },
        success: function(response) {
            alert('Rôles mis à jour !');
            location.reload(); 
        },
        error: function() {
            alert('Erreur lors de la mise à jour des rôles.');
        }
    });
}

function changerLangue2() {
  var langue = document.getElementById('langue').value;
  if (langue === 'fr') {
      document.querySelector('.lang-fr').style.display = 'block';
      document.querySelector('.lang-eng').style.display = 'none';
      champsRequis('.lang-fr', true);
      champsRequis('.lang-eng', false);
  } else {
      document.querySelector('.lang-fr').style.display = 'none';
      document.querySelector('.lang-eng').style.display = 'block';
      champsRequis('.lang-fr', false);
      champsRequis('.lang-eng', true);
  }
}

function champsRequis(container, required) {
  var inputs = document.querySelectorAll(container + ' input, ' + container + ' textarea');
  inputs.forEach(function(input) {
      input.required = required;
  });
}



function editMode() {
    var viewElements = document.querySelectorAll('.view-mode');
    var editElements = document.querySelectorAll('.edit-mode');
    var editButton = document.getElementById('editButton');
    var saveButton = document.getElementById('saveButton');

    viewElements.forEach(function(el) {
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    });
    editElements.forEach(function(el) {
        el.style.display = el.style.display === 'none' ? 'block' : 'none';
    });

    editButton.style.display = editButton.style.display === 'none' ? 'inline-block' : 'none';
    saveButton.style.display = saveButton.style.display === 'none' ? 'inline-block' : 'none';
}

/*function sauverRecette(id_recette,id_user) {
    var formData = new FormData();
    formData.append('action', 'modifier_recette');
    formData.append('id_user',  id_user);
    formData.append('id_recette', id_recette);
    formData.append('name', document.querySelector('input[name="name"]')?.value || '');
    formData.append('nameFR', document.querySelector('input[name="nameFR"]')?.value || '');
    formData.append('without', document.querySelector('input[name="without"]').value);
    formData.append('ingredients', document.querySelector('textarea[name="ingredients"]')?.value || '');
    formData.append('ingredientsFR', document.querySelector('textarea[name="ingredientsFR"]')?.value || '');
    formData.append('steps', document.querySelector('textarea[name="steps"]')?.value || '');
    formData.append('stepsFR', document.querySelector('textarea[name="stepsFR"]')?.value || '');
    formData.append('timers', document.querySelector('input[name="timers"]').value);
    formData.append('photo_file', document.getElementById('photo_file').files[0] || null);
    formData.append('photo_url', document.querySelector('input[name="photo_url"]').value);
    formData.append('author', document.querySelector('input[name="author"]').value);

    $.ajax({
        url: 'controllerFrontal.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert('Recette mise à jour !');
            location.reload();
        },
        error: function() {
            alert('Erreur lors de la mise à jour de la recette.');
        }
    });
}*/

//afficher un conteneur pour modifier la recette
function ModifierRecette(){
  let btn=document.getElementById("btn_modifRecette");
  let btndiv=document.getElementById("divModifRecette");
  let section= document.getElementById("content");
  if(btn){ btn.style.display='none';}
  else{console.log("pasbtn");}
  if(btndiv){ btndiv.style.display='block';}
  else{console.log("pasbtndiv");}
  if(section){section.style.display='block';}
  else{console.log('pasec');}

}
//cacher le conteneur de modification de la recette
function annulerModif(){
  let btn=document.getElementById("btn_modifRecette");
  let btndiv=document.getElementById("divModifRecette");
  let section= document.getElementById("content");
  if(btn){ btn.style.display='block';}
  else{console.log("pasbtn");}
  if(btndiv){ btndiv.style.display='none';}
  else{console.log("pasbtndiv");}
  if(section){section.style.display='none';}
  else{console.log('pasec');}
}
//appliquer les modifications de la recette
// ou ajouter une nouvelle recette en fonction de la valeur de div
function appliquerModif(id_recette,langue, div){
  // Récupère tous les ingrédients et étapes visibles uniquement
  const ingrBoxes = document.querySelectorAll(".boxIngr:not([style*='display: none'])");
  const stepBoxes = document.querySelectorAll(".boxStep:not([style*='display: none'])");

  let ingredients = [];
  let steps = [];
  //recuperer tous les ingredients et les étapes
  ingrBoxes.forEach((box) => {
    if(box.querySelector(".quantite") && box.querySelector(".nomI") && box.querySelector(".type")) {
      const quantite = box.querySelector(".quantite").value;
      const nom = box.querySelector(".nomI").value;
      const type = box.querySelector(".type").value;
  
      ingredients.push({"quantite": quantite, "nom": nom, "type": type});
    }
  });

  stepBoxes.forEach((box) => {
    const step = box.querySelector(".step").value;
    const temps = box.querySelector(".temps").value;
    if(step && temps && step!='...'.trim()) { // Vérifie que les valeurs ne sont pas vides
      steps.push({"step": step, "temps": temps});
    }
    
  });

  let nomR=document.querySelector("#"+div+" .nomR").value;
  let without= document.querySelector("#"+div+" .without").value;
  let photo_url = "";
  

  // Récupérer l'URL de la photo si on ajoute une nouvelle recette
  if(div=="AjoutRecette"){
    const urlInput = document.querySelector(".form-container #photo_url");
    if (urlInput && urlInput.value.trim().length > 0) {
      photo_url = urlInput.value.trim(); // Stocke l'URL
    }
  }
  else{
   id_u=-1;

  }

  
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {id_recette:id_recette, langue: langue,nomR:nomR,without:without, ingredients:JSON.stringify(ingredients), steps:JSON.stringify(steps), div:div, id_u:id_u,photo_url:photo_url },
    success: function(e) {
    console.log('appel');   
    if(div=='divModifRecette'){
      annulerModif();   
      alert(langue.trim() === 'fr' ? 'Recette mise à jour !' : 'Recipe updated!');
    }
    else{
      alert(langue.trim()==='fr' ? 'Recette ajoutée ! Elle est en attente de validation pour être publiée!' : 'Recipe added! It is pending approval before being published!');
    }
    location.reload();

    },
    error: function() {
        alert(langue.trim()=== 'fr' ? 'Erreur lors de la mise à jour de la recette.': 'Error while updating the recipe.');
    }
});
}

//afficher la div pour ajouter un nouvel ingrédient ou une nouvelle étape 
//a la recette existante
function fctnouvelAjout(type,index){
  if(type=='Etape'){
    let div=document.getElementById("new"+index);
    if(div){div.style.display='block';}
    let btn=document.getElementById("btn_new"+index);
    if(btn){btn.style.display='none';}
    else{console.log("pasbtn");}
  }
  else{
    let div=document.getElementById("nouvel"+type);
    if(div){div.style.display='block';}
    
    else{console.log("pasbtn");}
  }
  
  
}
// cacher la div pour ajouter un nouvel ingrédient ou une nouvelle étape
function annulerNouvelAjout(type, index){
  if(type=='Etape'){
    let btn=document.getElementById("btn_new"+index);
    let div=document.getElementById("new"+index);
    if(btn){ btn.style.display='block';}
    else{ console.log("pasbtn");}
    if(div){ div.style.display='none';}
    else{console.log("pasbtndiv");}
  }
  else{
    let btn=document.getElementById("btn_nouvel"+type);
    let div=document.getElementById("nouvel"+type);
    if(btn){ btn.style.display='block';}
    else{ console.log("pasbtn");}
    if(div){ div.style.display='none';}
    else{console.log("pasbtndiv");}
  }
  
}

// ajouter un nouvel ingrédient ou une nouvelle étape à la recette existante
// et mettre à jour la recette dans le JSON
function fctajout(id_recette,langue, type, index){

  // Récupère tous les ingrédients et étapes visibles uniquement
  const ingrBoxes = document.querySelectorAll(".boxIngr:not([style*='display: none'])");
  const stepBoxes = document.querySelectorAll(".boxStep:not([style*='display: none'])");

  let ingredients = [];
  let steps = [];

  ingrBoxes.forEach((box) => {
    if(box.querySelector(".quantite") && box.querySelector(".nomI") && box.querySelector(".type")) {
      const quantite = box.querySelector(".quantite").value;
      const nom = box.querySelector(".nomI").value;
      const type = box.querySelector(".type").value;
  
      ingredients.push({"quantite": quantite, "nom": nom, "type": type});
    }
  });

  stepBoxes.forEach((box) => {
    const step = box.querySelector(".step").value;
    const temps = box.querySelector(".temps").value;
    if(step && temps && step!='...'.trim()) { // Vérifie que les valeurs ne sont pas vides
      steps.push({"step": step, "temps": temps});
    }
  });

  let nomR = document.querySelector("#divModifRecette .nomR").value;
  let without= document.querySelector("#divModifRecette .without").value;
  
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {
      id_recette: id_recette, 
      langue: langue,
      nomR: nomR, 
      without:without,
      ingredients: JSON.stringify(ingredients), 
      steps: JSON.stringify(steps),
      index: index
    },
    success: function(e) {
      alert(langue.trim() === 'fr' ? 'Recette mise à jour !' : 'Recipe updated!');

      let div = document.getElementById("nouvel"+type);
      if(div) div.style.display = 'none';
      let btn = document.getElementById("btn_nouvel"+type);
      if(btn) btn.style.display = 'block';
      else console.log("pasbtn");
      location.reload();
    },
    error: function() {
      alert(langue.trim()=== 'fr' ? 'Erreur lors de la mise à jour de la recette.': 'Error while updating the recipe.');
    }
  });
}

function supModif(type, index, id_recette, langue){
  let sup="supression";
  console.log('sup');
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {type:type, index:index,sup:sup, id_recette:id_recette},
    success: function(e){
      console.log("app");
      if(type=='ingredients'){alert(langue.trim() === 'fr' ? 'Ingrédient supprimé !' : 'Ingredient deleted!');}
      else{alert(langue.trim() === 'fr' ? 'Etape supprimé !' : 'Step deleted!');}
      location.reload();
    },
    error: function(){
      alert(langue.trim()=== 'fr' ? 'Erreur lors de la supression.': 'Error while deleting .');

    }
  });
}

//ajouter un nouvel ingrédient ou une nouvelle étape à la recette qu'on crèe
//dans "proposerRecette"
function autreIngr(langue ,type){
  const container = document.getElementById("container"+type);
  const nouvelleDiv = document.createElement("div");// creer une nouvelle div
  const modele = document.querySelector(".proposer"+type);
  nouvelleDiv.className = "proposer"+type;
  nouvelleDiv.innerHTML = modele.innerHTML;//copier l'ancienne div dans la nouvelle
  nouvelleDiv.querySelectorAll('textarea').forEach(textarea => textarea.value = ''); //vider
  nouvelleDiv.querySelectorAll('input').forEach(input => input.value = ''); //vider
  
  const boutonSupprimer = nouvelleDiv.querySelector('button[id^="supIngr"]');
  if (boutonSupprimer) {
    boutonSupprimer.remove();
}
  
  const btnAnnuler = document.createElement("button");//creer le bouton annuler
  btnAnnuler.textContent = (langue.trim()=== 'fr' ? 'Annuler': 'Cancel');
  btnAnnuler.className="annuler_"+type;
 
  
  btnAnnuler.onclick = function() {
    nouvelleDiv.remove(); // Supprime la nouvelle div
  };
  //ajouter le bouton a nos divs
  const boxElement = nouvelleDiv.querySelector(".box" + type);
  if (boxElement) {
    boxElement.appendChild(btnAnnuler);
  } else {
    nouvelleDiv.appendChild(btnAnnuler);
  }
  container.appendChild(nouvelleDiv);
 
}



//verifier si le nom de la recette est valide pour ajouter la nouvelle recette
function AjouterRecette(langue){
  if((document.querySelector("#AjoutRecette .nomR").value).length>0){
    appliquerModif(-1,langue, 'AjoutRecette')
  }
  else{
    console.log("pas nom");
  }
}

//valider une recette par l'administrateur afin de l'afficher sur le site
function validerRecette(id_recette, langue){
  let valider="oui";
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {
      id_recette: id_recette, 
      valider:valider
    },
    success: function(e) {  
      alert(langue.trim() === 'fr' ? 'Recette validée !' : 'Recipe confirmed!');

      location.reload();
    },
    error: function() {
      alert(langue.trim()=== 'fr' ? 'Erreur lors de la validation de la recette.': 'Error while confirming the recipe.');
    }
  });
}

//supprimer une recette par l'administrateur afin de la supprimer du JSON
function suprimerRecette(id_recette, langue){
  let valider="non";
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {
      id_recette: id_recette, 
      valider:valider
    },
    success: function(e) {  
      alert(langue.trim() === 'fr' ? 'Recette supprimée !' : 'Recipe deleted!');

    },
    error: function() {
      alert(langue.trim()=== 'fr' ? 'Erreur lors de la supression de la recette.': 'Error while deleting the recipe.');
    }
  });
}