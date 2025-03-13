
function changeImgURL(button,id,$id_user){
    $.ajax({
      method: "GET",
      url: "controllerFrontal.php",
      data: {"id":id}
    }).done(function(e) {
      let $btn = $(button);
      let $like=$btn.parent().find(".like");
      let $dislike=$btn.parent().find(".dislike");
        if($like.css("display")=="block"){
          $dislike.css("display","block");
          $like.css("display","none");
            
          ajoutlike(id,$id_user);
        }
       else{
          $dislike.css("display","none");
          $like.css("display","block");
          supprimelike(id,$id_user);
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
  $.ajax({
    method: "POST",
    url: "conteneur_modif.php",
    data: {}
  }).done(function(e) {
    let $btn = $(button);
    let $like=$btn.parent().find(".like");
    let $dislike=$btn.parent().find(".dislike");
      if($like.css("display")=="block"){
        $dislike.css("display","block");
        $like.css("display","none");
        ajoutlike(name);
      }
     else{
        $dislike.css("display","none");
        $like.css("display","block");
        supprimelike(name);
      }
  }).fail(function(e) {
    console.log(e);
   
  });
}


