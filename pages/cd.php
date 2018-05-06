<html>
    <?php require "../php/header.html" ?>   
    <body>
        <?php require_once "../php/nav-bar.php"?>

        <div class="content">
            <h1>add a new cd</h1>
            <form method="GET" action="cd.php">
                <div class="form-input">
                    <input type="text" id="cdTitle" name="cdTitle" required>
                    <label for="cdTitle">Title</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="artID" name="artID" required>
                    <label for="artID">Artist</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="cdPrice" name="cdPrice" required>
                    <label for="cdPrice">Price</label>
                </div>
                <br>
                <div class="form-input">
                    <input type="text" id="cdGenre" name="cdGenre" required>
                    <label for="cdGenre">Genre</label>
                </div>
                <br>
                <input type="submit" name="formSubmit" value="Add CD"/>
            </form>
        </div>

        <div class="content">
            <h1>CDs</h1>

            <?php
                require '../php/connect.php';

                if(isset($_GET['formSubmit'])){

                    $cdTitle = $_GET['cdTitle'];
                    $artID = $_GET['artID'];
                    $cdPrice = $_GET['cdPrice'];
                    $cdGenre = $_GET['cdGenre'];

                    $sql = "INSERT INTO cd(cdTitle, artID, cdPrice, cdGenre) VALUES ('$cdTitle', '$artID', '$cdPrice', '$cdGenre')";
                    mysqli_query($conn, $sql);
                }

                $sql = "SELECT * FROM cd ORDER BY cd.cdTitle";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    $cdID = $row['cdID'];
                    $cdTitle = $row['cdTitle'];
                    echo "<div class='row'><p>$cdTitle</p>";
                    echo "<input type='image' src='../res/trashcan.png' onclick='confirmDelete($cdID, \"$cdTitle\", \"cd\")'/>";
                    echo "</div>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
