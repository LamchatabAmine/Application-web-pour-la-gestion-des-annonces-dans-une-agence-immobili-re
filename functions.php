<?php
function auth(){

    if(isset($_SESSION['email'])){
        
        return true ;
        


    }

}





function not_auth_redirect(){
    if(!auth()) {
header("location:index.php");

    }
}



function auth_redirect(){
    if(auth()) {
header("location:profile.php");

    }
}






