
function changeImgURL(button,name){
    $.ajax({
      method: "GET",
      url: "vue.php",
      data: {"name":name}
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
function ajoutlike(name){
    $type="ajout";
    console.log($type);
    $.ajax({
      method: "POST",
      url: "ajax.php",
      data: {"name":name,"type":$type}
    }).done(function(e) {
      console.log(e);
    }).fail(function(e) {
      console.log(e);
     
    });
}
function supprimelike(name){
    $type="supprime";
    console.log($type);
    $.ajax({
      method: "POST",
      url: "ajax.php",
      data: {"name":name,"type":$type}
      
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


