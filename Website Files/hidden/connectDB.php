<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$baseName = "karagkounis";
$mysqli = new mysqli($serverName, $userName, $password, $baseName);
$mysqli->set_charset("utf8");

if ($mysqli->connect_errno) {
    echo "Η σύνδεση με τη MySQL απέτυχε!: " . $mysqli->connect_error;
    exit();
}
?>