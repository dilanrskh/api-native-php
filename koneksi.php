<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "crud-native";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if(!$koneksi){
    die("Gagal Terhubung : " . mysqli_connect_error());
}

?>