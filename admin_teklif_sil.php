<?php
session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

if($_SESSION["rol"] != "admin"){
    header("Location:panel.php");
    exit();
}

if(isset($_GET["id"])){

    $id = $_GET["id"];

    mysqli_query($baglanti, "DELETE FROM teklifler WHERE id='$id'");
}

header("Location:admin_panel.php");
exit();
?>