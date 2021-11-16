<?php


date_default_timezone_set("Asia/Karachi");
$a = date("h:i:sa");
//echo date("d-M,Y  g:i a", strtotime($a));
$date_now = date("Y-m-d", strtotime($a));



    require 'modules/app.php';
    $order_query = "ORDER BY id ASC LIMIT 200";
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
check_session();
    $page_identifier = "./";
    $title = "Dashbaord";
    if(isset($_GET["id"])) {
        $page_id = secure_parameter($_GET["id"]);
    }
?>
<!doctype html>
<html lang="en">
<head>
    <?php require 'modules/head.php'; ?>
</head>
    <?php
        require 'modules/classes/class.users.php';
        $configs = new Users();
        $device_data = $configs->getDeviceInfoById($page_id);
        $user_data = $config_data = $configs->getUserInfoById($device_data[0]["user_id"]);
        if($config_data){
            $mail_email = $device_data[0]["mailing_address"];
            $user_and_devices_id = $device_data[0]["id"];
            $cal_date = $cal_date_db = $device_data[0]["calibration_date"];
            $device_mac_address = $device_data[0]["mac"];
        }else{
            js_alert("No Such Device Found!");
            js_redirect("admin_dashboard.php");
            $mail_email = "";
            $cal_date = "";
        }
    $cal_date = date("d M,Y", strtotime($cal_date));
    ?>
    <body>
        <?php require 'modules/navbar.php'; ?>

        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="row line-height-30">
                        <div class="font-family-josefin font-size-large ">
                            <div>Name:</div>
                            <div>Location:</div>
                            <div>Device Name:</div>
                            <div>Mac Address:</div>
                            <div>Status:</div>
                            <div>Local IP:</div>
                            <div>Email:</div>
                            <div>Cal. Date:</div>
                        </div>
                        <div class="ml-1 text-muted font-weight-bold">
                            <div><?php echo $user_data[0]["username"] ?></div>
                            <div><?php echo $device_data[0]["location"] ?></div>
                            <div><?php echo $device_data[0]["device_name"] ?></div>
                            <div><?php echo $device_data[0]["mac"] ?></div>
                            <div class="text-success">ON</div>
                            <div>192.168.0.1</div>
                            <div><?php echo $mail_email ?><span><button type="button" class="custom-btn-1 ml-1" data-toggle="modal" data-target="#edit_email">(Edit)</button></span></div>
                            <div><?php echo $cal_date ?><span><button type="button" class="custom-btn-1 ml-1" data-toggle="modal" data-target="#edit_cal_date">(Edit)</button></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <?php
                    require 'modules/db.php';
                    $a = "SELECT * FROM api_data WHERE machine_mac = '".$device_mac_address."' ORDER BY id DESC";
                    $b = mysqli_query($con, $a);
                    $c = mysqli_fetch_assoc($b);
                    $cmp = $c["Cmpressor"];
                    $detect = $c["Detect"];
                    $alarm = $c["Alarm"];
                    if($cmp=="Hi"){
                        $img_link = "<p class='text-danger' style='font-size: xx-large'>ON</p>";
                    }
                    if($cmp=="Lo"){
                        $img_link = "<p class='text-success' style='font-size: xx-large'>OFF</p>";
                    }
                    if($alarm=="Hi"){
                        $alarm_value = "";
                        $alarm_txt = "ON";
                        $alarm_text_clr = "danger";
                    }
                    if($alarm=="Lo"){
                        $alarm_value = "-slash";
                        $alarm_txt = "OFF";
                        $alarm_text_clr = "success";
                    }
                    if($detect=="Hi"){
                        $detect_value = "";
                        $detect_txt = "ON";
                        $detect_text_clr = "danger";
                    }
                    if($detect=="Lo"){
                        $detect_value = "-slash";
                        $detect_txt = "OFF";
                        $detect_text_clr = "success";
                    }
                    ?>
                    <div class="row">
                        <div class="col-4">
                            <h3 class="color-white text-center">Alarm</h3>
                            <div class="text-center">
                                <i class="fa fa-bell<?php echo $alarm_value; ?> text-muted font-size-150px" aria-hidden="true"></i>
                                <p class="font-weight-bold mt-2">Alarm Status: <span class="text-<?php echo $alarm_text_clr; ?>"><?php echo $alarm_txt; ?></span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <h3 class="color-white text-center">Detection</h3>
                            <div class="text-center">
                                <i class="fas fa-user<?php echo $detect_value; ?> text-muted font-size-150px" aria-hidden="true"></i>
                                <p class="font-weight-bold mt-2">Human Detection: <span class="text-<?php echo $detect_text_clr; ?>"><?php echo $detect_txt; ?></span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <h3 class="color-white text-center">Relay Control</h3>
                            <div class="text-center mt-5">
                                <input type="checkbox" checked data-toggle="toggle" data-size="large">
                            </div>
                            <div class="d-flex mt-5 ml-3">
                                <h3 class="color-white text-center">Compressor Status: </h3>
                                <p class="ml-4"><div class="height-40px mt-3"><?php echo $img_link; ?></div></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="container-fluid mt-5 w-100">
        <div class="row">

            <div class="col-12">
                <div class="w-100 mx-auto">
                    <div class="container offset-4">
                        <form class="d-flex filter_form" action="chart_filter.php" method="post">
                            <input type="date" name="range1" required>
                            <input type="date" name="range2" required>
                            <input type="hidden" name="mac" value="<?php echo $device_mac_address; ?>">
                            <input type="hidden" name="page_link" value="<?php echo $actual_link; ?>">
                            <select name="col_name" class="mx-2 form-control" style="width: fit-content;height: auto;padding: initial;" required>
                                <option value="">-- Select Current --</option>
                                <option value="Curr1"> Current 1 </option>
                                <option value="Curr2"> Current 2 </option>
                                <option value="Curr3"> Current 3 </option>
                            </select>
                            <input type="submit" name="<?php echo $sub; ?>" value="Search" class="btn custom-btn-2">
                        </form>
                    </div>
                    <div id="three_current_phases"></div>
                </div>
            </div>


            <div class="spacer1"></div>


            <div class="col-12 mb-4">
                <div class="w-100 mx-auto">
                    <div class="container offset-4">
                        <form class="d-flex filter_form" action="chart_filter.php" method="post">
                            <input type="date" name="range1" required>
                            <input type="date" name="range2" required>
                            <input type="hidden" name="mac" value="<?php echo $device_mac_address; ?>">
                            <input type="hidden" name="page_link" value="<?php echo $actual_link; ?>">
                            <select name="col_name" class="mx-2 form-control" style="width: fit-content;height: auto;padding: initial;" required>
                                <option value="">-- Select Voltage --</option>
                                <option value="Vlt1"> Voltage 1 </option>
                                <option value="Vlt2"> Voltage 2 </option>
                                <option value="Vlt3"> Voltage 3 </option>
                            </select>
                            <input type="submit" name="<?php echo $sub; ?>" value="Search" class="btn custom-btn-2">
                        </form>
                    </div>
                    <div id="three_voltages_phases"></div>
                </div>
            </div>


            <div class="spacer1"></div>


            <div class="col-12 mb-4">
                <div class="w-100 mx-auto">
                    <div class="container offset-4">
                        <form class="d-flex filter_form" action="chart_filter.php" method="post">
                            <input type="date" name="range1" required>
                            <input type="date" name="range2" required>
                            <input type="hidden" name="mac" value="<?php echo $device_mac_address; ?>">
                            <input type="hidden" name="page_link" value="<?php echo $actual_link; ?>">
                            <select name="col_name" class="mx-2 form-control" style="width: fit-content;height: auto;padding: initial;" required>
                                <option value="">-- Select Temperature --</option>
                                <option value="Tmp1"> Temperature 1 </option>
                                <option value="Tmp2"> Temperature 2 </option>
                                <option value="Tmp3"> Temperature 3 </option>
                            </select>
                            <input type="submit" name="<?php echo $sub; ?>" value="Search" class="btn custom-btn-2">
                        </form>
                    </div>
                    <div id="three_temperature_phases"></div>
                </div>
            </div>


            <div class="spacer1"></div>


            <div class="col-12 mb-4">
                <div class="w-100 mx-auto">
                    <div class="container offset-4">
                        <form class="d-flex filter_form" action="chart_filter.php" method="post">
                            <input type="date" name="range1" required>
                            <input type="date" name="range2" required>
                            <input type="hidden" name="mac" value="<?php echo $device_mac_address; ?>">
                            <input type="hidden" name="page_link" value="<?php echo $actual_link; ?>">
                            <select name="col_name" class="mx-2 form-control" style="width: fit-content;height: auto;padding: initial;" required>
                                <option value="">-- Select Power --</option>
                                <option value="pow1"> Power 1 </option>
                                <option value="pow2"> Power 2 </option>
                                <option value="pow3"> Power 3 </option>
                            </select>
                            <input type="submit" name="<?php echo $sub; ?>" value="Search" class="btn custom-btn-2">
                        </form>
                    </div>
                    <div id="three_power_phases"></div>
                </div>
            </div>


            <div class="spacer"></div>


        </div>
    </div>

    </div>

        <!--
        ******   Model Codes
        -->
        <!-- Edit Eamil Modal -->
        <div class="modal" id="edit_email">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <!-- Modal Header -->
                        <div class="modal-header bg-modal-header border-bottom-red">
                            <h4 class="modal-title">Update Mailing Address</h4>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body bg-modal-body text-white">
                            <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-at"></i>
                            </span>
                                <input type="hidden" name="user_devices_id" value="<?php echo $user_and_devices_id; ?>">
                                <input value="<?php echo $mail_email; ?>" type="email" name="new_email" class="form-control " placeholder="Email Address" required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer bg-modal-header text-white border-top-red">
                            <button class="w-50 btn btn-success" type="submit" name="submit-email">Save</button>
                            <button type="button" class="w-50 btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if(isset($_POST["submit-email"])){
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $email = secure_parameter($_POST["new_email"]);
            $id = secure_parameter($_POST["user_devices_id"]);
            if($configs->updateEmailAddress($id, $email)){
                js_redirect($actual_link);
            }
            else{
                die("Error Occured in email!");
            }
        }
        ?>


        <!-- Edit Calibration Date Modal -->
        <div class="modal" id="edit_cal_date">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <!-- Modal Header -->
                        <div class="modal-header bg-modal-header border-bottom-red">
                            <h4 class="modal-title">Update Calibration Date</h4>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body bg-modal-body text-white">
                            <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="far fa-clock"></i>
                            </span>
                                <input type="hidden" name="user_devices_id" value="<?php echo $user_and_devices_id; ?>">
                                <input type="date" name="new_date" class="form-control " placeholder="Date" required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer bg-modal-header text-white border-top-red">
                            <button class="w-50 btn btn-success" type="submit" name="submit-date">Save</button>
                            <button type="button" class="w-50 btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if(isset($_POST["submit-date"])){
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $id = $_POST["user_devices_id"];
            $date = $_POST["new_date"];
            if($configs->updateDate($id, $date)){
                js_redirect($actual_link);
            }else{
                die("Error Occured in date!");
            }
        }
        ?>




        <?php require 'modules/footer.php'; ?>
    </body>

