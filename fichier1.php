<?php
if(isset($_POST['mail_c']) && isset($_POST['mdp_c'])){
    $mail_c=$_POST['mail_c'];
    $mdp_c=$_POST['mdp_c'];
    echo $mail_c."  ".$mdp_c;
    
}
?>