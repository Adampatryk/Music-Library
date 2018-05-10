<html>
    <?php 
        require "../php/header.html";
        require "../php/timeElapsed.php";
    ?>
    <body>
        <script src="../js/scroll.js"></script>
        <?php 
             
            require_once "../php/nav-bar.php";
            require '../php/connect.php';

            if (isset($_GET['save']) && $_GET['save'] == 'save'){
                $cdID = $_GET['id'];
                $newCDTitle = $_GET['cdTitle'];
                $newCDPrice = $_GET['cdPrice'];
                $newCDGenre = $_GET['cdGenre'];
                $newArtID = $_GET['artID'];

                header("Location: viewCD.php?&id=$cdID");

                $sql = "UPDATE cd 
                        SET cdTitle = '$newCDTitle',
                        cdPrice = '$newCDPrice',
                        cdGenre = '$newCDGenre',
                        artID = $newArtID,
                        dateAdded=dateAdded  
                        WHERE cdID = $cdID";

                echo mysqli_query($conn, $sql);

                if (isset($_GET['updateTime']) && $_GET['updateTime'] == 'update'){
                    $sql = "UPDATE cd SET dateAdded = NOW() WHERE cdID = $cdID";
                    mysqli_query($conn, $sql);
                }
            }

            ?>
            
            <div class="content">
                <?php 
                    
                    $cdID = $_GET['id'];

                    $sql = "SELECT * FROM cd WHERE cdID=$cdID";
                    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                    $cdID = $result['cdID'];
                    $cdTitle = $result['cdTitle'];
                    $artID = $result['artID'];
                    $cdPrice = $result['cdPrice'];
                    $cdGenre = $result['cdGenre'];
                    $dateAdded = $result['dateAdded'];
                    
                    $sql = "SELECT COUNT(*) as cdTracks FROM track WHERE cdID = $cdID";
                    $cdTracks = mysqli_fetch_assoc(mysqli_query($conn, $sql))['cdTracks'];

                    $sql = "SELECT artName FROM artist WHERE artID = $artID";
                    $cdArtist = mysqli_fetch_assoc(mysqli_query($conn, $sql))['artName'];

                    if (isset($_GET['edit']) && $_GET['edit'] == 'true'){
                        ?>

                        <form name="edit" method="GET" action="viewCD.php" onsubmit="return validateForm('addCDForm')">
                            <p class='label'>cd id:</p><input type="text" name="id" value='<?php echo $cdID ?>' readonly="readonly" required/ required><br>
                            <p class='label'>title: </p><input type="text" name='cdTitle' value='<?php echo $cdTitle ?>' required/> <br>
                            <p class='label'>artist: </p><input type="text" name='artID' value='<?php echo $artID ?>' required/> <br>
                            <p class='label'>price: </p><input type="text" name='cdPrice' value='<?php echo $cdPrice ?>' required/> <br>
                            <p class='label'>genre: </p><input type="text" name='cdGenre' value='<?php echo $cdGenre ?>' required/> <br>

                            <input type="checkbox" name="updateTime" value="update" checked/><span>Update Date Added</span><br>
                            <input type="submit" name="save" value="save"/>
                            <input type="button" name="cancel" value="cancel" onclick="window.location='/pages/viewCD.php?id=<?php echo $cdID?>'"/>
                        </form>

                    <?php } else { ?>
                        <p class='label'>cd id: </p><p class='output'><?php echo $cdID?></p>
                        <p class='label'>title: </p><p class='output'><?php echo $cdTitle?></p>
                        <p class='label'>artist: </p><p class='output'><?php echo $cdArtist?></p>
                        <p class='label'>price: </p><p class='output'><?php echo $cdPrice?></p>
                        <p class='label'>genre: </p><p class='output'><?php echo $cdGenre?></p>
                        <p class='label'>tracks: </p><p class='output'><?php echo $cdTracks?></p>
                        <p class='label'>added: </p><p class='output'><?php echo timeSince($dateAdded)?></p>
                        
                        <input type="button" name="edit" value="edit" onclick="window.location='/pages/viewCD.php?edit=true&id=<?php echo $cdID ?>'"/>                    
                        <input type="button" name="back" value="back to cds" onclick="window.location='/pages/cd.php'"/>
                    <?php
                    }
                ?>
            </div>

            <div class="content">
                <h1>tracks in '<?php echo $cdTitle ?>'</h1>

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

                            $sql = "SELECT * FROM track WHERE cdID=$cdID ORDER BY track.trackTitle";
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
                                <tr onclick='window.location="/pages/viewTrack.php?id=<?php echo $trackID?>"'>

                                <td><?php echo $trackTitle ?></td>
                                <td><?php echo $cdTitle?></td>
                                <td><?php echo $artName?></td>
                                <td><?php echo $trackLength?></td>
                                <td><?php echo $timeElapsed?></td>                     
                                <td><input class='icon' type='image' src='../res/trashcan.png' onclick='document.cookie = "scrollPos=" + document.body.scrollTop; confirmDelete(<?php echo $trackID?>, "<?php echo $trackTitle?>", "track"); event.stopPropagation();'/>
                                <input class='icon' type='image' src='../res/edit_pencil.png' onclick='window.location="/pages/viewTrack.php?edit=true&id=<?php echo $trackID?>"; event.stopPropagation();'/></td>
                                
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