</html>




<script>
    window.onload = function () {
        // Three Currents Charts
        var currents = new CanvasJS.Chart("three_current_phases", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            title:{
                text: "Currents (Amp)",
                fontColor: "#d2d2c9",
                fontFamily:'Helvetica Neue, Helvetica, Arial, sans-serif',
                fontWeight: "lighter",
                //      fontWeight: "Normal",
            },
            axisX: {
                valueFormatString: "DD MMM,YY",
            },
            axisY: {
                title: "Current (in Amp)",
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
                labelFontColor: "#d2d2c9",
                gridColor: "#ffffff1f"
            },
            axisX: {
                labelFontColor: "#d2d2c9",
                labelAngle: -90/90
            },
            data: [{
                <?php
                $a="";
                if($cal_date_db > $date_now){
                    //echo " ,lineColor: 'red'";
                }
                ?>
                name: "Current 1",
                type: "spline",
                yValueFormatString: "#0.## Amp",
                showInLegend: true,
                dataPoints: [
                    <?php
                    require 'modules/db.php';
                    $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                    //                echo $sql;
                    $res = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($res)){
                        $time = get_time($row["date_now"]);
                        $date = get_date($row["date_now"]);
                        echo "
                        { label: '".$date." (".$time.")', y: ".$row['Curr1']." 
                        ";
                        if($cal_date_db < $date){
                            echo " ,lineColor: '#7face2', color: '#7face2'";
                        }
                        echo "},";
                    }
                    ?>
                ]
            },
                {
                    name: "Current 2",
                    type: "spline",
                    yValueFormatString: "#0.## Amp",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['Curr2']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#c7706f', color: '#c7706f'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                },
                {
                    name: "Current 3",
                    type: "spline",
                    yValueFormatString: "#0.## Amp",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        //                echo $sql;
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['Curr3']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#e0ffa0', color: '#e0ffa0'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                }]
        });



        // Three Voltages Charts
        var voltages = new CanvasJS.Chart("three_voltages_phases", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            title:{
                text: "Voltages (V)",
                fontColor: "#d2d2c9",
                fontFamily:'Helvetica Neue, Helvetica, Arial, sans-serif',
                fontWeight: "lighter",
                //      fontWeight: "Normal",
            },
            axisX: {
                valueFormatString: "DD MMM,YY",
            },
            axisY: {
                title: "Voltages (in V)",
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
                labelFontColor: "#d2d2c9",
                gridColor: "#ffffff1f"
            },
            axisX: {
                labelFontColor: "#d2d2c9",
                labelAngle: -90/90
            },
            data: [{
                <?php
                $a="";
                if($cal_date_db > $date_now){
                    //echo " ,lineColor: 'red'";
                }
                ?>
                name: "Voltage 1",
                type: "spline",
                showInLegend: true,
                yValueFormatString: "#0.## v",
                dataPoints: [
                    <?php
                    require 'modules/db.php';
                    $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                    //                echo $sql;
                    $res = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($res)){
                        $time = get_time($row["date_now"]);
                        $date = get_date($row["date_now"]);
                        echo "
                        { label: '".$date." (".$time.")', y: ".$row['Vlt1']." 
                        ";
                        if($cal_date_db < $date){
                            echo " ,lineColor: '#7face2', color: '#7face2'";
                        }
                        echo "},";
                    }
                    ?>
                ]
            },
                {
                    name: "Voltage 2",
                    type: "spline",
                    yValueFormatString: "#0.## v",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['Vlt2']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#c7706f', color: '#c7706f'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                },
                {
                    name: "Voltage 3",
                    type: "spline",
                    yValueFormatString: "#0.## v",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        //                echo $sql;
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['Vlt3']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#e0ffa0', color: '#e0ffa0'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                }]
        });


        // Three Temperature Charts
        var temperature = new CanvasJS.Chart("three_temperature_phases", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            title:{
                text: "Temperature (C)",
                fontColor: "#d2d2c9",
                fontFamily:'Helvetica Neue, Helvetica, Arial, sans-serif',
                fontWeight: "lighter",
                //      fontWeight: "Normal",
            },
            axisX: {
                valueFormatString: "DD MMM,YY",
            },
            axisY: {
                title: "Temperature (in C)",
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
                labelFontColor: "#d2d2c9",
                gridColor: "#ffffff1f"
            },
            axisX: {
                labelFontColor: "#d2d2c9",
                labelAngle: -90/90
            },
            data: [{
                <?php
                $a="";
                if($cal_date_db > $date_now){
                    //echo " ,lineColor: 'red'";
                }
                ?>
                name: "Temperature 1",
                type: "spline",
                showInLegend: true,
                yValueFormatString: "#0.## C",
                dataPoints: [
                    <?php
                    require 'modules/db.php';
                    $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                    //                echo $sql;
                    $res = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($res)){
                        $time = get_time($row["date_now"]);
                        $date = get_date($row["date_now"]);
                        echo "
                        { label: '".$date." (".$time.")', y: ".$row['Tmp1']." 
                        ";
                        if($cal_date_db < $date){
                            echo " ,lineColor: '#7face2', color: '#7face2'";
                        }
                        echo "},";
                    }
                    ?>
                ]
            },
                {
                    name: "Temperature 2",
                    type: "spline",
                    yValueFormatString: "#0.## C",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['Tmp2']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#c7706f', color: '#c7706f'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                },
                {
                    name: "Temperature 3",
                    type: "spline",
                    yValueFormatString: "#0.## C",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        //                echo $sql;
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['Tmp3']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#e0ffa0', color: '#e0ffa0'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                }]
        });


        // Three Power Charts
        var power = new CanvasJS.Chart("three_power_phases", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            title:{
                text: "Power (W)",
                fontColor: "#d2d2c9",
                fontFamily:'Helvetica Neue, Helvetica, Arial, sans-serif',
                fontWeight: "lighter",
                //      fontWeight: "Normal",
            },
            axisX: {
                valueFormatString: "DD MMM,YY",
            },
            axisY: {
                title: "Power (in W)",
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
                labelFontColor: "#d2d2c9",
                gridColor: "#ffffff1f"
            },
            axisX: {
                labelFontColor: "#d2d2c9",
                labelAngle: -90/90
            },
            data: [{
                <?php
                $a="";
                if($cal_date_db > $date_now){
                    //echo " ,lineColor: 'red'";
                }
                ?>
                name: "Power 1",
                type: "spline",
                showInLegend: true,
                yValueFormatString: "#0.## W",
                dataPoints: [
                    <?php
                    require 'modules/db.php';
                    $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                    //                echo $sql;
                    $res = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($res)){
                        $time = get_time($row["date_now"]);
                        $date = get_date($row["date_now"]);
                        echo "
                        { label: '".$date." (".$time.")', y: ".$row['pow1']." 
                        ";
                        if($cal_date_db < $date){
                            echo " ,lineColor: '#7face2', color: '#7face2'";
                        }
                        echo "},";
                    }
                    ?>
                ]
            },
                {
                    name: "Power 2",
                    type: "spline",
                    yValueFormatString: "#0.## W",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['pow2']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#c7706f', color: '#c7706f'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                },
                {
                    name: "Power 3",
                    type: "spline",
                    yValueFormatString: "#0.## W",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$device_mac_address."' $order_query";
                        //                echo $sql;
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "
                        { label: '".$date." (".$time.")', y: ".$row['pow3']." 
                        ";
                            if($cal_date_db < $date){
                                echo " ,lineColor: '#e0ffa0', color: '#e0ffa0'";
                            }
                            echo "},";
                        }
                        ?>
                    ]
                }]
        });
        //Render All Charts
        currents.render();
        voltages.render();
        temperature.render();
        power.render();










        function toggleDataSeries(e){
            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                e.dataSeries.visible = false;
            }
            else{
                e.dataSeries.visible = true;
            }
            chart.render();
        }
    }
</script>

<?php
function get_date($timestamp){
    $new_time = explode(" ",$timestamp);
    return $new_time[0];
}
function get_time($timestamp){
    $new_time = explode(" ",$timestamp);
    return date("g:i a", strtotime($new_time[1]));
}

?>