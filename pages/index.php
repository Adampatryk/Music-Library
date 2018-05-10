<html>
    <?php require "../php/header.html" ?>
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
            ) AS trackCount,
            (
            SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(trackLength))) FROM track
            ) AS totalLength";

        $result = mysqli_query($conn, $sql);
        $counts = mysqli_fetch_assoc($result);

        echo "<div class=content>";
        echo "There are " . $counts['artistCount'] . " artists.";
        echo "<br>";
        echo "There are " . $counts['cdCount'] . " CDs.";
        echo "<br>";
        echo "There are " . $counts['trackCount'] , " tracks.";
        echo "<br>";
        echo "Total length of all tracks: " . $counts['totalLength'];
        echo "<div/>";

        mysqli_close($conn);
    ?>
</html>
