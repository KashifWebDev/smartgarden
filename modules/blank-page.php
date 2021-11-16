<?php
    $page_identifier = "./";
    $title = "Home Page";
    require 'modules/app.php';
?>
<!doctype html>
<html lang="en">
    <?php require 'modules/head.php'; ?>
    <body>
        <?php require 'modules/navbar.php'; ?>



        <?php require 'modules/footer.php'; ?>


        <script>
            // Get the current year for the copyright
            $('#yearnow').text(new Date().getFullYear());
        </script>
    </body>

</html>