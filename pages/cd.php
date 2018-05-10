<html>
    <?php 
        require "../php/header.html";   
        require "../php/timeElapsed.php";
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
    ?> 
    <body>
        <script src="../js/scroll.js"></script>
        <?php 
            require_once "../php/nav-bar.php";
        ?>

        <div class="content">
            <h1>add a new cd</h1>
            <form name="addCDForm" method="GET" action="cd.php" onsubmit="return validateForm('addCDForm')">
                <div class="form-input">
                    <input type="text" id="cdTitle" name="cdTitle" required>
                    <label for="cdTitle">title</label>
                </div>
                <br>
                <div class="form-input">
                    <p>artist</p>
                    <select name="artID">
                        <option disabled selected value="" required>select artist</option>
                        <?php
                            $sql = "SELECT artID, artName FROM artist ORDER BY artName";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)){
                                $artID = $row['artID'];
                                $artName = $row['artName'];
                        ?>

                                <option value=<?php echo $artID?>> <?php echo $artName?> </option> 

                        <?php
                            }
                        ?> 
                    </select>
                </div>
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

            <div class="table-wrapper">
                <table id="result">
                    <tr>
                        <th class="ascending" onclick="sort(0)">title<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(1)">artist<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(2)">price<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(3)">genre<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(4)">tracks<img src="../res/arrow_up.png"/></th>                        
                        <th class="unsorted" onclick="sort(5)">total length (hh:mm:ss)<img src="../res/arrow_up.png"/></th>
                        <th class="unsorted" onclick="sort(6)">added<img src="../res/arrow_up.png"/></th>
                        <th></th>
                    </tr>

                    <?php

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

                            $sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(trackLength))) as cdTotalTime
                                    FROM track
                                    WHERE cdID = $cdID";

                            $cdTotalTime = mysqli_fetch_assoc(mysqli_query($conn, $sql))['cdTotalTime'];
                            if (!$cdTotalTime){$cdTotalTime = '00:00:00';}

                    ?>

                            <tr onclick='window.location="/pages/viewCD.php?id=<?php echo $cdID?>"'>

                            <td><?php echo $cdTitle?></td>
                            <td><?php echo $artName?></td>
                            <td><?php echo $cdPrice?></td>
                            <td><?php echo $cdGenre?></td>
                            <td><?php echo $cdTracks?></td>
                            <td><?php echo $cdTotalTime?></td>
                            <td><?php echo $timeElapsed?></td>

                            <td><input id='icon' type='image' src='../res/trashcan.png' onclick='document.cookie = "scrollPos=" + document.body.scrollTop; confirmDelete(<?php echo $cdID?>, "<?php echo $cdTitle?>", "cd"); event.stopPropagation();'/>
                            <input id='icon' type='image' src='../res/edit_pencil.png' onclick='window.location="/pages/viewCD.php?edit=true&id=<?php echo $cdID?>"; event.stopPropagation();'/></td>
                        
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