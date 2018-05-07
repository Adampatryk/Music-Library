<html>
    <?php 
        require "../php/header.html";   
        require "../php/timeElapsed.php";
    ?> 
    <body>
        <?php require_once "../php/nav-bar.php"?>
        <?php require_once "../php/search-bar.php";?>

        <div class="content">
            <h1>add a new cd</h1>
            <form method="GET" action="cd.php">
                <div class="form-input">
                    <input type="text" id="cdTitle" name="cdTitle" required>
                    <label for="cdTitle">title</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="artID" name="artID" required>
                    <label for="artID">artist</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="cdPrice" name="cdPrice" required>
                    <label for="cdPrice">price</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="cdGenre" name="cdGenre" required>
                    <label for="cdGenre">genre</label>
                </div>
                <br>
                <input type="submit" name="addCD" value="add cd"/>
            </form>
        </div>

        <div class="content">
            <h1>cds</h1>

            <table>
                <tr>
                    <th>title</th>
                    <th>artist</th>
                    <th>price</th>
                    <th>genre</th>
                    <th>added</th>
                    <th></th>
                    <th></th>
                </tr>

                <?php
                    require '../php/connect.php';

                    if(isset($_GET['addCD'])){
                        header("Location: cd.php");

                        $cdTitle = $_GET['cdTitle'];
                        $artID = $_GET['artID'];
                        $cdPrice = $_GET['cdPrice'];
                        $cdGenre = $_GET['cdGenre'];

                        $sql = "INSERT INTO cd(cdTitle, artID, cdPrice, cdGenre, dateAdded) VALUES ('$cdTitle', '$artID', '$cdPrice', '$cdGenre', now())";
                        mysqli_query($conn, $sql);
                    }

                    $sql = "SELECT * FROM cd ORDER BY cd.cdTitle";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)){

                        $cdID = $row['cdID'];
                        $cdTitle = $row['cdTitle'];
                        $artID = $row['artID'];

                        $sql = "SELECT artist.artName FROM artist WHERE artID = $artID";
                        $artName = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artName'];

                        $cdPrice = $row['cdPrice'];
                        $cdGenre = $row['cdGenre'];
                        $timeElapsed = timeSince($row['dateAdded']);

                        echo "<tr>";

                        echo "<td>$cdTitle</td>";
                        echo "<td>$artName</td>";
                        echo "<td>$cdPrice</td>";
                        echo "<td>$cdGenre</td>";
                        echo "<td>$timeElapsed</td>";

                        echo "<td><input id=editIcon type='image' src='../res/edit_pencil.png' onclick='confirmDelete($cdID, \"$cdTitle\", \"cd\")'/></td>";
                        echo "<td><input id=deleteIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($cdID, \"$cdTitle\", \"cd\")'/></td>";
                     
                        echo "</tr>";
                    }
                    mysqli_close($conn);
                ?>
        </div>
    </body>
</html>
