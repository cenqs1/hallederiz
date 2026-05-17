<?php
session_start();
include(__DIR__ . "/database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location: giris.php");
    exit();
}

$kullanici_id = $_SESSION["kullanici_id"];
$id = $_GET["id"];

$sql = "DELETE FROM talepler 
        WHERE id='$id' AND kullanici_id='$kullanici_id'";

mysqli_query($baglanti, $sql);

header("Location: benim_taleplerim.php");
exit();
?>