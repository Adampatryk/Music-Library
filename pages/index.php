<!DOCTYPE html>
<html>
    <head>
        <title>Music Library</title>
        
        <link href="../css/main.css" rel="stylesheet" type="text/css"/>
    </head>
    <?php 
    require_once "../php/nav-bar.php";
    include "../php/connect.php";

    $sql = "SELECT (
        SELECT COUNT(*) FROM artist
        ) AS artistCount,
        (
        SELECT COUNT(*) FROM cd
        ) AS cdCount, 
        (
        SELECT COUNT(*) FROM track
        ) AS trackCount";

    $result = mysqli_query($conn, $sql);
    $counts = mysqli_fetch_assoc($result);

    echo "<div class=content>";
    echo "There are " . $counts['artistCount'] . " artists.";
    echo "<br>";
    echo "There are " . $counts['cdCount'] . " CDs.";
    echo "<br>";
    echo "There are " . $counts['trackCount'] , " tracks.";
    echo "<div/>";

    mysqli_close($conn);
    
    ?>
</html>
