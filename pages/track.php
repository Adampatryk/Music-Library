<html> 
    <?php require "../php/header.html" ?>
    <body>
        <?php require_once "../php/nav-bar.php"?>

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
                    <label for="trackLength">length</label>
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
            <h1>Tracks</h1>

            <?php
                require '../php/connect.php';

                if(isset($_GET['formSubmit'])){

                    $trackTitle = $_GET['trackTitle'];
                    $trackLength = $_GET['trackLength'];
                    $cdID = $_GET['cdID'];

                    $sql = "INSERT INTO track(trackTitle, trackLength, cdID) VALUES ('$trackTitle', '$trackLength', '$cdID')";
                    mysqli_query($conn, $sql);
                }

                $sql = "SELECT * FROM track ORDER BY track.trackTitle";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    $trackID = $row['trackID'];
                    $trackTitle = $row['trackTitle'];
                    echo "<div class='row'><p>$trackTitle</p>";
                    echo "<input type='image' src='../res/trashcan.png' onclick='confirmDelete($trackID, \"$trackTitle\", \"track\")'/>";
                    echo "</div>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
