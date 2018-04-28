<html>
    <head>
        <title>Music Library</title>
        <link href="../css/main.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php require_once "../php/nav-bar.php"?>

        <div class="content">
            <?php
                require '../php/connect.php';

                $sql = "SELECT * FROM cd ORDER BY cd.cdID";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>" . $row['cdID'] . "</td>";
                    echo "<td>" . $row['cdTitle'] . "</td>";
                    echo "</tr>";
                }
                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>
