<?php

$server = "localhost";
$username = "user";
$password = "g51dbi";
$dbname = "music_library";

$conn = new mysqli($server, $username, $password, $dbname);
if (mysqli_connect_error()){
    echo die("Connection failed");
}

?>