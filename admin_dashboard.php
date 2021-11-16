<?php
    require 'modules/app.php';
    check_session();
    verify_is_admin();
    $page_identifier = "./";
    $title = "Dashbaord";
?>
<!doctype html>
<html lang="en">
    <head>
        <?php require 'modules/head.php'; ?>
    </head>
    <body>
    <?php require 'modules/navbar.php'; ?>
            <div class="container mt-5">
                <div class="d-flex">
                    <div class="">
                        <div class="d-flex dark-box text-center" style="padding: 5px 15px;">
                            <img class="height-120" src="assets/images/Humidity-icon.png">
                            <div class="justify-content-center d-block m-0 align-self-center">
                                <p id="bottom_heading" class="heading-font-2 m-0 ml-3">Humidity</p>
                                <p id="number_text" class="xxx-larger m-0">68&nbsp;%</p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-5">
                        <div class="d-flex dark-box text-center" style="padding: 5px 15px;">
                            <img class="height-120" src="assets/images/temperature-icon.png">
                            <div class="justify-content-center d-block m-0 align-self-center">
                                <p id="bottom_heading" class="heading-font-2 m-0 ml-3">Temperature</p>
                                <p id="number_text" class="xxx-larger m-0">8&nbsp;&#8451;</p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-5">
                        <?php
                         $water_level=false;
                         if($water_level){
                             $water_img = "assets/images/water_high.png";
                             $water_text = "<p style='font-size: xx-large;font-weight: 400;' class='text-info'>High</p>";
                         }else{
                             $water_img = "assets/images/water_low.png";
                             $water_text = "<p style='font-size: xx-large;font-weight: 400;' class='text-info'>Low</p>";
                         }
                        ?>
                        <div class="d-flex dark-box text-center" style="padding: 5px 15px;">
                            <img class="height-120" src="<?php echo $water_img; ?>">
                            <div class="justify-content-center d-block m-0 align-self-center">
                                <p id="bottom_heading" class="heading-font-2 m-0">Water Level</p>
                                <p id="number_text" class="xxx-larger m-0"><?php echo $water_text ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="ml-5 d-flex text-center align-self-center">
                        <div class="d-block">
                            <form action="" method="post">
                                <label class="text-primary font-size-larger mr-2">Light Switch:</label>
                                <input type="checkbox" checked data-toggle="toggle">
                            </form>
                            <form action="" method="post" class="mt-3">
                                <label class="text-primary font-size-larger mr-2">Valve Switch:</label>
                                <input type="checkbox"  data-toggle="toggle">
                            </form>
                        </div>
                    </div>
                </div>
            </div>


    <!-- GRAPHS -->

    <div class="spacer1"></div>
    <div class="col-12 w-100 myGraph position_inherit">
        <div id="tempreture_humidity_graph"></div>
    </div>

    
    <div class="spacer1"></div>

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
    <!-- End of DataTables -->
    </body>

</html>

<?php
if(isset($_GET["del_userid"])){
    $user_id = secure_parameter($_GET["del_userid"]);
    require 'modules/classes/class.logger.php';
    $device_add_log = new logger();
    $device_add_log->device_removed(get_device_name_4rm_id($con, $user_id), 5);

    require 'modules/classes/class.updateConfigs.php';
    $del_user_id = new updateConfigs();
    $del_user_id->del_row('user_and_devices', $user_id);

}

function get_name($con, $id){
    $sql = "SELECT * FROM users WHERE id=$id";
    $res = mysqli_query($con, $sql);
    $a = mysqli_fetch_assoc($res);
    return $a["username"];
}
function get_email($con, $id){
    $sql = "SELECT * FROM users WHERE id=$id";
    $res = mysqli_query($con, $sql);
    $a = mysqli_fetch_assoc($res);
    return $a["email"];
}
function get_device_name_4rm_id($con, $id){
    $sql = "SELECT * FROM user_and_devices WHERE id=$id";
    $res = mysqli_query($con, $sql);
    $a = mysqli_fetch_assoc($res);
    return $a["device_name"];
}
if(isset($_POST["edit_user"])){
    $name = secure_parameter($_POST["name"]);
    $mac = secure_parameter($_POST["mac"]);
    $location = secure_parameter($_POST["location"]);
    $id = secure_parameter($_POST["id"]);
    require 'modules/classes/class.users.php';
    $add_device_obj = new Users();
    if($add_device_obj->updateDeviceDetails($id, $name, $mac, $location)){
        require 'modules/classes/class.logger.php';
        $user_add_log = new logger();
        $user_add_log->user_added($name, 6);
        js_alert("Device updated Successfully");
        js_redirect("admin_dashboard.php");
    }else{
        js_alert("Error Occrued while Updating Device!");
    }
}
?>


