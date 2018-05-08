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
                            <p class='label'>CD ID:</p><input type="text" name="id" value='<?php echo $cdID ?>' readonly="readonly"/><br>
                            <p class='label'>Title: </p><input type="text" name='cdTitle' value='<?php echo $cdTitle ?>'/> <br>
                            <p class='label'>Artist: </p><input type="text" name='artID' value='<?php echo $artID ?>'/> <br>
                            <p class='label'>Price: </p><input type="text" name='cdPrice' value='<?php echo $cdPrice ?>'/> <br>
                            <p class='label'>Genre: </p><input type="text" name='cdGenre' value='<?php echo $cdGenre ?>'/> <br>

                            <input type="checkbox" name="updateTime" value="update" checked/><span>Update Date Added</span><br>
                            <input type="submit" name="save" value="save"/>
                            <input type="button" name="cancel" value="cancel" onclick="window.location='/pages/viewCD.php?id=<?php echo $cdID?>'"/>
                        </form>

                    <?php } else { ?>
                        <p class='label'>CD ID: </p><p class='output'><?php echo $cdID?></p>
                        <p class='label'>Title: </p><p class='output'><?php echo $cdTitle?></p>
                        <p class='label'>Artist: </p><p class='output'><?php echo $cdArtist?></p>
                        <p class='label'>Price: </p><p class='output'><?php echo $cdPrice?></p>
                        <p class='label'>Genre: </p><p class='output'><?php echo $cdGenre?></p>
                        <p class='label'>Tracks: </p><p class='output'><?php echo $cdTracks?></p>
                        <p class='label'>Added: </p><p class='output'><?php echo timeSince($dateAdded)?></p>
                        
                        <input type="button" name="edit" value="edit" onclick="window.location='/pages/viewCD.php?edit=true&id=<?php echo $cdID ?>'"/>                    
                        <input type="button" name="back" value="back" onclick="window.location='/pages/cd.php'"/>
                    <?php
                    }
                    mysqli_close($conn);
                ?>
            </div>
        
    </body>
</html>
