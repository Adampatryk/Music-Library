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
                $artID = $_GET['id'];
                $newArtName = $_GET['artName'];

                header("Location: viewArtist.php?&id=$artID");

                $sql = "UPDATE artist 
                        SET artName = '$newArtName',
                        dateAdded=dateAdded
                        WHERE artID = $artID";
                mysqli_query($conn, $sql);

                if (isset($_GET['updateTime']) && $_GET['updateTime'] == 'update'){
                    $sql = "UPDATE artist SET dateAdded = NOW() WHERE artID = $artID";
                    mysqli_query($conn, $sql);
                }
        
            }

            ?>
            
            <div class="content">
                <?php 
                    
                    $artID = $_GET['id'];

                    $sql = "SELECT * FROM artist WHERE artID=$artID";
                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                    $artID = $result['artID'];
                    $artName = $result['artName'];
                    $dateAdded = $result['dateAdded'];

                    if (isset($_GET['edit']) && $_GET['edit'] == 'true'){
                ?>

                <form name="edit" method="GET" action="viewArtist.php" onsubmit="return validateForm('addArtistForm')">
                    <p class='label'>id:</p><input type="text" name="id" value='<?php echo $artID ?>' readonly="readonly" required/><br>
                    <p class='label'>artist name: </p><input type="text" name='artName' value='<?php echo $artName ?>'required/> <br>
                    <input type="checkbox" name="updateTime" value="update" checked/><span>Update Date Added</span><br>
                    <input type="submit" name="save" value="save"/>
                    <input type="button" name="cancel" value="cancel" onclick="window.location='/pages/viewArtist.php?edit=false&id=<?php echo $artID?>'"/>
                </form>

                <?php } else { ?>

                <p class='label'>id: </p><p class='output'><?php echo $artID?></p>
                <p class='label'>artist name: </p> <p class='output'><?php echo $artName?></p>
                <p class='label'>added: </p> <p class='output'><?php echo timeSince($dateAdded)?></p>
                <input type="button" name="edit" value="edit" onclick="window.location='/pages/viewArtist.php?edit=true&id=<?php echo $artID ?>'"/>                    
                <input type="button" name="back" value="back to artists" onclick="window.location='/pages/artist.php'"/>
                             
            </div>
                <div class="content">
                    <h1>tracks by '<?php echo $artName ?>'</h1>
                    
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
                                $sql = "SELECT * 
                                        FROM track, cd 
                                        WHERE track.cdID = cd.cdID 
                                        AND cd.artID = $artID 
                                        ORDER BY track.trackTitle";
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
                                    $timeElapsed = timeSince($row['dateAdded']);
                            ?>

                                <tr onclick="window.location='/pages/viewTrack.php?id=<?php echo $trackID ?>'">
                                    <td> <?php echo $trackTitle ?> </td>
                                    <td> <?php echo $cdTitle ?> </td>
                                    <td> <?php echo $artName ?> </td>
                                    <td> <?php echo $trackLength ?> </td>
                                    <td> <?php echo $timeElapsed ?> </td>
                                    <td> <input class='icon' type='image' src='../res/trashcan.png' onclick='confirmDelete(<?php echo $trackID?>, <?php echo "$trackTitle" ?>, "track")'/>
                                    <input class='icon' type='image' src='../res/edit_pencil.png' onclick='confirmDelete(<?php echo $trackID?>, <?php echo "$trackTitle" ?>, "track")'/></td>
                                
                                </tr>
                            <?php 
                                } 
                            ?>
                        </table>
                    </div>
                </div>
            <?php
                }
                mysqli_close($conn);
            ?>
        
    </body>
</html>
