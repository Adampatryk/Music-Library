<html>
    <?php 
        require "../php/header.html";   
        require "../php/timeElapsed.php";
    ?> 
    <body>
        <?php require_once "../php/nav-bar.php"?>

        <div class="content">
            <h1>add a new cd</h1>
            <form name="addCDForm" method="GET" action="cd.php" onsubmit="return validateForm('addCDForm')">
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

            <?php require_once "../php/search-bar.php"?>

            <table id="result">
                <tr>
                    <th class="ascending" onclick="sort(0)">title<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(1)">artist<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(2)">price<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(3)">genre<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(4)">tracks<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(5)">added<img src="../res/arrow_up.png"/></th>
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

                    $sql = "SELECT * FROM cd ORDER BY cdTitle";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)){

                        $cdID = $row['cdID'];
                        $cdTitle = $row['cdTitle'];
                        $artID = $row['artID'];

                        $sql = "SELECT artist.artName FROM artist WHERE artID = $artID";
                        $artName = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artName'];

                        $sql = "SELECT COUNT(*) as cdTracks FROM track WHERE track.cdID = $cdID";
                        $cdTracks = mysqli_fetch_assoc(mysqli_query($conn, $sql))['cdTracks'];

                        $cdPrice = $row['cdPrice'];
                        $cdGenre = $row['cdGenre'];
                        $timeElapsed = timeSince($row['dateAdded']);

                        echo "<tr onclick='window.location=\"/pages/viewCD.php?id=$cdID\"'>";

                        echo "<td>$cdTitle</td>";
                        echo "<td>$artName</td>";
                        echo "<td>$cdPrice</td>";
                        echo "<td>$cdGenre</td>";
                        echo "<td>$cdTracks</td>";
                        echo "<td>$timeElapsed</td>";

                        echo "<td><input id=editIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($cdID, \"$cdTitle\", \"cd\")'/>";
                        echo "<input id=deleteIcon type='image' src='../res/edit_pencil.png' onclick='window.location=\"/pages/viewCD.php?edit=true&id=$cdID\"'/></td>";
                     
                        echo "</tr>";
                    }
                    mysqli_close($conn);
                ?>
        </div>
    </body>
</html>
