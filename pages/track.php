<html> 
    <?php 
        require "../php/header.html";
        require "../php/timeElapsed.php";
    ?>
    <body>
        <?php require_once "../php/nav-bar.php";?>

        <div class="content">
            <h1>add a new track</h1>
            <form name="addTrackForm" method="GET" action="track.php" onsubmit="return validateForm('addTrackForm')">
                <div class="form-input">
                    <input type="text" id="trackTitle" name="trackTitle" required>
                    <label for="trackTitle">title</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="trackLength" name="trackLength" required>
                    <label for="trackLength">length(s)</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="cdID" name="cdID" required>
                    <label for="cdID">cd</label>
                </div>
                <br>
                <input type="submit" name="addTrack" value="add track"/>
            </form>
        </div>


        <div class="content">
            <h1>tracks</h1>

            <?php require_once "../php/search-bar.php";?>

            <table id="result">
                <tr>
                    <th class="ascending" onclick="sort(0)">title<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(1)">cd<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(2)">artist<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(3)">length<img src="../res/arrow_up.png"/></th>
                    <th class="unsorted" onclick="sort(4)">added<img src="../res/arrow_up.png"/></th>
                    <th></th>
                </tr>

                <?php
                    require '../php/connect.php';

                    if(isset($_GET['addTrack'])){
                        header("Location: track.php");

                        $trackTitle = $_GET['trackTitle'];
                        $trackLength = $_GET['trackLength'];
                        $cdID = $_GET['cdID'];

                        $sql = "INSERT INTO track(trackTitle, trackLength, cdID, dateAdded) VALUES ('$trackTitle', '$trackLength', $cdID, now())";
                        mysqli_query($conn, $sql);
                    }

                    $sql = "SELECT * FROM track ORDER BY track.trackTitle";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)){

                        $trackID = $row['trackID'];
                        $trackTitle = $row['trackTitle'];

                        $cdID = $row['cdID'];
                        $sql = "SELECT cd.artID, cd.cdTitle FROM cd WHERE cdID = $cdID";
                        $tmpResult = mysqli_fetch_assoc(mysqli_query($conn, $sql));
                        $cdTitle = $tmpResult['cdTitle'];
                        
                        $artID = $tmpResult['artID'];
                        $sql = "SELECT artist.artName FROM artist WHERE artID = $artID";
                        $artName = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artName'];



                        $trackLength = $row['trackLength'];
                        $timeElapsed = timeSince($row['dateAdded']);

                        echo "<tr>";

                        echo "<td>$trackTitle</td>";
                        echo "<td>$cdTitle</td>";
                        echo "<td>$artName</td>";
                        echo "<td>$trackLength</td>";
                        echo "<td>$timeElapsed</td>";
                        echo "<td><input class=editIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/>";
                        echo "<input class=deleteIcon type='image' src='../res/edit_pencil.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/></td>";
                        
                        echo "</tr>";
                    }
                    mysqli_close($conn);
                ?>
        </div>
    </body>
</html>
