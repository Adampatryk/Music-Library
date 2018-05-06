<html>
    <head>
        <title>Music Library</title>
        <link href="../css/main.css" rel="stylesheet" type="text/css"/>
        <script src="../js/delete.js"></script>
        <link rel="icon" href="../res/music_library.png"/>
    </head>
    <body>
        <?php require_once "../php/nav-bar.php"?>

        <div class="content">
            <h1>ADD A NEW ARTIST</h1>
            <form method="GET" action="artist.php">
                <div class="form-input">
                    <input type="text" id="artistName" name="artistName" required>
                    <label for="artistName">Artist Name</label>
                </div>
                <br>
                <input type="submit" name="formSubmit" value="Add Artist"/>
            </form>
        </div>
        <div class="content">
            <h1>ARTISTS</h1>

            <?php
                require '../php/connect.php';

                if(isset($_GET['formSubmit'])){
                    header("Location: artist.php");
                    $artistName = $_GET['artistName'];
                    $sql = "INSERT INTO artist VALUES (null, '$artistName')";
                    mysqli_query($conn, $sql);
                }
                $sql = "SELECT * FROM artist ORDER BY artist.artName";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    $artID = $row['artID'];
                    $artName = $row['artName'];
                    echo "<div class='row'><p>$artName</p>";
                    echo "<input type='image' src='../res/trashcan.png' onclick='confirmDelete($artID, \"$artName\", \"artist\")'/>";
                    echo "</div>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
