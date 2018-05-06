<html> 
    <?php 
        require "../php/header.html";
        require "../php/timeElapsed.php";
    ?>
    <body>
        <?php require_once "../php/nav-bar.php";?>

        <div class="content">
            <h1>add a new track</h1>
            <form method="GET" action="track.php">
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
                <input type="submit" name="formSubmit" value="add track"/>
            </form>
        </div>

        <div class="content">
            <h1>tracks</h1>

            <?php
                require '../php/connect.php';

                if(isset($_GET['formSubmit'])){
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
                    echo "<div class='row'><p class='title'>$trackTitle</p>";
                    echo "<input class=editIcon type='image' src='../res/edit_pencil.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/>";
                    echo "<input class=deleteIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/>";
                    echo "<p class='added'>" . timeSince($row['dateAdded']) . "</p>";
                    echo "</div>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
