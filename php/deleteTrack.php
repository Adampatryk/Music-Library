<?php
    header("Location: ../pages/track.php");
    require "connect.php";

    $trackID = $_POST['trackID'];
    $sql = "DELETE FROM track WHERE trackID = $trackID";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>