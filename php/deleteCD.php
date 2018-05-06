<?php
    header("Location: ../pages/cd.php");
    require "connect.php";

    $cdID = $_POST['cdID'];
    $sql = "DELETE FROM cd WHERE cdID = $cdID";
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);
?>