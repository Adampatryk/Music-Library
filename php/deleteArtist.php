<?php

    header("Location: ../pages/artist.php");
    require "connect.php";

    $artID = $_POST['artID'];
    $sql = "DELETE FROM artist WHERE artID = $artID";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);

?>