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

                header("Location: viewArtist.php?edit=false&id=$artID");

                $sql = "UPDATE artist SET artName = '$newArtName' WHERE artID = $artID";
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
                            <p class='label'>ID:</p><input type="text" name="id" value='<?php echo $artID ?>' readonly="readonly"/><br>
                            <p class='label'>Artist Name: </p><input type="text" name='artName' value='<?php echo $artName ?>'/> <br>
                            <input type="checkbox" name="updateTime" value="update" checked/><span>Update Date Added</span><br>
                            <input type="submit" name="save" value="save"/>
                            <input type="button" name="cancel" value="cancel" onclick="window.location='/pages/viewArtist.php?edit=false&id=<?php echo $artID?>'"/>
                        </form>

                    <?php } else { ?>
                        <p class='label'>ID: </p><p class='output'><?php echo $artID?></p>
                        <p class='label'>Artist Name: </p> <p class='output'><?php echo $artName?></p>
                        <p class='label'>Added: </p> <p class='output'><?php echo timeSince($dateAdded)?></p>
                        <input type="button" name="edit" value="edit" onclick="window.location='/pages/viewArtist.php?edit=true&id=<?php echo $artID ?>'"/>                    
                        <input type="button" name="back" value="back" onclick="window.location='/pages/artist.php'"/>
                    <?php
                    }
                    mysqli_close($conn);
                ?>
            </div>
        
    </body>
</html>
