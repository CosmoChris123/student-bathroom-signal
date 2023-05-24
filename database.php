<?php

// Links with database of user's login details
$host = "localhost";
$dbname = "login";
//Root is for local (may need to change later)
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password,$dbname);

// Displays error code message if there's a connection error
if ($mysqli->connect_errno){
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;
?>