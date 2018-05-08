<html>
    <?php 
    require "../php/header.html";
    require "../php/timeElapsed.php";
    ?>
    <body>
        <?php 
        
            require_once "../php/nav-bar.php";
            require '../php/connect.php';
        ?>

        <div class="content">
            <h1>add a new artist</h1>
            <form name="addArtistForm" method="GET" action="artist.php" onsubmit="return validateForm('addArtistForm')">
                <div class="form-input">
                    <input type="text" id="artistName" name="artistName" required>
                    <label for="artistName">name</label>
                </div>
                <br>
                <input type="submit" name="addArtist" value="add artist"/>
            </form>
        </div>
        
        <div class="content">
            <h1>artists</h1>

            <?php require_once "../php/search-bar.php"?>

            <div class="table-wrapper">
                <table id="result">
                    <tr> 
                        <th class="ascending" onclick="sort(0)">name<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(1)">tracks<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(2)">added<img src="../res/arrow_up.png"/></th>
                        <th></th>
                    </tr>

                    <?php
                        if(isset($_GET['addArtist'])){
                            header("Location: artist.php");

                            $artistName = $_GET['artistName'];
                            $sql = "INSERT INTO artist VALUES (null, '$artistName', now())";
                            mysqli_query($conn, $sql);
                        }
                        $sql = "SELECT * FROM artist ORDER BY artName";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)){
                            $artID = $row['artID'];
                            $artName = $row['artName'];

                            $sql = "SELECT COUNT(*) AS artTracks  
                                    FROM track, cd 
                                    WHERE track.cdID = cd.cdID 
                                    AND cd.artID = $artID";

                            $artTracks = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artTracks'];
                    ?>

                            <tr onclick='window.location="/pages/viewArtist.php?id=<?php echo $artID ?>"'>
                            
                            <td> <?php echo $artName ?> </td>
                            <td> <?php echo $artTracks ?> </td>
                            <td> <?php echo timeSince($row['dateAdded']) ?> </td>
                            <td><input class='editIcon' type='image' src='../res/trashcan.png' onclick='confirmDelete(<?php echo $artID ?>, <?php echo "$artName" ?>, "artist"); event.stopPropagation();'/>
                            <input class='deleteIcon' type='image' src='../res/edit_pencil.png' onclick='window.location="/pages/viewArtist.php?edit=true&id=<?php echo $artID ?>"; event.stopPropagation();'/></td>
                            
                            </tr>
                    <?php
                        }
                        mysqli_close($conn);
                    ?>

                </table>
            </div>
        </div>
    </body>
</html>
