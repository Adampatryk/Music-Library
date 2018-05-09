<html>
    <?php 
        require "../php/header.html";
        require "../php/timeElapsed.php";
    ?>
    <body>
        <?php 
             
            require_once "../php/nav-bar.php";
            require '../php/connect.php';

            if (isset($_GET['save']) && $_GET['save'] == 'save'){
                $trackID = $_GET['id'];
                $newTrackTitle = $_GET['trackTitle'];
                $newTrackLength = $_GET['trackLength'];
                $newTrackCDID = $_GET['cdID'];


                $sql = "UPDATE track
                        SET trackTitle = '$newTrackTitle',
                        trackLength = '$newTrackLength',
                        cdID = '$newTrackCDID',
                        dateAdded=dateAdded
                        WHERE trackID = $trackID";

                mysqli_query($conn, $sql);

                if (isset($_GET['updateTime']) && $_GET['updateTime'] == 'update'){
                    $sql = "UPDATE track SET dateAdded = NOW() WHERE trackID = $trackID";
                    mysqli_query($conn, $sql);
                }
            }

            ?>
            
            <div class="content">
                <?php 
                    
                    $trackID = $_GET['id'];

                    $sql = "SELECT * FROM track WHERE trackID=$trackID";
                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                    $trackID = $result['trackID'];
                    $trackTitle = $result['trackTitle'];
                    $trackLength = $result['trackLength'];
                    $cdID = $result['cdID'];
                    $dateAdded = $result['dateAdded'];

                    $sql = "SELECT artID, cdTitle FROM cd WHERE cdID = $cdID";
                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                    $cdTitle = $result['cdTitle'];
                    $artID = $result['artID'];

                    $sql = "SELECT artName FROM artist WHERE artID = $artID";
                    $cdArtist = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artName'];

                    if (isset($_GET['edit']) && $_GET['edit'] == 'true'){
                        ?>

                        <form name="edit" method="GET" action="viewTrack.php" onsubmit="return validateForm('addTrackForm')">
                            <p class='label'>track id:</p><input type="text" name="id" value='<?php echo $trackID ?>' readonly="readonly" required/><br>
                            <p class='label'>title: </p><input type="text" name='trackTitle' value='<?php echo $trackTitle ?>' required/> <br>
                            <p class='label'>cd title: </p>
                            <select name="cdID">
                                <?php
                                    $sql = "SELECT cdID, cdTitle, artName 
                                            FROM cd, artist 
                                            WHERE cd.artID = artist.artID
                                            ORDER BY artName";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)){
                                        $tmpcdID = $row['cdID'];
                                        $cdTitle = $row['cdTitle'];
                                        $artName = $row['artName'];
                                ?>
                                        <option value=<?php echo $tmpcdID; if($tmpcdID == $cdID){echo ' selected';};?>> <?php echo $cdTitle?> - <?php echo $artName ?> </option> 

                                <?php
                                    }
                                ?> 
                            </select>
                            <p class='label'>length: </p><input type="text" name='trackLength' value='<?php echo $trackLength ?>' required/> <br>

                            <input type="checkbox" name="updateTime" value="update" checked/><span>Update Date Added</span><br>
                            <input type="submit" name="save" value="save"/>
                            <input type="button" name="cancel" value="cancel" onclick="window.location='/pages/viewTrack.php?id=<?php echo $trackID?>'"/>
                        </form>

                    <?php } else { ?>
                        <p class='label'>track id: </p><p class='output'><?php echo $trackID?></p>
                        <p class='label'>title: </p><p class='output'><?php echo $trackTitle?></p>
                        <p class='label'>artist: </p><p class='output'><?php echo $cdArtist?></p>
                        <p class='label'>cd title: </p><p class='output'><?php echo $cdTitle?></p>
                        <p class='label'>length: </p><p class='output'><?php echo $trackLength?></p>
                        <p class='label'>added: </p><p class='output'><?php echo timeSince($dateAdded)?></p>
                        
                        <input type="button" name="edit" value="edit" onclick="window.location='/pages/viewTrack.php?edit=true&id=<?php echo $trackID ?>'"/>                    
                        <input type="button" name="back" value="back to tracks" onclick="window.location='/pages/track.php'"/>
                    <?php
                    }
                    mysqli_close($conn);
                ?>
            </div>
        
    </body>
</html>
