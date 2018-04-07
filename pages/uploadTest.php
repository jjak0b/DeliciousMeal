<!DOCTYPE html>
<?php
    include_once('../config.php' );
    include('../scripts/utility.php' );
?>
<html>
    <head>
        <title>upload</title>
        <?php
            include_once("../head.php");
        ?>
    </head>
    <body>
        <?php
            include_once('../header.php' );
        ?>
        <div class="connection">
            <?php
            ?>
        </div>
        <div class="main">
            <div class="container">
                <form action="scripts/upload.php" method="post" enctype="multipart/form-data">
                    <label>Select image to upload:</label><input type="file" name="uploadedFile" id="uploadedFile">
                    <input type="submit" value="Upload Image" name="submit">
                </form>
            </div>
        </div>
    </body>
</html>