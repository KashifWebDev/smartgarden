<?php
    require 'modules/app.php';
    $page_identifier = "./";
    $title = "Add Device";
    verify_is_admin();
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'modules/head.php'; ?>
    </head>
    <body>
        <?php require 'modules/navbar.php'; ?>

            <p class="display-3 text-center my-3 text-info">
                Add Device
            </p>

        <?php require 'modules/footer.php'; ?>
    </body>

</html>