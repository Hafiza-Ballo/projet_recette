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
  let btn=document.getElementById("btn_traduire"+type_liste+index);
  let divSuivante = button.nextElementSibling;
  let box_traduction=document.querySelector(".box_traduction");
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

function traduction2(button,index, langue,id_recette,type_liste){
  let btn=document.getElementById("btn_traduire"+type_liste+index);
  let divSuivante = button.nextElementSibling;
  let box_traduction=document.querySelector(".box_traduction");
  box_traduction.style.display="block";
  $.ajax({
    method: "POST",
    url: "changerLangue.php", 
    success: function(){

      if(btn)btn.style.display="none";
      else{console.log('no');}

    },
    error:function() {
      console.log("erreur");

    }
   
  })
}

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
      console.log("icii");
      console.log(idSansesapace);
      console.log("finn ");

      let traductionDiv = document.getElementById(idSansesapace);
      console.log("icii22");
      console.log(traductionDiv);
      console.log("finn 22");
      if(traductionDiv)traductionDiv.remove();
      else{
        console.log('ptv');}
        
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
        if(langue.trim()=='fr'){
          alert("Traduction ajoutée avec succès !");
        }
        else{
          alert("Translation added successfully !");
        }        
        let btn = document.getElementById("btn_traduire"+type_liste+index);
        if(btn){btn.style.display = "none";}
        else{
          console.log('no');
        }

      let idSansesapace=("test"+type_liste+index).replace(/\s+/g, '');
      console.log(idSansesapace);
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
  let btn=document.getElementById("btn_traduire"+type_liste+index);
  if(btn){btn.style.display="block";}
  else{console.log('no');}
  if(t)t.style.display="none";
  let box_traduction=document.querySelector(".box_traduction");
  box_traduction.style.display="none";
  
}



function effacerBtn(){
  let btn = document.getElementById("btn_traduirenomRecette0");
  let divSuivante = document.getElementById("divTradNom");
  let divSuivante2=document.getElementById("testnomRecette0");
  if(btn) btn.style.display = "none";
  if(divSuivante) {
    divSuivante.style.display = "block";
    divSuivante2.style.display="block";
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

function sauverRecette(id_recette,id_user) {
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
}

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
function appliquerModif(id_recette,langue){
  let btn= document.getElementById("btn_a_modif");

  // Récupère tous les ingrédients
  const ingrBoxes = document.querySelectorAll(".boxIngr");
  const stepBoxes = document.querySelectorAll(".boxStep");

  let ingredients = [];
  let steps = [];

  ingrBoxes.forEach((box) => {
    if(box.querySelector(".quantite") &&  box.querySelector(".nomI") && box.querySelector(".type") ) {
      const quantite = box.querySelector(".quantite").value;
    const nom = box.querySelector(".nomI").value;
    const type = box.querySelector(".type").value;
  

    ingredients.push({"quantite": quantite, "nom":nom, "type": type });
    }
  });
  stepBoxes.forEach((box) => {
    const step = box.querySelector(".step").value;
    const temps = box.querySelector(".temps").value;
    steps.push({"step": step, "temps":temps });
  });
  let nomR=document.querySelector("#divModifRecette .nomR").value;
  console.log(ingredients);

  
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {id_recette:id_recette, langue: langue,nomR:nomR, ingredients:JSON.stringify(ingredients), steps:JSON.stringify(steps) },
    success: function(e) {
    console.log('appel');   
    annulerModif();   
    if(langue.trim()=='fr'){
      alert('Recette mise à jour !');
    }  
    else{
      alert('Recipe updated !');
    }
    location.reload();

    },
    error: function() {
        alert('Erreur lors de la mise à jour de la recette.');
    }
});
}

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
    let btn=document.getElementById("btn_nouvel"+type);
    if(btn){btn.style.display='none';}
    else{console.log("pasbtn");}
  }
  
  
}

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


function fctajout(id_recette,langue, type, index){
  let btn= document.getElementById("btn_a_modif");

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
    if(step && temps) { // Vérifie que les valeurs ne sont pas vides
      steps.push({"step": step, "temps": temps});
    }
    console.log(step);
    console.log(temps);
  });

  let nomR = document.querySelector("#divModifRecette .nomR").value;
  
  $.ajax({
    url: 'controllerFrontal.php',
    type: 'POST',
    data: {
      id_recette: id_recette, 
      langue: langue,
      nomR: nomR, 
      ingredients: JSON.stringify(ingredients), 
      steps: JSON.stringify(steps),
      index: index
    },
    success: function(e) {
      console.log(steps);   
      if(langue.trim() == 'fr'){
        alert('Recette mise à jour !');
      } else {
        alert('Recipe updated !');
      }
      let div = document.getElementById("nouvel"+type);
      if(div) div.style.display = 'none';
      let btn = document.getElementById("btn_nouvel"+type);
      if(btn) btn.style.display = 'block';
      else console.log("pasbtn");
      location.reload();
    },
    error: function() {
      alert('Erreur lors de la mise à jour de la recette.');
    }
  });
}



