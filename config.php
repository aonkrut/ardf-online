<?php
// Konfiguracija za spajanje na bazu podataka
$servername = "localhost";
$username = "root";
$password = "";
$database = "ardf_ online";

// Stvaranje veze s bazom podataka
$mysqli = new mysqli($servername, $username, $password, $database);

// Provjera povezivanja
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>
