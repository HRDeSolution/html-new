<?
include "./include/include_function.php";

if($UserDevice=="Mobile") {
    $url = $MobileSiteURL;
}else{
    $url = "/archive/main/main.html";
}

header( "Location: $url" );
?>
