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
        echo "<h2> There are " . $counts['artistCount'] . " artists.</h2>";
        echo "</div>";

        echo "<div class=content>";
        echo "<h2> There are " . $counts['cdCount'] . " CDs.</h2>";
        echo "</div>";

        echo "<div class=content>";
        echo "<h2> There are " . $counts['trackCount'] , " tracks.</h2>";
        echo "</div>";

        echo "<div class=content>";
        echo "<h2> Total length of all tracks: " . $counts['totalLength'] . "</h2>";
        echo "</div>";

        mysqli_close($conn);
    ?>
</html>
