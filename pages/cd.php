<html>
    <?php 
        require "../php/header.html";   
        require "../php/timeElapsed.php";
    ?> 
    <body>
        <?php require_once "../php/nav-bar.php"?>

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
                <input type="submit" name="formSubmit" value="add cd"/>
            </form>
        </div>

        <div class="content">
            <h1>cds</h1>

            <?php
                require '../php/connect.php';

                if(isset($_GET['formSubmit'])){
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
                    echo "<div class='row'><p class='title'>$cdTitle</p>";
                    echo "<input id=editIcon type='image' src='../res/edit_pencil.png' onclick='confirmDelete($cdID, \"$cdTitle\", \"cd\")'/>";
                    echo "<input id=deleteIcon type='image' src='../res/trashcan.png' onclick='confirmDelete($cdID, \"$cdTitle\", \"cd\")'/>";
                    echo "<p class='added>" . timeSince($row['dateAdded']) . "</p>";
                    echo "</div>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
