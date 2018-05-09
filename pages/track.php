<html> 
    <?php 
        require "../php/header.html";
        require "../php/timeElapsed.php";
        require '../php/connect.php';

        if(isset($_GET['addTrack'])){
            header("Location: track.php");

            $trackTitle = $_GET['trackTitle'];
            $trackLength = $_GET['trackLength'];
            $cdID = $_GET['cdID'];

            $sql = "INSERT INTO track(trackTitle, trackLength, cdID, dateAdded) VALUES ('$trackTitle', '$trackLength', $cdID, now())";
            mysqli_query($conn, $sql);
        }
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
                    <label for="trackLength">length(hh:mm:ss)</label>
                </div>
                <br>
                <div class="form-input">
                <p>cd</p>
                    <select name="cdID">
                        <option disabled selected value="">select cd</option>
                        <?php
                            $sql = "SELECT cdID, cdTitle, artName 
                                    FROM cd, artist 
                                    WHERE cd.artID = artist.artID
                                    ORDER BY artName";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)){
                                $cdID = $row['cdID'];
                                $cdTitle = $row['cdTitle'];
                                $artName = $row['artName'];
                        ?>
                                <option value=<?php echo $cdID?>> <?php echo $cdTitle?> - <?php echo $artName ?> </option> 

                        <?php
                            }
                        ?> 
                    </select>
                </div> 
                <input type="submit" name="addTrack" value="add track"/>
            </form>
        </div>


        <div class="content">
            <h1>tracks</h1>

            <?php require_once "../php/search-bar.php";?>

            <div class="table-wrapper">
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
                            $dateAdded = $row['dateAdded'];
                            $timeElapsed = timeSince($dateAdded);
                    
                    ?>

                            <tr onclick='window.location=\"/pages/viewTrack.php?id=$trackID\"'>

                            <td> <?php echo $trackTitle ?> </td>
                            <td> <?php echo $cdTitle ?> </td>
                            <td> <?php echo $artName ?> </td>
                            <td> <?php echo $trackLength ?> </td>
                            <td> <span hidden><?php echo $dateAdded?></span><?php echo $timeElapsed ?> </td>                     
                            <td> <input class=editIcon type='image' src='../res/trashcan.png' onclick='confirmDelete( <?php echo $trackID?>, "<?php echo $trackTitle?>", "track"); event.stopPropagation();'/>
                            <input class=deleteIcon type='image' src='../res/edit_pencil.png' onclick='window.location="/pages/viewTrack.php?edit=true&id= <?php echo $trackID?>"; event.stopPropagation();'/></td>
                            
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