<script>

    <?php
    $chart_bg = "#27293d";
    $chart_clr = "white";
    ?>

    window.onload = function () {
        // Three Currents Charts
        var currents = new CanvasJS.Chart("tempreture_humidity_graph", {
            zoomEnabled: true,
            backgroundColor: "<?php echo $chart_bg; ?>",
            animationEnabled: true,
            title:{
                text: "Temperature/Humidity",
                fontColor: "<?php echo $chart_clr; ?>",
                fontFamily:'Helvetica Neue, Helvetica, Arial, sans-serif',
                fontWeight: "lighter",
                //      fontWeight: "Normal",
            },
            axisX: {
                valueFormatString: "DD MMM,YY",
            },
            axisY: {
                title: "abcdc",
                gridColor: "lightgreen",
                includeZero: false
            },
            legend:{
                cursor: "pointer",
                fontSize: 16,
                itemclick: toggleDataSeries
            },
            toolTip:{
                shared: true
            },
            axisY: {
                includeZero: false,
                lineThickness: 1,
                labelFontColor: "<?php echo $chart_clr; ?>",
                gridColor: "#ffffff1f"
            },
            axisX: {
                labelFontColor: "<?php echo $chart_clr; ?>",
                labelMaxWidth: 100,
                labelAngle: -90/90
            },
            data: [{
                name: "Temperature",
                type: "spline",
                yValueFormatString: "#0.## C",
                showInLegend: true,
                dataPoints: [
                    { label: '2020-01-14 (6:43 am)', y: 70
                    },
                    { label: '2020-01-14 (6:44 am)', y: 50
                    },
                    { label: '2020-01-14 (6:46 am)', y: 68
                    },
                    { label: '2020-01-14 (6:47 am)', y: 78
                    },
                    { label: '2020-01-14 (6:48 am)', y: 50
                    },
                    { label: '2020-01-14 (6:49 am)', y: 63
                    },
                    { label: '2020-01-14 (6:50 am)', y: 100
                    },
                    { label: '2020-01-14 (6:51 am)', y: 74
                    },
                    { label: '2020-01-14 (6:52 am)', y: 94
                    },
                    { label: '2020-01-14 (6:53 am)', y: 81
                    },
                    { label: '2020-01-14 (6:54 am)', y: 57
                    },
                    { label: '2020-01-14 (6:55 am)', y: 97
                    },
                    { label: '2020-01-14 (6:56 am)', y: 87
                    },
                    { label: '2020-01-14 (6:57 am)', y: 84
                    },
                    { label: '2020-01-14 (6:58 am)', y: 88
                    },
                    { label: '2020-01-14 (6:59 am)', y: 82
                    },
                    { label: '2020-01-14 (7:00 am)', y: 71
                    },
                    { label: '2020-01-14 (7:01 am)', y: 59
                    },
                    { label: '2020-01-14 (7:02 am)', y: 100
                    },
                    { label: '2020-01-14 (7:03 am)', y: 97
                    },
                    { label: '2020-01-14 (7:04 am)', y: 50
                    },
                    { label: '2020-01-14 (7:05 am)', y: 69
                    },
                    { label: '2020-01-14 (7:06 am)', y: 95
                    },
                    { label: '2020-01-14 (7:07 am)', y: 50
                    },
                    { label: '2020-01-14 (7:08 am)', y: 86
                    },
                    { label: '2020-01-14 (7:09 am)', y: 59
                    },
                    { label: '2020-01-14 (7:10 am)', y: 85
                    },
                    { label: '2020-01-14 (7:11 am)', y: 92
                    },
                    { label: '2020-01-14 (7:12 am)', y: 89
                    },
                    { label: '2020-01-14 (7:13 am)', y: 69
                    },
                    { label: '2020-01-14 (7:14 am)', y: 98
                    },
                    { label: '2020-01-14 (7:15 am)', y: 80
                    },
                    { label: '2020-01-14 (7:16 am)', y: 90
                    },
                    { label: '2020-01-14 (7:17 am)', y: 65
                    },
                    { label: '2020-01-14 (7:18 am)', y: 76
                    },
                    { label: '2020-01-14 (7:19 am)', y: 60
                    },
                    { label: '2020-01-14 (7:20 am)', y: 75
                    },
                    { label: '2020-01-14 (7:21 am)', y: 83
                    },
                    { label: '2020-01-14 (7:22 am)', y: 99
                    },
                    { label: '2020-01-14 (7:23 am)', y: 59
                    },
                    { label: '2020-01-14 (7:24 am)', y: 55
                    },
                    { label: '2020-01-14 (7:25 am)', y: 54
                    },
                    { label: '2020-01-14 (7:26 am)', y: 69
                    },
                    { label: '2020-01-14 (7:27 am)', y: 62
                    },
                    { label: '2020-01-14 (7:28 am)', y: 91
                    },
                    { label: '2020-01-14 (7:29 am)', y: 61
                    },
                    { label: '2020-01-14 (7:30 am)', y: 70
                    },
                    { label: '2020-01-14 (7:31 am)', y: 100
                    },
                    { label: '2020-01-14 (7:32 am)', y: 100
                    },
                    { label: '2020-01-14 (7:33 am)', y: 76
                    },
                    { label: '2020-01-14 (7:34 am)', y: 100
                    },
                    { label: '2020-01-14 (7:36 am)', y: 53
                    },
                    { label: '2020-01-14 (7:37 am)', y: 94
                    },
                    { label: '2020-01-14 (7:38 am)', y: 69
                    },
                    { label: '2020-01-14 (7:39 am)', y: 99
                    },
                    { label: '2020-01-14 (7:40 am)', y: 56
                    },
                    { label: '2020-01-14 (7:41 am)', y: 97
                    },
                    { label: '2020-01-14 (7:42 am)', y: 79
                    },
                    { label: '2020-01-14 (7:43 am)', y: 90
                    },
                    { label: '2020-01-14 (7:44 am)', y: 52
                    },
                    { label: '2020-01-14 (7:45 am)', y: 62
                    },
                    { label: '2020-01-14 (7:46 am)', y: 66
                    },
                    { label: '2020-01-14 (7:47 am)', y: 63
                    },
                    { label: '2020-01-14 (7:48 am)', y: 74
                    },
                    { label: '2020-01-14 (7:49 am)', y: 87
                    },
                    { label: '2020-01-14 (7:50 am)', y: 62
                    },
                    { label: '2020-01-14 (7:51 am)', y: 81
                    },
                    { label: '2020-01-14 (7:52 am)', y: 79
                    },
                    { label: '2020-01-14 (7:53 am)', y: 100
                    },
                    { label: '2020-01-14 (7:54 am)', y: 56
                    },
                    { label: '2020-01-14 (7:55 am)', y: 51
                    },
                    { label: '2020-01-14 (7:56 am)', y: 93
                    },
                    { label: '2020-01-14 (7:57 am)', y: 88
                    },
                    { label: '2020-01-14 (7:58 am)', y: 59
                    },
                    { label: '2020-01-14 (7:59 am)', y: 66
                    },
                    { label: '2020-01-14 (8:00 am)', y: 95
                    },
                    { label: '2020-01-14 (8:01 am)', y: 53
                    },
                    { label: '2020-01-14 (8:02 am)', y: 60
                    },
                    { label: '2020-01-14 (8:03 am)', y: 58
                    },
                    { label: '2020-01-14 (8:04 am)', y: 74
                    },
                    { label: '2020-01-14 (8:05 am)', y: 75
                    },
                    { label: '2020-01-14 (8:06 am)', y: 75
                    },
                    { label: '2020-01-14 (8:07 am)', y: 76
                    },
                    { label: '2020-01-14 (8:08 am)', y: 66
                    },
                    { label: '2020-01-14 (8:09 am)', y: 55
                    },
                    { label: '2020-01-14 (8:10 am)', y: 63
                    },
                    { label: '2020-01-14 (8:11 am)', y: 72
                    },
                    { label: '2020-01-14 (8:12 am)', y: 65
                    },
                    { label: '2020-01-14 (8:13 am)', y: 74
                    },
                    { label: '2020-01-14 (8:14 am)', y: 58
                    },
                    { label: '2020-01-14 (8:15 am)', y: 61
                    },
                    { label: '2020-01-14 (8:16 am)', y: 81
                    },
                    { label: '2020-01-14 (8:17 am)', y: 57
                    },
                    { label: '2020-01-14 (8:18 am)', y: 87
                    },
                    { label: '2020-01-14 (8:19 am)', y: 73
                    },
                    { label: '2020-01-14 (8:20 am)', y: 91
                    },
                    { label: '2020-01-14 (8:21 am)', y: 70
                    },
                    { label: '2020-01-14 (8:22 am)', y: 90
                    },
                    { label: '2020-01-14 (8:24 am)', y: 74
                    },
                    { label: '2020-01-14 (8:25 am)', y: 52
                    },
                    { label: '2020-01-14 (8:26 am)', y: 75
                    },
                    { label: '2020-01-14 (8:27 am)', y: 79
                    },
                    { label: '2020-01-14 (8:28 am)', y: 50
                    },
                    { label: '2020-01-14 (8:29 am)', y: 57
                    },
                    { label: '2020-01-14 (8:30 am)', y: 66
                    },
                    { label: '2020-01-14 (8:31 am)', y: 53
                    },
                    { label: '2020-01-14 (8:32 am)', y: 58
                    },
                    { label: '2020-01-14 (8:33 am)', y: 60
                    },
                    { label: '2020-01-14 (8:34 am)', y: 52
                    },
                    { label: '2020-01-14 (8:35 am)', y: 67
                    },
                    { label: '2020-01-14 (8:36 am)', y: 51
                    },
                    { label: '2020-01-14 (8:37 am)', y: 66
                    },
                    { label: '2020-01-14 (8:41 am)', y: 50
                    },
                    { label: '2020-01-14 (8:42 am)', y: 79
                    },
                    { label: '2020-01-14 (8:43 am)', y: 54
                    },
                    { label: '2020-01-14 (8:49 am)', y: 94
                    },
                    { label: '2020-01-14 (8:50 am)', y: 54
                    },
                    { label: '2020-01-14 (8:51 am)', y: 60
                    },
                    { label: '2020-01-14 (8:52 am)', y: 78
                    },
                    { label: '2020-01-14 (8:53 am)', y: 64
                    },
                    { label: '2020-01-14 (8:54 am)', y: 64
                    },
                    { label: '2020-01-14 (8:57 am)', y: 65
                    },
                    { label: '2020-01-14 (8:58 am)', y: 55
                    },
                    { label: '2020-01-14 (8:59 am)', y: 97
                    },
                    { label: '2020-01-14 (9:00 am)', y: 54
                    },
                    { label: '2020-01-14 (9:01 am)', y: 84
                    },
                    { label: '2020-01-14 (9:02 am)', y: 100
                    },
                    { label: '2020-01-14 (9:03 am)', y: 79
                    },
                    { label: '2020-01-14 (9:04 am)', y: 78
                    },
                    { label: '2020-01-14 (9:05 am)', y: 76
                    },
                    { label: '2020-01-14 (9:06 am)', y: 97
                    },
                    { label: '2020-01-14 (9:07 am)', y: 95
                    },
                    { label: '2020-01-14 (9:08 am)', y: 66
                    },
                    { label: '2020-01-14 (9:09 am)', y: 56
                    },
                    { label: '2020-01-14 (10:34 am)', y: 53
                    },
                    { label: '2020-01-14 (10:35 am)', y: 57
                    },
                    { label: '2020-01-14 (10:36 am)', y: 73
                    },
                    { label: '2020-01-14 (10:38 am)', y: 83
                    },
                    { label: '2020-01-14 (10:39 am)', y: 75
                    },
                    { label: '2020-01-14 (10:41 am)', y: 53
                    },
                    { label: '2020-01-14 (10:42 am)', y: 57
                    },
                    { label: '2020-01-14 (10:43 am)', y: 73
                    },
                    { label: '2020-01-14 (10:44 am)', y: 99
                    },
                    { label: '2020-01-14 (10:45 am)', y: 83
                    },
                    { label: '2020-01-14 (10:46 am)', y: 75
                    },
                    { label: '2020-01-14 (10:47 am)', y: 61
                    },
                    { label: '2020-01-14 (10:48 am)', y: 89
                    },
                    { label: '2020-01-14 (10:49 am)', y: 58
                    },
                    { label: '2020-01-14 (10:50 am)', y: 57
                    },
                    { label: '2020-01-14 (10:51 am)', y: 72
                    },
                    { label: '2020-01-14 (10:52 am)', y: 87
                    },
                    { label: '2020-01-14 (10:53 am)', y: 91
                    },
                    { label: '2020-01-14 (10:54 am)', y: 68
                    },
                    { label: '2020-01-14 (10:57 am)', y: 87
                    },
                    { label: '2020-01-14 (10:58 am)', y: 80
                    },
                    { label: '2020-01-14 (11:00 am)', y: 78
                    },
                    { label: '2020-01-14 (11:01 am)', y: 56
                    },
                    { label: '2020-01-14 (11:02 am)', y: 70
                    },
                    { label: '2020-01-14 (11:03 am)', y: 64
                    },
                    { label: '2020-01-14 (11:05 am)', y: 59
                    },
                    { label: '2020-01-14 (11:06 am)', y: 69
                    },
                    { label: '2020-01-14 (11:07 am)', y: 93
                    },
                    { label: '2020-01-14 (11:08 am)', y: 54
                    },
                    { label: '2020-01-14 (11:10 am)', y: 51
                    },
                    { label: '2020-01-14 (11:12 am)', y: 73
                    },
                    { label: '2020-01-14 (11:13 am)', y: 69
                    },
                    { label: '2020-01-14 (11:14 am)', y: 62
                    },
                    { label: '2020-01-14 (11:15 am)', y: 93
                    },
                    { label: '2020-01-14 (11:16 am)', y: 55
                    },
                    { label: '2020-01-14 (11:17 am)', y: 92
                    },
                    { label: '2020-01-14 (11:18 am)', y: 91
                    },
                    { label: '2020-01-14 (11:21 am)', y: 57
                    },
                    { label: '2020-01-14 (11:22 am)', y: 73
                    },
                    { label: '2020-01-14 (11:23 am)', y: 99
                    },
                    { label: '2020-01-14 (11:24 am)', y: 83
                    },
                    { label: '2020-01-14 (11:25 am)', y: 75
                    },
                    { label: '2020-01-14 (11:26 am)', y: 61
                    },
                    { label: '2020-01-14 (11:27 am)', y: 89
                    },
                    { label: '2020-01-14 (11:28 am)', y: 58
                    },
                    { label: '2020-01-14 (11:30 am)', y: 57
                    },
                    { label: '2020-01-14 (11:31 am)', y: 72
                    },
                    { label: '2020-01-14 (11:32 am)', y: 87
                    },
                    { label: '2020-01-14 (11:33 am)', y: 91
                    },
                    { label: '2020-01-14 (11:34 am)', y: 68
                    },
                    { label: '2020-01-14 (11:35 am)', y: 75
                    },
                    { label: '2020-01-14 (11:36 am)', y: 87
                    },
                    { label: '2020-01-14 (11:37 am)', y: 80
                    },
                    { label: '2020-01-14 (11:38 am)', y: 87
                    },
                    { label: '2020-01-14 (11:40 am)', y: 56
                    },
                    { label: '2020-01-14 (11:43 am)', y: 64
                    },
                    { label: '2020-01-14 (11:46 am)', y: 69
                    },
                    { label: '2020-01-14 (11:47 am)', y: 93
                    },
                    { label: '2020-01-14 (11:48 am)', y: 54
                    },
                    { label: '2020-01-14 (11:50 am)', y: 51
                    },
                    { label: '2020-01-14 (11:51 am)', y: 78
                    },
                    { label: '2020-01-14 (11:52 am)', y: 73
                    },
                    { label: '2020-01-14 (11:53 am)', y: 69
                    },
                    { label: '2020-01-14 (11:54 am)', y: 62
                    },
                    { label: '2020-01-14 (11:55 am)', y: 93
                    },
                    { label: '2020-01-14 (11:56 am)', y: 55
                    }
                ]
            },
                {
                    name: "Humidity",
                    type: "spline",
                    // yValueFormatString: "#0.## %",
                    showInLegend: true,
                    dataPoints: [
                        { label: '2020-01-14 (6:43 am)', y: 56
                        },
                        { label: '2020-01-14 (6:44 am)', y: 88
                        },
                        { label: '2020-01-14 (6:46 am)', y: 69
                        },
                        { label: '2020-01-14 (6:47 am)', y: 63
                        },
                        { label: '2020-01-14 (6:48 am)', y: 72
                        },
                        { label: '2020-01-14 (6:49 am)', y: 87
                        },
                        { label: '2020-01-14 (6:50 am)', y: 93
                        },
                        { label: '2020-01-14 (6:51 am)', y: 100
                        },
                        { label: '2020-01-14 (6:52 am)', y: 76
                        },
                        { label: '2020-01-14 (6:53 am)', y: 63
                        },
                        { label: '2020-01-14 (6:54 am)', y: 66
                        },
                        { label: '2020-01-14 (6:55 am)', y: 51
                        },
                        { label: '2020-01-14 (6:56 am)', y: 71
                        },
                        { label: '2020-01-14 (6:57 am)', y: 93
                        },
                        { label: '2020-01-14 (6:58 am)', y: 98
                        },
                        { label: '2020-01-14 (6:59 am)', y: 71
                        },
                        { label: '2020-01-14 (7:00 am)', y: 61
                        },
                        { label: '2020-01-14 (7:01 am)', y: 79
                        },
                        { label: '2020-01-14 (7:02 am)', y: 78
                        },
                        { label: '2020-01-14 (7:03 am)', y: 96
                        },
                        { label: '2020-01-14 (7:04 am)', y: 100
                        },
                        { label: '2020-01-14 (7:05 am)', y: 72
                        },
                        { label: '2020-01-14 (7:06 am)', y: 59
                        },
                        { label: '2020-01-14 (7:07 am)', y: 77
                        },
                        { label: '2020-01-14 (7:08 am)', y: 99
                        },
                        { label: '2020-01-14 (7:09 am)', y: 57
                        },
                        { label: '2020-01-14 (7:10 am)', y: 82
                        },
                        { label: '2020-01-14 (7:11 am)', y: 59
                        },
                        { label: '2020-01-14 (7:12 am)', y: 68
                        },
                        { label: '2020-01-14 (7:13 am)', y: 71
                        },
                        { label: '2020-01-14 (7:14 am)', y: 78
                        },
                        { label: '2020-01-14 (7:15 am)', y: 82
                        },
                        { label: '2020-01-14 (7:16 am)', y: 66
                        },
                        { label: '2020-01-14 (7:17 am)', y: 84
                        },
                        { label: '2020-01-14 (7:18 am)', y: 65
                        },
                        { label: '2020-01-14 (7:19 am)', y: 76
                        },
                        { label: '2020-01-14 (7:20 am)', y: 59
                        },
                        { label: '2020-01-14 (7:21 am)', y: 73
                        },
                        { label: '2020-01-14 (7:22 am)', y: 63
                        },
                        { label: '2020-01-14 (7:23 am)', y: 67
                        },
                        { label: '2020-01-14 (7:24 am)', y: 83
                        },
                        { label: '2020-01-14 (7:25 am)', y: 56
                        },
                        { label: '2020-01-14 (7:26 am)', y: 93
                        },
                        { label: '2020-01-14 (7:27 am)', y: 79
                        },
                        { label: '2020-01-14 (7:28 am)', y: 83
                        },
                        { label: '2020-01-14 (7:29 am)', y: 89
                        },
                        { label: '2020-01-14 (7:30 am)', y: 70
                        },
                        { label: '2020-01-14 (7:31 am)', y: 79
                        },
                        { label: '2020-01-14 (7:32 am)', y: 50
                        },
                        { label: '2020-01-14 (7:33 am)', y: 61
                        },
                        { label: '2020-01-14 (7:34 am)', y: 68
                        },
                        { label: '2020-01-14 (7:36 am)', y: 79
                        },
                        { label: '2020-01-14 (7:37 am)', y: 84
                        },
                        { label: '2020-01-14 (7:38 am)', y: 92
                        },
                        { label: '2020-01-14 (7:39 am)', y: 93
                        },
                        { label: '2020-01-14 (7:40 am)', y: 79
                        },
                        { label: '2020-01-14 (7:41 am)', y: 62
                        },
                        { label: '2020-01-14 (7:42 am)', y: 62
                        },
                        { label: '2020-01-14 (7:43 am)', y: 87
                        },
                        { label: '2020-01-14 (7:44 am)', y: 87
                        },
                        { label: '2020-01-14 (7:45 am)', y: 54
                        },
                        { label: '2020-01-14 (7:46 am)', y: 69
                        },
                        { label: '2020-01-14 (7:47 am)', y: 92
                        },
                        { label: '2020-01-14 (7:48 am)', y: 62
                        },
                        { label: '2020-01-14 (7:49 am)', y: 65
                        },
                        { label: '2020-01-14 (7:50 am)', y: 100
                        },
                        { label: '2020-01-14 (7:51 am)', y: 84
                        },
                        { label: '2020-01-14 (7:52 am)', y: 75
                        },
                        { label: '2020-01-14 (7:53 am)', y: 91
                        },
                        { label: '2020-01-14 (7:54 am)', y: 73
                        },
                        { label: '2020-01-14 (7:55 am)', y: 94
                        },
                        { label: '2020-01-14 (7:56 am)', y: 94
                        },
                        { label: '2020-01-14 (7:57 am)', y: 74
                        },
                        { label: '2020-01-14 (7:58 am)', y: 56
                        },
                        { label: '2020-01-14 (7:59 am)', y: 58
                        },
                        { label: '2020-01-14 (8:00 am)', y: 87
                        },
                        { label: '2020-01-14 (8:01 am)', y: 52
                        },
                        { label: '2020-01-14 (8:02 am)', y: 80
                        },
                        { label: '2020-01-14 (8:03 am)', y: 82
                        },
                        { label: '2020-01-14 (8:04 am)', y: 62
                        },
                        { label: '2020-01-14 (8:05 am)', y: 90
                        },
                        { label: '2020-01-14 (8:06 am)', y: 50
                        },
                        { label: '2020-01-14 (8:07 am)', y: 81
                        },
                        { label: '2020-01-14 (8:08 am)', y: 70
                        },
                        { label: '2020-01-14 (8:09 am)', y: 59
                        },
                        { label: '2020-01-14 (8:10 am)', y: 97
                        },
                        { label: '2020-01-14 (8:11 am)', y: 54
                        },
                        { label: '2020-01-14 (8:12 am)', y: 73
                        },
                        { label: '2020-01-14 (8:13 am)', y: 69
                        },
                        { label: '2020-01-14 (8:14 am)', y: 95
                        },
                        { label: '2020-01-14 (8:15 am)', y: 60
                        },
                        { label: '2020-01-14 (8:16 am)', y: 54
                        },
                        { label: '2020-01-14 (8:17 am)', y: 81
                        },
                        { label: '2020-01-14 (8:18 am)', y: 89
                        },
                        { label: '2020-01-14 (8:19 am)', y: 59
                        },
                        { label: '2020-01-14 (8:20 am)', y: 63
                        },
                        { label: '2020-01-14 (8:21 am)', y: 54
                        },
                        { label: '2020-01-14 (8:22 am)', y: 92
                        },
                        { label: '2020-01-14 (8:24 am)', y: 67
                        },
                        { label: '2020-01-14 (8:25 am)', y: 75
                        },
                        { label: '2020-01-14 (8:26 am)', y: 88
                        },
                        { label: '2020-01-14 (8:27 am)', y: 95
                        },
                        { label: '2020-01-14 (8:28 am)', y: 61
                        },
                        { label: '2020-01-14 (8:29 am)', y: 70
                        },
                        { label: '2020-01-14 (8:30 am)', y: 65
                        },
                        { label: '2020-01-14 (8:31 am)', y: 66
                        },
                        { label: '2020-01-14 (8:32 am)', y: 69
                        },
                        { label: '2020-01-14 (8:33 am)', y: 82
                        },
                        { label: '2020-01-14 (8:34 am)', y: 68
                        },
                        { label: '2020-01-14 (8:35 am)', y: 83
                        },
                        { label: '2020-01-14 (8:36 am)', y: 74
                        },
                        { label: '2020-01-14 (8:37 am)', y: 69
                        },
                        { label: '2020-01-14 (8:41 am)', y: 99
                        },
                        { label: '2020-01-14 (8:42 am)', y: 81
                        },
                        { label: '2020-01-14 (8:43 am)', y: 71
                        },
                        { label: '2020-01-14 (8:49 am)', y: 97
                        },
                        { label: '2020-01-14 (8:50 am)', y: 57
                        },
                        { label: '2020-01-14 (8:51 am)', y: 96
                        },
                        { label: '2020-01-14 (8:52 am)', y: 85
                        },
                        { label: '2020-01-14 (8:53 am)', y: 60
                        },
                        { label: '2020-01-14 (8:54 am)', y: 85
                        },
                        { label: '2020-01-14 (8:57 am)', y: 70
                        },
                        { label: '2020-01-14 (8:58 am)', y: 53
                        },
                        { label: '2020-01-14 (8:59 am)', y: 54
                        },
                        { label: '2020-01-14 (9:00 am)', y: 65
                        },
                        { label: '2020-01-14 (9:01 am)', y: 61
                        },
                        { label: '2020-01-14 (9:02 am)', y: 63
                        },
                        { label: '2020-01-14 (9:03 am)', y: 79
                        },
                        { label: '2020-01-14 (9:04 am)', y: 58
                        },
                        { label: '2020-01-14 (9:05 am)', y: 96
                        },
                        { label: '2020-01-14 (9:06 am)', y: 94
                        },
                        { label: '2020-01-14 (9:07 am)', y: 79
                        },
                        { label: '2020-01-14 (9:08 am)', y: 84
                        },
                        { label: '2020-01-14 (9:09 am)', y: 98
                        },
                        { label: '2020-01-14 (10:34 am)', y: 57
                        },
                        { label: '2020-01-14 (10:35 am)', y: 82
                        },
                        { label: '2020-01-14 (10:36 am)', y: 97
                        },
                        { label: '2020-01-14 (10:38 am)', y: 83
                        },
                        { label: '2020-01-14 (10:39 am)', y: 90
                        },
                        { label: '2020-01-14 (10:41 am)', y: 57
                        },
                        { label: '2020-01-14 (10:42 am)', y: 82
                        },
                        { label: '2020-01-14 (10:43 am)', y: 97
                        },
                        { label: '2020-01-14 (10:44 am)', y: 75
                        },
                        { label: '2020-01-14 (10:45 am)', y: 83
                        },
                        { label: '2020-01-14 (10:46 am)', y: 90
                        },
                        { label: '2020-01-14 (10:47 am)', y: 100
                        },
                        { label: '2020-01-14 (10:48 am)', y: 57
                        },
                        { label: '2020-01-14 (10:49 am)', y: 63
                        },
                        { label: '2020-01-14 (10:50 am)', y: 86
                        },
                        { label: '2020-01-14 (10:51 am)', y: 77
                        },
                        { label: '2020-01-14 (10:52 am)', y: 93
                        },
                        { label: '2020-01-14 (10:53 am)', y: 89
                        },
                        { label: '2020-01-14 (10:54 am)', y: 93
                        },
                        { label: '2020-01-14 (10:57 am)', y: 95
                        },
                        { label: '2020-01-14 (10:58 am)', y: 59
                        },
                        { label: '2020-01-14 (11:00 am)', y: 92
                        },
                        { label: '2020-01-14 (11:01 am)', y: 83
                        },
                        { label: '2020-01-14 (11:02 am)', y: 63
                        },
                        { label: '2020-01-14 (11:03 am)', y: 98
                        },
                        { label: '2020-01-14 (11:05 am)', y: 74
                        },
                        { label: '2020-01-14 (11:06 am)', y: 100
                        },
                        { label: '2020-01-14 (11:07 am)', y: 74
                        },
                        { label: '2020-01-14 (11:08 am)', y: 63
                        },
                        { label: '2020-01-14 (11:10 am)', y: 62
                        },
                        { label: '2020-01-14 (11:12 am)', y: 73
                        },
                        { label: '2020-01-14 (11:13 am)', y: 96
                        },
                        { label: '2020-01-14 (11:14 am)', y: 70
                        },
                        { label: '2020-01-14 (11:15 am)', y: 55
                        },
                        { label: '2020-01-14 (11:16 am)', y: 66
                        },
                        { label: '2020-01-14 (11:17 am)', y: 73
                        },
                        { label: '2020-01-14 (11:18 am)', y: 79
                        },
                        { label: '2020-01-14 (11:21 am)', y: 82
                        },
                        { label: '2020-01-14 (11:22 am)', y: 97
                        },
                        { label: '2020-01-14 (11:23 am)', y: 75
                        },
                        { label: '2020-01-14 (11:24 am)', y: 83
                        },
                        { label: '2020-01-14 (11:25 am)', y: 90
                        },
                        { label: '2020-01-14 (11:26 am)', y: 100
                        },
                        { label: '2020-01-14 (11:27 am)', y: 57
                        },
                        { label: '2020-01-14 (11:28 am)', y: 63
                        },
                        { label: '2020-01-14 (11:30 am)', y: 86
                        },
                        { label: '2020-01-14 (11:31 am)', y: 77
                        },
                        { label: '2020-01-14 (11:32 am)', y: 93
                        },
                        { label: '2020-01-14 (11:33 am)', y: 89
                        },
                        { label: '2020-01-14 (11:34 am)', y: 93
                        },
                        { label: '2020-01-14 (11:35 am)', y: 67
                        },
                        { label: '2020-01-14 (11:36 am)', y: 95
                        },
                        { label: '2020-01-14 (11:37 am)', y: 59
                        },
                        { label: '2020-01-14 (11:38 am)', y: 80
                        },
                        { label: '2020-01-14 (11:40 am)', y: 83
                        },
                        { label: '2020-01-14 (11:43 am)', y: 98
                        },
                        { label: '2020-01-14 (11:46 am)', y: 100
                        },
                        { label: '2020-01-14 (11:47 am)', y: 74
                        },
                        { label: '2020-01-14 (11:48 am)', y: 63
                        },
                        { label: '2020-01-14 (11:50 am)', y: 62
                        },
                        { label: '2020-01-14 (11:51 am)', y: 50
                        },
                        { label: '2020-01-14 (11:52 am)', y: 73
                        },
                        { label: '2020-01-14 (11:53 am)', y: 96
                        },
                        { label: '2020-01-14 (11:54 am)', y: 70
                        },
                        { label: '2020-01-14 (11:55 am)', y: 55
                        },
                        { label: '2020-01-14 (11:56 am)', y: 66
                        }
                    ]
                }
            ]
        });

        currents.render();


        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            currents.render();
            voltages.render();
            temperature.render();
            power.render();
        }
    }
</script>
