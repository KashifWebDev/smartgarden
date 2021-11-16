<?php
    require 'modules/app.php';
check_session();
    $page_identifier = "./";
    $title = "Dashbaord";
?>
<!doctype html>
<html lang="en">
<head>
    <?php require 'modules/head.php'; ?>
    <!-- Start of DataTables -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/css/mdb.min.css" rel="stylesheet">
    <link href="assets/css/datatables/datatables.min.css" rel="stylesheet">
    <!-- End of DataTables -->
</head>
    <?php
        require 'modules/classes/class.users.php';
        $configs = new Users();
        $user_data = $configs->getUserInfo($_SESSION["email"]);
    ?>
    <body>
        <?php require 'modules/navbar.php'; ?>

        <div class="container-fluid custom-container mt-5">
            <!--  TOp Cards -->
            <div class="row justify-content-around custom-padding-9-15">

                <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                    <div class="dark-box text-center">
                        <div class="d-flex justify-content-center">
                            <i class="fas fa-hdd fa-3x"></i>
                            <p id="number_text" class="heading-font-1 ml-4">23</p>
                        </div>
                        <p id="bottom_heading" class="heading-font-2">Total Devices</p>
                    </div>
                </div>
                <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                    <div class="dark-box text-center">
                        <div class="d-flex justify-content-center">
                            <i class="fas fa-exclamation-triangle fa-3x"></i>
                            <p id="number_text" class="heading-font-1 ml-4">23</p>
                        </div>
                        <p id="bottom_heading" class="heading-font-2">Total Alerts</p>
                    </div>
                </div>
                <div class="col-sm-12 mb-sm-4 col-md-4 col-lg-3 col-xl-3">
                    <div class="dark-box text-center">
                        <div class="d-flex justify-content-center">
                            <i class="fas fa-signal fa-3x"></i>
                            <p id="number_text" class="heading-font-1 ml-4">23</p>
                        </div>
                        <p id="bottom_heading" class="heading-font-2">Online Devices</p>
                    </div>
                </div>
            </div>
            <!-- END OF CARDS -->
            <!-- End OF Main Container -->
        </div>


        <div class="container mt-5">
            <div class="col-12 dark-box">
                <table id="dtBasicExample" class="table table-striped table-bordered table-hover-custom" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th class="th-sm">Device Name</th>
                        <th class="th-sm">Email</th>
                        <th class="th-sm">Device MAC</th>
                        <th class="th-sm">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    require 'modules/db.php';
                    $sql = "SELECT * FROM user_and_devices WHERE user_id=".$_SESSION["id"];
                    //echo $sql;
                    $res = mysqli_query($con, $sql);
                    while ($row = mysqli_fetch_array($res)){
                        echo '
                                    <tr>
                                        <td>'.$row["device_name"].'</td>
                                        <td>'.$row["mailing_address"].'</td>
                                        <td>'.$row["mac"].'</td>
                                        <td>
                                            <a href="device-details.php?id='.$row["id"].'" class="link-custom text-success">Details</a> |
                                            <a href="admin_dashboard.php?del_userid='.$row["id"].'" class="link-custom text-danger">Delete</a>
                                        </td>
                                    </tr>
                                ';
                    }


                    ?>
                    </tbody>
                </table>
            </div>
        </div>




        <?php require 'modules/footer.php'; ?>
        <!-- Start of DataTables -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.11/js/mdb.min.js"></script>
        <script type="text/javascript" src="assets/js/datatables/datatables.min.js"></script>
        <!-- End of DataTables -->
        <script>
            $(document).ready(function () {
                $('#dtBasicExample').DataTable();
                $('.dataTables_length').addClass('bs-select');
            });
        </script>
    </body>

</html>