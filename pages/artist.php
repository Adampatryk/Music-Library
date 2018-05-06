<html>
    <?php 
    require "../php/header.html";
    require "../php/timeElapsed.php";
    ?>
    <body>
        <?php require_once "../php/nav-bar.php"?>

        <div class="content">
            <h1>add a new artist</h1>
            <form method="GET" action="artist.php">
                <div class="form-input">
                    <input type="text" id="artistName" name="artistName" required>
                    <label for="artistName">name</label>
                </div>
                <br>
                <input type="submit" name="formSubmit" value="add artist"/>
            </form>
        </div>
        <div class="content">
            <h1>artists</h1>

            <?php
                require '../php/connect.php';

                if(isset($_GET['formSubmit'])){
                    header("Location: artist.php");

                    $artistName = $_GET['artistName'];
                    $sql = "INSERT INTO artist VALUES (null, '$artistName', now())";
                    mysqli_query($conn, $sql);
                }
                $sql = "SELECT * FROM artist ORDER BY artist.artName";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    $artID = $row['artID'];
                    $artName = $row['artName'];
                    echo "<div class='row'><p class='title'>$artName</p>";
                    echo "<input class=editIcon type='image' src='../res/edit_pencil.png' onclick='confirmDelete($artID, \"$artName\", \"artist\")'/>";
                    echo "<input class=deleteIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($artID, \"$artName\", \"artist\")'/>";
                    echo "<p class='added'>" . timeSince($row['dateAdded']) . "</p>";
                    echo "</div>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
