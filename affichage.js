
function changeImgURL(button,id){
    $.ajax({
      method: "GET",
      url: "vue.php",
      data: {"id":id}
    }).done(function(e) {
      let $btn = $(button);
      let $like=$btn.parent().find(".like");
      let $dislike=$btn.parent().find(".dislike");
        if($like.css("display")=="block"){
          $dislike.css("display","block");
          $like.css("display","none");
            
          ajoutlike(id);
        }
       else{
          $dislike.css("display","none");
          $like.css("display","block");
          supprimelike(id);
        }
    }).fail(function(e) {
      console.log(e);
     
    });
}
function ajoutlike(id){
    $type="ajout";
    console.log($type);
    $.ajax({
      method: "POST",
      url: "ajax.php",
      data: {"id":id,"type":$type}
    }).done(function(e) {
      console.log(e);
    }).fail(function(e) {
      console.log(e);
     
    });
}
function supprimelike(id){
    $type="supprime";
    console.log($type);
    $.ajax({
      method: "POST",
      url: "ajax.php",
      data: {"id":id,"type":$type}
      
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


