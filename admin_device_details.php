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
    <?php
        require 'modules/classes/class.updateConfigs.php';
        $configs = new updateConfigs();
        $config_data = $configs->getConfigs();
        if($config_data){
            $mail_email = $config_data[0]["mailing_address"];
            $cal_date = $config_data[0]["calibration_date"];
        }else{
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
                            <div>IP:</div>
                            <div>Email:</div>
                            <div>Cal. Date:</div>
                        </div>
                        <div class="ml-1 text-muted font-weight-bold">
                            <div><?php echo $_SESSION["username"]; ?></div>
                            <div>Pakistan</div>
                            <div>Controller</div>
                            <div>11:22:33:44:55</div>
                            <div class="text-success">ON</div>
                            <div>192.168.0.1</div>
                            <div><?php echo $mail_email ?><span><button type="button" class="custom-btn-1 ml-1" data-toggle="modal" data-target="#edit_email">(Edit)</button></span></div>
                            <div><?php echo $cal_date ?><span><button type="button" class="custom-btn-1 ml-1" data-toggle="modal" data-target="#edit_cal_date">(Edit)</button></span></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="col-4">
                            <h3 class="color-red text-center">Alarm</h3>
                            <div class="text-center">
                                <i class="fa fa-bell text-muted font-size-150px" aria-hidden="true"></i>
                                <p class="font-weight-bold mt-2">Alarm Status: <span class="text-danger">ON</span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <h3 class="color-red text-center">Human Detection</h3>
                            <div class="text-center">
                                <i class="fas fa-user-slash text-muted font-size-150px" aria-hidden="true"></i>
                                <p class="font-weight-bold mt-2">Human Detection: <span class="text-success">No</span></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <h3 class="color-red text-center">Relay Control</h3>
                            <div class="text-center mt-5">
                                <input type="checkbox" checked data-toggle="toggle" data-size="large">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12">
                <div class="w-93 mx-auto">
                    <div id="three_current_phases"></div>
                </div>
            </div>
            <div class="spacer">
                &nbsp;
            </div>
            <div class="container col-12 mt-5">
                <div class="row">
                    <div class="col-4">
                        <?php
                        $heading="Voltage Phase 1";
                        $chart_type="vol_ph_1"; $sub="submit_vol_ph_1"; require 'modules/filter_form.php'; ?>
                        <div id="current_history_graph" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                    </div>
                    <div class="col-4">
                        <?php
                        $heading="Voltage Phase 2";
                        $chart_type="vol_ph_2"; $sub="submit_vol_ph_2"; require 'modules/filter_form.php'; ?>
                        <div id="voltage_history_graph" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                    </div>
                    <div class="col-4">
                        <?php
                        $heading="Voltage Phase 3";
                        $chart_type="vol_ph_3"; $sub="submit_vol_ph_3"; require 'modules/filter_form.php'; ?>
                        <div id="power_history_graph" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--        <div class="row mt-5">
            <div class="col-6">
                <h3 class="color-red mb-3 text-center">Alarm</h3>
                <div class="text-center">
                    <i class="fa fa-bell text-muted font-size-150px" aria-hidden="true"></i>
                    <p class="font-weight-bold mt-2">Alarm Status: <span class="text-danger">ON</span></p>
                </div>
            </div>
            <div class="col-6">
                <h3 class="color-red mb-3 text-center">Human Detection</h3>
                <div class="text-center">
                    <i class="fas fa-user-slash text-muted font-size-150px" aria-hidden="true"></i>
                    <p class="font-weight-bold mt-2">Human Detection: <span class="text-success">No</span></p>
                </div>
            </div>
        </div>-->
<!--        <h3 class="color-red my-3 text-center">Power Consumption Graphs</h3>-->


        <!-- Temperature Graphs  -->
        <div class="container-fluid row mt-5">
            <div class="col-4">
                <?php
                $heading="Temperature 1";
                $chart_type="tmp_1"; $sub="submit_tmp_1"; require 'modules/filter_form.php'; ?>
                <div id="temp_graph_1" style="height: 370px; width: 100%;"></div>
            </div>
            <div class="col-4">
                <?php
                $heading="Temperature 2";
                $chart_type="tmp_2"; $sub="submit_tmp_2"; require 'modules/filter_form.php'; ?>
                <div id="temp_graph_2" style="height: 370px; width: 100%;"></div>
            </div>
            <div class="col-4">
                <?php
                $heading="Temperature 3";
                $chart_type="tmp_3"; $sub="submit_tmp_3"; require 'modules/filter_form.php'; ?>
                <div id="temp_graph_3" style="height: 370px; width: 100%;"></div>
            </div>
        </div>


        <!-- Power Graphs  -->
        <div class="container-fluid row mt-5">
            <div class="col-4">
                <?php
                $heading="Power Phase 1";
                $chart_type="pwr_1"; $sub="submit_pwr_1"; require 'modules/filter_form.php'; ?>
                <div id="power_graph_1" style="height: 370px; width: 100%;"></div>
            </div>
            <div class="col-4">
                <?php
                $heading="Power Phase 2";
                $chart_type="pwr_2"; $sub="submit_pwr_2"; require 'modules/filter_form.php'; ?>
                <div id="power_graph_2" style="height: 370px; width: 100%;"></div>
            </div>
            <div class="col-4">
                <?php
                $heading="Power Phase 3";
                $chart_type="pwr_3"; $sub="submit_pwr_3"; require 'modules/filter_form.php'; ?>
                <div id="power_graph_3" style="height: 370px; width: 100%;"></div>
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
            $email = secure_parameter($_POST["new_email"]);
            if($configs->updateEmail($email)){
                js_redirect('dashboard.php');
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
            $date = $_POST["new_date"];
            if($configs->updateDate($date)){
                js_redirect('dashboard.php');
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
        // First line charts
        var chart = new CanvasJS.Chart("three_current_phases", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            title:{
                text: "Currents",
                fontColor: "red"
            },
            axisX: {
                valueFormatString: "DD MMM,YY",
            },
            axisY: {
                title: "Current (in Amp)",
                gridColor: "lightgreen",
                includeZero: false,
                gridColor: "#ffffff1f"
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
                name: "Current 1",
                type: "spline",
                yValueFormatString: "#0.## Amp",
                showInLegend: true,
                dataPoints: [
                    { x: new Date(2017,6,24), y: 31 },
                    { x: new Date(2017,6,25), y: 31 },
                    { x: new Date(2017,6,26), y: 29 },
                    { x: new Date(2017,6,27), y: 29 },
                    { x: new Date(2017,6,28), y: 31 },
                    { x: new Date(2017,6,29), y: 30 },
                    { x: new Date(2017,6,30), y: 29 }
                ]
            },
                {
                    name: "Current 2",
                    type: "spline",
                    yValueFormatString: "#0.## Amp",
                    showInLegend: true,
                    dataPoints: [
                        { x: new Date(2017,6,24), y: 20 },
                        { x: new Date(2017,6,25), y: 20 },
                        { x: new Date(2017,6,26), y: 25 },
                        { x: new Date(2017,6,27), y: 25 },
                        { x: new Date(2017,6,28), y: 25 },
                        { x: new Date(2017,6,29), y: 25 },
                        { x: new Date(2017,6,30), y: 25 }
                    ]
                },
                {
                    name: "Current 3",
                    type: "spline",
                    yValueFormatString: "#0.## Amp",
                    showInLegend: true,
                    dataPoints: [
                        { x: new Date(2017,6,24), y: 22 },
                        { x: new Date(2017,6,25), y: 19 },
                        { x: new Date(2017,6,26), y: 23 },
                        { x: new Date(2017,6,27), y: 24 },
                        { x: new Date(2017,6,28), y: 24 },
                        { x: new Date(2017,6,29), y: 23 },
                        { x: new Date(2017,6,30), y: 23 }
                    ]
                }]
        });




//tHREE chARTS

        var limit = 5000;
        var y = 100;
        var data = [];
        var dataSeries = { type: "line" };
        var    dataPoints= [
            { label: '2019-09-17 (2:12 pm)', y: 5.00 },{ label: '2019-09-17 (2:12 pm)', y: 5.00 },{ label: '2019-09-17 (2:12 pm)', y: 5.00 },{ label: '2019-09-17 (2:13 pm)', y: 5.00 },{ label: '2019-09-17 (2:13 pm)', y: 5.00 },{ label: '2019-09-17 (2:13 pm)', y: 5.00 },{ label: '2019-09-17 (2:14 pm)', y: 5.00 },{ label: '2019-09-17 (2:14 pm)', y: 5.00 },{ label: '2019-09-17 (2:14 pm)', y: 5.00 },{ label: '2019-09-17 (2:15 pm)', y: 5.00 },{ label: '2019-09-17 (1:15 pm)', y: 5.00 },{ label: '2019-09-17 (2:15 pm)', y: 5.00 },{ label: '2019-09-17 (2:16 pm)', y: 5.00 },{ label: '2019-09-17 (2:16 pm)', y: 5.00 },{ label: '2019-09-17 (2:16 pm)', y: 5.00 },{ label: '2019-09-17 (2:17 pm)', y: 5.00 },{ label: '2019-09-17 (2:17 pm)', y: 5.00 },{ label: '2019-09-17 (2:17 pm)', y: 5.00 },{ label: '2019-09-17 (2:18 pm)', y: 5.00 },{ label: '2019-09-17 (2:18 pm)', y: 5.00 },{ label: '2019-09-17 (2:19 pm)', y: 5.00 },{ label: '2019-09-17 (2:19 pm)', y: 5.00 },{ label: '2019-09-17 (2:19 pm)', y: 5.00 },{ label: '2019-09-17 (2:20 pm)', y: 5.00 },{ label: '2019-09-17 (9:20 pm)', y: 5.00 },{ label: '2019-09-17 (2:20 pm)', y: 5.00 },{ label: '2019-09-17 (2:21 pm)', y: 5.00 },{ label: '2019-09-17 (2:21 pm)', y: 5.00 },{ label: '2019-09-17 (2:21 pm)', y: 5.00 },{ label: '2019-09-17 (2:22 pm)', y: 5.00 },{ label: '2019-09-17 (2:22 pm)', y: 5.00 },{ label: '2019-09-17 (2:22 pm)', y: 5.00 },{ label: '2019-09-17 (2:23 pm)', y: 5.00 },{ label: '2019-09-17 (2:23 pm)', y: 5.00 },{ label: '2019-09-17 (2:23 pm)', y: 5.00 },{ label: '2019-09-17 (2:24 pm)', y: 5.00 },{ label: '2019-09-17 (2:24 pm)', y: 5.00 },{ label: '2019-09-17 (2:24 pm)', y: 5.00 },{ label: '2019-09-17 (2:25 pm)', y: 5.00 },{ label: '2019-09-17 (2:25 pm)', y: 5.00 },{ label: '2019-09-17 (2:26 pm)', y: 5.00 },{ label: '2019-09-17 (2:26 pm)', y: 5.00 },{ label: '2019-09-17 (2:26 pm)', y: 5.00 },{ label: '2019-09-17 (2:27 pm)', y: 5.00 },{ label: '2019-09-17 (2:27 pm)', y: 5.00 },{ label: '2019-09-17 (2:27 pm)', y: 5.00 },{ label: '2019-09-17 (2:28 pm)', y: 5.00 },{ label: '2019-09-17 (2:28 pm)', y: 5.00 },{ label: '2019-09-17 (2:28 pm)', y: 5.00 },{ label: '2019-09-17 (2:29 pm)', y: 5.00 },{ label: '2019-09-17 (2:29 pm)', y: 5.00 },{ label: '2019-09-17 (2:29 pm)', y: 5.00 },{ label: '2019-09-17 (2:30 pm)', y: 5.00 },{ label: '2019-09-17 (2:30 pm)', y: 5.00 },{ label: '2019-09-17 (2:30 pm)', y: 5.00 },{ label: '2019-09-17 (2:31 pm)', y: 5.00 },{ label: '2019-09-17 (2:31 pm)', y: 5.00 },{ label: '2019-09-17 (2:31 pm)', y: 5.00 },{ label: '2019-09-17 (2:32 pm)', y: 5.00 },{ label: '2019-09-17 (2:32 pm)', y: 5.00 },{ label: '2019-09-17 (2:33 pm)', y: 5.00 },{ label: '2019-09-17 (2:33 pm)', y: 5.00 },{ label: '2019-09-17 (2:33 pm)', y: 5.00 },{ label: '2019-09-17 (2:34 pm)', y: 5.00 },{ label: '2019-09-17 (2:34 pm)', y: 5.00 },{ label: '2019-09-17 (2:34 pm)', y: 5.00 },{ label: '2019-09-17 (2:35 pm)', y: 5.00 },{ label: '2019-09-17 (2:35 pm)', y: 5.00 },{ label: '2019-09-17 (2:35 pm)', y: 5.00 },{ label: '2019-09-17 (2:36 pm)', y: 5.00 },{ label: '2019-09-17 (2:36 pm)', y: 5.00 },{ label: '2019-09-17 (2:36 pm)', y: 5.00 },{ label: '2019-09-17 (2:37 pm)', y: 5.00 },{ label: '2019-09-17 (2:37 pm)', y: 5.00 },{ label: '2019-09-17 (2:37 pm)', y: 5.00 },{ label: '2019-09-17 (2:38 pm)', y: 5.00 },{ label: '2019-09-17 (2:38 pm)', y: 5.00 },{ label: '2019-09-17 (2:38 pm)', y: 5.00 },{ label: '2019-09-17 (2:39 pm)', y: 5.00 },{ label: '2019-09-17 (2:39 pm)', y: 5.00 },{ label: '2019-09-17 (2:40 pm)', y: 5.00 },{ label: '2019-09-17 (2:40 pm)', y: 5.00 },{ label: '2019-09-17 (2:40 pm)', y: 5.00 },{ label: '2019-09-17 (2:41 pm)', y: 5.00 },{ label: '2019-09-17 (2:41 pm)', y: 5.00 },{ label: '2019-09-17 (6:06 pm)', y: 5.00 },{ label: '2019-09-17 (6:06 pm)', y: 5.00 },{ label: '2019-09-17 (6:06 pm)', y: 5.00 },{ label: '2019-09-17 (6:07 pm)', y: 5.00 },{ label: '2019-09-17 (6:07 pm)', y: 5.00 },{ label: '2019-09-17 (6:07 pm)', y: 5.00 },{ label: '2019-09-17 (6:08 pm)', y: 5.00 },{ label: '2019-09-17 (6:08 pm)', y: 5.00 },{ label: '2019-09-17 (6:08 pm)', y: 5.00 },{ label: '2019-09-17 (6:09 pm)', y: 5.00 },{ label: '2019-09-17 (6:09 pm)', y: 5.00 },{ label: '2019-09-17 (6:10 pm)', y: 5.00 },{ label: '2019-09-17 (6:10 pm)', y: 5.00 },{ label: '2019-09-17 (6:10 pm)', y: 5.00 },{ label: '2019-09-17 (6:11 pm)', y: 5.00 },{ label: '2019-09-17 (6:11 pm)', y: 5.00 },{ label: '2019-09-17 (6:11 pm)', y: 5.00 },{ label: '2019-09-17 (6:12 pm)', y: 5.00 },{ label: '2019-09-17 (6:12 pm)', y: 5.00 },{ label: '2019-09-17 (6:12 pm)', y: 5.00 },{ label: '2019-09-17 (6:13 pm)', y: 5.00 },{ label: '2019-09-17 (6:13 pm)', y: 5.00 },{ label: '2019-09-17 (6:13 pm)', y: 5.00 },{ label: '2019-09-17 (6:14 pm)', y: 5.00 },{ label: '2019-09-17 (6:14 pm)', y: 5.00 },{ label: '2019-09-17 (6:14 pm)', y: 5.00 },{ label: '2019-09-17 (6:15 pm)', y: 5.00 },{ label: '2019-09-17 (6:15 pm)', y: 5.00 },{ label: '2019-09-17 (6:15 pm)', y: 5.00 },{ label: '2019-09-17 (6:16 pm)', y: 5.00 },{ label: '2019-09-17 (6:16 pm)', y: 5.00 },{ label: '2019-09-17 (6:17 pm)', y: 5.00 },{ label: '2019-09-17 (6:17 pm)', y: 5.00 },{ label: '2019-09-17 (6:17 pm)', y: 5.00 },{ label: '2019-09-17 (6:18 pm)', y: 5.00 },{ label: '2019-09-17 (6:18 pm)', y: 5.00 },{ label: '2019-09-17 (6:18 pm)', y: 5.00 },{ label: '2019-09-17 (6:19 pm)', y: 5.00 },{ label: '2019-09-17 (6:19 pm)', y: 5.00 },{ label: '2019-09-17 (6:19 pm)', y: 5.00 },{ label: '2019-09-17 (6:20 pm)', y: 5.00 },{ label: '2019-09-17 (6:20 pm)', y: 5.00 },{ label: '2019-09-17 (6:20 pm)', y: 5.00 },{ label: '2019-09-17 (6:21 pm)', y: 5.00 },{ label: '2019-09-17 (6:21 pm)', y: 5.00 },{ label: '2019-09-17 (6:22 pm)', y: 5.00 },{ label: '2019-09-17 (6:22 pm)', y: 5.00 },{ label: '2019-09-17 (6:23 pm)', y: 5.00 },{ label: '2019-09-17 (6:23 pm)', y: 5.00 },{ label: '2019-09-17 (6:23 pm)', y: 5.00 },{ label: '2019-09-17 (6:24 pm)', y: 5.00 },{ label: '2019-09-17 (6:24 pm)', y: 5.00 },{ label: '2019-09-17 (7:26 pm)', y: 5.00 },{ label: '2019-09-17 (7:26 pm)', y: 5.00 },{ label: '2019-09-17 (7:26 pm)', y: 5.00 },{ label: '2019-09-17 (7:27 pm)', y: 5.00 },{ label: '2019-09-17 (7:27 pm)', y: 5.00 },{ label: '2019-09-17 (7:27 pm)', y: 5.00 },{ label: '2019-09-17 (7:28 pm)', y: 5.00 },{ label: '2019-09-17 (7:29 pm)', y: 5.00 },{ label: '2019-09-17 (7:35 pm)', y: 5.00 },{ label: '2019-09-17 (7:35 pm)', y: 5.00 },{ label: '2019-09-17 (7:35 pm)', y: 5.00 },{ label: '2019-09-17 (7:35 pm)', y: 5.00 },{ label: '2019-09-17 (7:38 pm)', y: 5.00 },{ label: '2019-09-17 (7:47 pm)', y: 5.00 },{ label: '2019-09-17 (7:48 pm)', y: 5.00 },{ label: '2019-09-17 (7:49 pm)', y: 5.00 },{ label: '2019-09-17 (7:49 pm)', y: 5.00 },{ label: '2019-09-17 (7:50 pm)', y: 5.00 },{ label: '2019-09-17 (7:50 pm)', y: 5.00 },{ label: '2019-09-17 (7:51 pm)', y: 5.00 },{ label: '2019-09-17 (7:51 pm)', y: 5.00 },{ label: '2019-09-17 (7:52 pm)', y: 5.00 },{ label: '2019-09-17 (7:52 pm)', y: 5.00 },{ label: '2019-09-17 (7:53 pm)', y: 5.00 },{ label: '2019-09-17 (7:53 pm)', y: 5.00 },{ label: '2019-09-17 (7:54 pm)', y: 5.00 },{ label: '2019-09-17 (7:54 pm)', y: 5.00 },{ label: '2019-09-17 (8:23 pm)', y: 5.00 },{ label: '2019-09-17 (8:24 pm)', y: 5.00 },{ label: '2019-09-17 (8:27 pm)', y: 5.00 },{ label: '2019-09-17 (8:30 pm)', y: 5.00 },{ label: '2019-09-17 (8:30 pm)', y: 5.00 },{ label: '2019-09-17 (8:31 pm)', y: 5.00 },{ label: '2019-09-17 (8:31 pm)', y: 5.00 },{ label: '2019-09-17 (8:32 pm)', y: 5.00 },{ label: '2019-09-17 (8:32 pm)', y: 5.00 },{ label: '2019-09-17 (8:33 pm)', y: 5.00 },{ label: '2019-09-17 (8:33 pm)', y: 5.00 },{ label: '2019-09-17 (9:21 pm)', y: 5.00 },{ label: '2019-09-17 (9:42 pm)', y: 5.00 },{ label: '2019-09-17 (9:43 pm)', y: 5.00 },{ label: '2019-09-17 (9:43 pm)', y: 0.00 },{ label: '2019-09-17 (9:44 pm)', y: 0.00 },{ label: '2019-09-17 (9:44 pm)', y: 0.00 },{ label: '2019-09-17 (9:45 pm)', y: 5.00 },{ label: '2019-09-17 (9:45 pm)', y: 5.00 },{ label: '2019-09-17 (9:46 pm)', y: 5.00 },{ label: '2019-09-17 (9:46 pm)', y: 5.00 },{ label: '2019-09-17 (9:47 pm)', y: 5.00 },{ label: '2019-09-17 (9:47 pm)', y: 5.00 },{ label: '2019-09-17 (9:48 pm)', y: 5.00 },{ label: '2019-09-17 (9:48 pm)', y: 5.00 },{ label: '2019-09-17 (9:49 pm)', y: 5.00 },{ label: '2019-09-17 (9:49 pm)', y: 5.00 },{ label: '2019-09-17 (9:50 pm)', y: 5.00 },{ label: '2019-09-17 (9:50 pm)', y: 5.00 },{ label: '2019-09-17 (9:51 pm)', y: 5.00 },{ label: '2019-09-17 (9:51 pm)', y: 5.00 },{ label: '2019-09-17 (9:52 pm)', y: 0.00 },{ label: '2019-09-17 (9:53 pm)', y: 0.00 },{ label: '2019-09-17 (9:53 pm)', y: 0.00 },{ label: '2019-09-17 (9:54 pm)', y: 0.00 },{ label: '2019-09-17 (9:54 pm)', y: 0.00 },{ label: '2019-09-17 (9:55 pm)', y: 0.00 },{ label: '2019-09-17 (9:55 pm)', y: 0.00 },{ label: '2019-09-17 (9:56 pm)', y: 0.00 },{ label: '2019-09-17 (9:56 pm)', y: 0.00 },{ label: '2019-09-17 (9:57 pm)', y: 0.00 },{ label: '2019-09-17 (9:57 pm)', y: 0.00 },{ label: '2019-09-17 (9:58 pm)', y: 0.00 },{ label: '2019-09-17 (9:58 pm)', y: 0.00 },{ label: '2019-09-17 (9:59 pm)', y: 0.00 },{ label: '2019-09-17 (9:59 pm)', y: 0.00 },{ label: '2019-09-17 (10:00 pm)', y: 0.00 },{ label: '2019-09-17 (10:01 pm)', y: 0.00 },{ label: '2019-09-17 (10:01 pm)', y: 0.00 },{ label: '2019-09-17 (10:02 pm)', y: 0.00 },{ label: '2019-09-17 (10:02 pm)', y: 0.00 },{ label: '2019-09-17 (10:03 pm)', y: 0.00 },{ label: '2019-09-17 (10:03 pm)', y: 0.00 },{ label: '2019-09-17 (10:04 pm)', y: 0.00 },{ label: '2019-09-17 (10:04 pm)', y: 0.00 },{ label: '2019-09-17 (10:05 pm)', y: 0.00 },{ label: '2019-09-17 (10:06 pm)', y: 0.00 },{ label: '2019-09-17 (10:06 pm)', y: 0.00 },{ label: '2019-09-17 (10:07 pm)', y: 0.00 },{ label: '2019-09-17 (10:07 pm)', y: 0.00 },{ label: '2019-09-17 (10:08 pm)', y: 0.00 },{ label: '2019-09-17 (10:08 pm)', y: 0.00 },{ label: '2019-09-17 (10:09 pm)', y: 0.00 },{ label: '2019-09-17 (10:10 pm)', y: 0.00 },{ label: '2019-09-17 (10:10 pm)', y: 0.00 },{ label: '2019-09-17 (10:11 pm)', y: 0.00 },{ label: '2019-09-17 (10:11 pm)', y: 0.00 },{ label: '2019-09-17 (10:12 pm)', y: 0.00 },{ label: '2019-09-17 (10:12 pm)', y: 0.00 },{ label: '2019-09-17 (10:13 pm)', y: 0.00 },{ label: '2019-09-17 (10:13 pm)', y: 0.00 },{ label: '2019-09-17 (10:14 pm)', y: 0.00 },{ label: '2019-09-17 (10:14 pm)', y: 0.00 },{ label: '2019-09-17 (10:15 pm)', y: 0.00 },{ label: '2019-09-17 (10:15 pm)', y: 0.00 },{ label: '2019-09-17 (10:16 pm)', y: 0.00 },{ label: '2019-09-17 (10:23 pm)', y: 1.00 },{ label: '2019-09-17 (10:23 pm)', y: 1.00 },{ label: '2019-09-17 (10:24 pm)', y: 2.00 },{ label: '2019-09-17 (10:24 pm)', y: 1.00 },{ label: '2019-09-17 (10:25 pm)', y: 2.00 },{ label: '2019-09-17 (10:25 pm)', y: 1.00 },{ label: '2019-09-17 (10:26 pm)', y: 1.00 },{ label: '2019-09-17 (10:26 pm)', y: 1.00 },{ label: '2019-09-17 (10:27 pm)', y: 0.00 },{ label: '2019-09-17 (10:27 pm)', y: 0.00 },{ label: '2019-09-17 (10:28 pm)', y: 0.00 },{ label: '2019-09-17 (10:28 pm)', y: 0.00 },{ label: '2019-09-17 (10:29 pm)', y: 0.00 },{ label: '2019-09-17 (10:29 pm)', y: 0.00 },{ label: '2019-09-17 (10:30 pm)', y: 0.00 },{ label: '2019-09-17 (10:30 pm)', y: 0.00 },{ label: '2019-09-17 (10:31 pm)', y: 0.00 },{ label: '2019-09-17 (10:36 pm)', y: 1.00 },{ label: '2019-09-17 (10:36 pm)', y: 1.00 },{ label: '2019-09-17 (10:37 pm)', y: 0.00 },{ label: '2019-09-17 (10:37 pm)', y: 0.00 },{ label: '2019-09-17 (10:38 pm)', y: 0.00 },{ label: '2019-09-17 (10:38 pm)', y: 0.00 },{ label: '2019-09-17 (10:39 pm)', y: 3.00 },{ label: '2019-09-17 (10:39 pm)', y: 3.00 },{ label: '2019-09-17 (10:40 pm)', y: 3.00 },{ label: '2019-09-17 (10:40 pm)', y: 3.00 },{ label: '2019-09-17 (10:41 pm)', y: 3.00 },{ label: '2019-09-17 (10:41 pm)', y: 1.00 },{ label: '2019-09-17 (10:42 pm)', y: 2.00 },{ label: '2019-09-17 (10:42 pm)', y: 2.00 },{ label: '2019-09-17 (10:43 pm)', y: 1.00 },{ label: '2019-09-17 (10:43 pm)', y: 1.00 },{ label: '2019-09-17 (10:44 pm)', y: 1.00 },{ label: '2019-09-17 (10:44 pm)', y: 1.00 },{ label: '2019-09-17 (10:45 pm)', y: 1.00 },{ label: '2019-09-17 (10:45 pm)', y: 1.00 },{ label: '2019-09-17 (10:46 pm)', y: 1.00 },{ label: '2019-09-17 (10:46 pm)', y: 1.00 },{ label: '2019-09-17 (10:47 pm)', y: 1.00 },{ label: '2019-09-17 (10:47 pm)', y: 1.00 },{ label: '2019-09-17 (10:48 pm)', y: 1.00 },{ label: '2019-09-17 (10:48 pm)', y: 1.00 },{ label: '2019-09-17 (10:49 pm)', y: 1.00 },{ label: '2019-09-17 (10:49 pm)', y: 1.00 },{ label: '2019-09-17 (10:50 pm)', y: 1.00 },{ label: '2019-09-17 (10:50 pm)', y: 1.00 },{ label: '2019-09-17 (10:51 pm)', y: 1.00 },{ label: '2019-09-17 (10:51 pm)', y: 1.00 },{ label: '2019-09-17 (10:52 pm)', y: 1.00 },{ label: '2019-09-17 (10:52 pm)', y: 1.00 }
        ];


        dataSeries.dataPoints = dataPoints;
        dataSeries.lineColor = "#d048b6";
        data.push(dataSeries);

//Better to construct options first and then pass it as a parameter
        var options = {
            backgroundColor: "#27293d",
            zoomEnabled: true,
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Voltage Phase 1",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
            data: data  // random data
        };

//FOR VOLTAGE CHART
        var limit1 = 291;
        var y = 100;
        var data1 = [];
        var dataSeries1 = { type: "line" };
        var    dataPoints1= [
            { label: '2019-09-17 (2:12 pm)', y: 230.00 },{ label: '2019-09-17 (2:12 pm)', y: 230.00 },{ label: '2019-09-17 (2:12 pm)', y: 230.00 },{ label: '2019-09-17 (2:13 pm)', y: 230.00 },{ label: '2019-09-17 (2:13 pm)', y: 230.00 },{ label: '2019-09-17 (2:13 pm)', y: 230.00 },{ label: '2019-09-17 (2:14 pm)', y: 230.00 },{ label: '2019-09-17 (2:14 pm)', y: 230.00 },{ label: '2019-09-17 (2:14 pm)', y: 230.00 },{ label: '2019-09-17 (2:15 pm)', y: 230.00 },{ label: '2019-09-17 (1:15 pm)', y: 230.00 },{ label: '2019-09-17 (2:15 pm)', y: 230.00 },{ label: '2019-09-17 (2:16 pm)', y: 230.00 },{ label: '2019-09-17 (2:16 pm)', y: 230.00 },{ label: '2019-09-17 (2:16 pm)', y: 230.00 },{ label: '2019-09-17 (2:17 pm)', y: 230.00 },{ label: '2019-09-17 (2:17 pm)', y: 230.00 },{ label: '2019-09-17 (2:17 pm)', y: 230.00 },{ label: '2019-09-17 (2:18 pm)', y: 230.00 },{ label: '2019-09-17 (2:18 pm)', y: 230.00 },{ label: '2019-09-17 (2:19 pm)', y: 230.00 },{ label: '2019-09-17 (2:19 pm)', y: 230.00 },{ label: '2019-09-17 (2:19 pm)', y: 230.00 },{ label: '2019-09-17 (2:20 pm)', y: 230.00 },{ label: '2019-09-17 (9:20 pm)', y: 230.00 },{ label: '2019-09-17 (2:20 pm)', y: 230.00 },{ label: '2019-09-17 (2:21 pm)', y: 230.00 },{ label: '2019-09-17 (2:21 pm)', y: 230.00 },{ label: '2019-09-17 (2:21 pm)', y: 230.00 },{ label: '2019-09-17 (2:22 pm)', y: 230.00 },{ label: '2019-09-17 (2:22 pm)', y: 230.00 },{ label: '2019-09-17 (2:22 pm)', y: 230.00 },{ label: '2019-09-17 (2:23 pm)', y: 230.00 },{ label: '2019-09-17 (2:23 pm)', y: 230.00 },{ label: '2019-09-17 (2:23 pm)', y: 230.00 },{ label: '2019-09-17 (2:24 pm)', y: 230.00 },{ label: '2019-09-17 (2:24 pm)', y: 230.00 },{ label: '2019-09-17 (2:24 pm)', y: 230.00 },{ label: '2019-09-17 (2:25 pm)', y: 230.00 },{ label: '2019-09-17 (2:25 pm)', y: 230.00 },{ label: '2019-09-17 (2:26 pm)', y: 230.00 },{ label: '2019-09-17 (2:26 pm)', y: 230.00 },{ label: '2019-09-17 (2:26 pm)', y: 230.00 },{ label: '2019-09-17 (2:27 pm)', y: 230.00 },{ label: '2019-09-17 (2:27 pm)', y: 230.00 },{ label: '2019-09-17 (2:27 pm)', y: 230.00 },{ label: '2019-09-17 (2:28 pm)', y: 230.00 },{ label: '2019-09-17 (2:28 pm)', y: 230.00 },{ label: '2019-09-17 (2:28 pm)', y: 230.00 },{ label: '2019-09-17 (2:29 pm)', y: 230.00 },{ label: '2019-09-17 (2:29 pm)', y: 230.00 },{ label: '2019-09-17 (2:29 pm)', y: 230.00 },{ label: '2019-09-17 (2:30 pm)', y: 230.00 },{ label: '2019-09-17 (2:30 pm)', y: 230.00 },{ label: '2019-09-17 (2:30 pm)', y: 230.00 },{ label: '2019-09-17 (2:31 pm)', y: 230.00 },{ label: '2019-09-17 (2:31 pm)', y: 230.00 },{ label: '2019-09-17 (2:31 pm)', y: 230.00 },{ label: '2019-09-17 (2:32 pm)', y: 230.00 },{ label: '2019-09-17 (2:32 pm)', y: 230.00 },{ label: '2019-09-17 (2:33 pm)', y: 230.00 },{ label: '2019-09-17 (2:33 pm)', y: 230.00 },{ label: '2019-09-17 (2:33 pm)', y: 230.00 },{ label: '2019-09-17 (2:34 pm)', y: 230.00 },{ label: '2019-09-17 (2:34 pm)', y: 230.00 },{ label: '2019-09-17 (2:34 pm)', y: 230.00 },{ label: '2019-09-17 (2:35 pm)', y: 230.00 },{ label: '2019-09-17 (2:35 pm)', y: 230.00 },{ label: '2019-09-17 (2:35 pm)', y: 230.00 },{ label: '2019-09-17 (2:36 pm)', y: 230.00 },{ label: '2019-09-17 (2:36 pm)', y: 230.00 },{ label: '2019-09-17 (2:36 pm)', y: 230.00 },{ label: '2019-09-17 (2:37 pm)', y: 230.00 },{ label: '2019-09-17 (2:37 pm)', y: 230.00 },{ label: '2019-09-17 (2:37 pm)', y: 230.00 },{ label: '2019-09-17 (2:38 pm)', y: 230.00 },{ label: '2019-09-17 (2:38 pm)', y: 230.00 },{ label: '2019-09-17 (2:38 pm)', y: 230.00 },{ label: '2019-09-17 (2:39 pm)', y: 230.00 },{ label: '2019-09-17 (2:39 pm)', y: 230.00 },{ label: '2019-09-17 (2:40 pm)', y: 230.00 },{ label: '2019-09-17 (2:40 pm)', y: 230.00 },{ label: '2019-09-17 (2:40 pm)', y: 230.00 },{ label: '2019-09-17 (2:41 pm)', y: 230.00 },{ label: '2019-09-17 (2:41 pm)', y: 230.00 },{ label: '2019-09-17 (6:06 pm)', y: 230.00 },{ label: '2019-09-17 (6:06 pm)', y: 230.00 },{ label: '2019-09-17 (6:06 pm)', y: 230.00 },{ label: '2019-09-17 (6:07 pm)', y: 230.00 },{ label: '2019-09-17 (6:07 pm)', y: 230.00 },{ label: '2019-09-17 (6:07 pm)', y: 230.00 },{ label: '2019-09-17 (6:08 pm)', y: 230.00 },{ label: '2019-09-17 (6:08 pm)', y: 230.00 },{ label: '2019-09-17 (6:08 pm)', y: 230.00 },{ label: '2019-09-17 (6:09 pm)', y: 230.00 },{ label: '2019-09-17 (6:09 pm)', y: 230.00 },{ label: '2019-09-17 (6:10 pm)', y: 230.00 },{ label: '2019-09-17 (6:10 pm)', y: 230.00 },{ label: '2019-09-17 (6:10 pm)', y: 230.00 },{ label: '2019-09-17 (6:11 pm)', y: 230.00 },{ label: '2019-09-17 (6:11 pm)', y: 230.00 },{ label: '2019-09-17 (6:11 pm)', y: 230.00 },{ label: '2019-09-17 (6:12 pm)', y: 230.00 },{ label: '2019-09-17 (6:12 pm)', y: 230.00 },{ label: '2019-09-17 (6:12 pm)', y: 230.00 },{ label: '2019-09-17 (6:13 pm)', y: 230.00 },{ label: '2019-09-17 (6:13 pm)', y: 230.00 },{ label: '2019-09-17 (6:13 pm)', y: 230.00 },{ label: '2019-09-17 (6:14 pm)', y: 230.00 },{ label: '2019-09-17 (6:14 pm)', y: 230.00 },{ label: '2019-09-17 (6:14 pm)', y: 230.00 },{ label: '2019-09-17 (6:15 pm)', y: 230.00 },{ label: '2019-09-17 (6:15 pm)', y: 230.00 },{ label: '2019-09-17 (6:15 pm)', y: 230.00 },{ label: '2019-09-17 (6:16 pm)', y: 230.00 },{ label: '2019-09-17 (6:16 pm)', y: 230.00 },{ label: '2019-09-17 (6:17 pm)', y: 230.00 },{ label: '2019-09-17 (6:17 pm)', y: 230.00 },{ label: '2019-09-17 (6:17 pm)', y: 230.00 },{ label: '2019-09-17 (6:18 pm)', y: 230.00 },{ label: '2019-09-17 (6:18 pm)', y: 230.00 },{ label: '2019-09-17 (6:18 pm)', y: 230.00 },{ label: '2019-09-17 (6:19 pm)', y: 230.00 },{ label: '2019-09-17 (6:19 pm)', y: 230.00 },{ label: '2019-09-17 (6:19 pm)', y: 230.00 },{ label: '2019-09-17 (6:20 pm)', y: 230.00 },{ label: '2019-09-17 (6:20 pm)', y: 230.00 },{ label: '2019-09-17 (6:20 pm)', y: 230.00 },{ label: '2019-09-17 (6:21 pm)', y: 230.00 },{ label: '2019-09-17 (6:21 pm)', y: 230.00 },{ label: '2019-09-17 (6:22 pm)', y: 230.00 },{ label: '2019-09-17 (6:22 pm)', y: 230.00 },{ label: '2019-09-17 (6:23 pm)', y: 230.00 },{ label: '2019-09-17 (6:23 pm)', y: 230.00 },{ label: '2019-09-17 (6:23 pm)', y: 230.00 },{ label: '2019-09-17 (6:24 pm)', y: 230.00 },{ label: '2019-09-17 (6:24 pm)', y: 230.00 },{ label: '2019-09-17 (7:26 pm)', y: 230.00 },{ label: '2019-09-17 (7:26 pm)', y: 230.00 },{ label: '2019-09-17 (7:26 pm)', y: 230.00 },{ label: '2019-09-17 (7:27 pm)', y: 230.00 },{ label: '2019-09-17 (7:27 pm)', y: 230.00 },{ label: '2019-09-17 (7:27 pm)', y: 230.00 },{ label: '2019-09-17 (7:28 pm)', y: 230.00 },{ label: '2019-09-17 (7:29 pm)', y: 230.00 },{ label: '2019-09-17 (7:35 pm)', y: 230.00 },{ label: '2019-09-17 (7:35 pm)', y: 230.00 },{ label: '2019-09-17 (7:35 pm)', y: 230.00 },{ label: '2019-09-17 (7:35 pm)', y: 230.00 },{ label: '2019-09-17 (7:38 pm)', y: 230.00 },{ label: '2019-09-17 (7:47 pm)', y: 230.00 },{ label: '2019-09-17 (7:48 pm)', y: 230.00 },{ label: '2019-09-17 (7:49 pm)', y: 230.00 },{ label: '2019-09-17 (7:49 pm)', y: 230.00 },{ label: '2019-09-17 (7:50 pm)', y: 230.00 },{ label: '2019-09-17 (7:50 pm)', y: 230.00 },{ label: '2019-09-17 (7:51 pm)', y: 230.00 },{ label: '2019-09-17 (7:51 pm)', y: 230.00 },{ label: '2019-09-17 (7:52 pm)', y: 230.00 },{ label: '2019-09-17 (7:52 pm)', y: 230.00 },{ label: '2019-09-17 (7:53 pm)', y: 230.00 },{ label: '2019-09-17 (7:53 pm)', y: 230.00 },{ label: '2019-09-17 (7:54 pm)', y: 230.00 },{ label: '2019-09-17 (7:54 pm)', y: 230.00 },{ label: '2019-09-17 (8:23 pm)', y: 230.00 },{ label: '2019-09-17 (8:24 pm)', y: 230.00 },{ label: '2019-09-17 (8:27 pm)', y: 230.00 },{ label: '2019-09-17 (8:30 pm)', y: 230.00 },{ label: '2019-09-17 (8:30 pm)', y: 230.00 },{ label: '2019-09-17 (8:31 pm)', y: 230.00 },{ label: '2019-09-17 (8:31 pm)', y: 230.00 },{ label: '2019-09-17 (8:32 pm)', y: 230.00 },{ label: '2019-09-17 (8:32 pm)', y: 230.00 },{ label: '2019-09-17 (8:33 pm)', y: 230.00 },{ label: '2019-09-17 (8:33 pm)', y: 230.00 },{ label: '2019-09-17 (9:21 pm)', y: 230.00 },{ label: '2019-09-17 (9:42 pm)', y: 230.00 },{ label: '2019-09-17 (9:43 pm)', y: 230.00 },{ label: '2019-09-17 (9:43 pm)', y: 0.00 },{ label: '2019-09-17 (9:44 pm)', y: 0.00 },{ label: '2019-09-17 (9:44 pm)', y: 0.00 },{ label: '2019-09-17 (9:45 pm)', y: 230.00 },{ label: '2019-09-17 (9:45 pm)', y: 230.00 },{ label: '2019-09-17 (9:46 pm)', y: 230.00 },{ label: '2019-09-17 (9:46 pm)', y: 230.00 },{ label: '2019-09-17 (9:47 pm)', y: 230.00 },{ label: '2019-09-17 (9:47 pm)', y: 230.00 },{ label: '2019-09-17 (9:48 pm)', y: 230.00 },{ label: '2019-09-17 (9:48 pm)', y: 230.00 },{ label: '2019-09-17 (9:49 pm)', y: 230.00 },{ label: '2019-09-17 (9:49 pm)', y: 230.00 },{ label: '2019-09-17 (9:50 pm)', y: 230.00 },{ label: '2019-09-17 (9:50 pm)', y: 230.00 },{ label: '2019-09-17 (9:51 pm)', y: 230.00 },{ label: '2019-09-17 (9:51 pm)', y: 230.00 },{ label: '2019-09-17 (9:52 pm)', y: 0.00 },{ label: '2019-09-17 (9:53 pm)', y: 0.00 },{ label: '2019-09-17 (9:53 pm)', y: 0.00 },{ label: '2019-09-17 (9:54 pm)', y: 0.00 },{ label: '2019-09-17 (9:54 pm)', y: 0.00 },{ label: '2019-09-17 (9:55 pm)', y: 0.00 },{ label: '2019-09-17 (9:55 pm)', y: 0.00 },{ label: '2019-09-17 (9:56 pm)', y: 0.00 },{ label: '2019-09-17 (9:56 pm)', y: 0.00 },{ label: '2019-09-17 (9:57 pm)', y: 0.00 },{ label: '2019-09-17 (9:57 pm)', y: 0.00 },{ label: '2019-09-17 (9:58 pm)', y: 0.00 },{ label: '2019-09-17 (9:58 pm)', y: 0.00 },{ label: '2019-09-17 (9:59 pm)', y: 0.00 },{ label: '2019-09-17 (9:59 pm)', y: 0.00 },{ label: '2019-09-17 (10:00 pm)', y: 0.00 },{ label: '2019-09-17 (10:01 pm)', y: 0.00 },{ label: '2019-09-17 (10:01 pm)', y: 0.00 },{ label: '2019-09-17 (10:02 pm)', y: 0.00 },{ label: '2019-09-17 (10:02 pm)', y: 0.00 },{ label: '2019-09-17 (10:03 pm)', y: 0.00 },{ label: '2019-09-17 (10:03 pm)', y: 0.00 },{ label: '2019-09-17 (10:04 pm)', y: 0.00 },{ label: '2019-09-17 (10:04 pm)', y: 0.00 },{ label: '2019-09-17 (10:05 pm)', y: 0.00 },{ label: '2019-09-17 (10:06 pm)', y: 0.00 },{ label: '2019-09-17 (10:06 pm)', y: 0.00 },{ label: '2019-09-17 (10:07 pm)', y: 0.00 },{ label: '2019-09-17 (10:07 pm)', y: 0.00 },{ label: '2019-09-17 (10:08 pm)', y: 0.00 },{ label: '2019-09-17 (10:08 pm)', y: 0.00 },{ label: '2019-09-17 (10:09 pm)', y: 0.00 },{ label: '2019-09-17 (10:10 pm)', y: 0.00 },{ label: '2019-09-17 (10:10 pm)', y: 0.00 },{ label: '2019-09-17 (10:11 pm)', y: 0.00 },{ label: '2019-09-17 (10:11 pm)', y: 0.00 },{ label: '2019-09-17 (10:12 pm)', y: 0.00 },{ label: '2019-09-17 (10:12 pm)', y: 0.00 },{ label: '2019-09-17 (10:13 pm)', y: 0.00 },{ label: '2019-09-17 (10:13 pm)', y: 0.00 },{ label: '2019-09-17 (10:14 pm)', y: 0.00 },{ label: '2019-09-17 (10:14 pm)', y: 0.00 },{ label: '2019-09-17 (10:15 pm)', y: 0.00 },{ label: '2019-09-17 (10:15 pm)', y: 0.00 },{ label: '2019-09-17 (10:16 pm)', y: 0.00 },{ label: '2019-09-17 (10:23 pm)', y: 230.00 },{ label: '2019-09-17 (10:23 pm)', y: 230.00 },{ label: '2019-09-17 (10:24 pm)', y: 230.00 },{ label: '2019-09-17 (10:24 pm)', y: 230.00 },{ label: '2019-09-17 (10:25 pm)', y: 230.00 },{ label: '2019-09-17 (10:25 pm)', y: 230.00 },{ label: '2019-09-17 (10:26 pm)', y: 230.00 },{ label: '2019-09-17 (10:26 pm)', y: 230.00 },{ label: '2019-09-17 (10:27 pm)', y: 230.00 },{ label: '2019-09-17 (10:27 pm)', y: 230.00 },{ label: '2019-09-17 (10:28 pm)', y: 230.00 },{ label: '2019-09-17 (10:28 pm)', y: 230.00 },{ label: '2019-09-17 (10:29 pm)', y: 230.00 },{ label: '2019-09-17 (10:29 pm)', y: 230.00 },{ label: '2019-09-17 (10:30 pm)', y: 230.00 },{ label: '2019-09-17 (10:30 pm)', y: 230.00 },{ label: '2019-09-17 (10:31 pm)', y: 230.00 },{ label: '2019-09-17 (10:36 pm)', y: 230.00 },{ label: '2019-09-17 (10:36 pm)', y: 230.00 },{ label: '2019-09-17 (10:37 pm)', y: 230.00 },{ label: '2019-09-17 (10:37 pm)', y: 230.00 },{ label: '2019-09-17 (10:38 pm)', y: 230.00 },{ label: '2019-09-17 (10:38 pm)', y: 230.00 },{ label: '2019-09-17 (10:39 pm)', y: 230.00 },{ label: '2019-09-17 (10:39 pm)', y: 230.00 },{ label: '2019-09-17 (10:40 pm)', y: 230.00 },{ label: '2019-09-17 (10:40 pm)', y: 230.00 },{ label: '2019-09-17 (10:41 pm)', y: 230.00 },{ label: '2019-09-17 (10:41 pm)', y: 230.00 },{ label: '2019-09-17 (10:42 pm)', y: 230.00 },{ label: '2019-09-17 (10:42 pm)', y: 230.00 },{ label: '2019-09-17 (10:43 pm)', y: 230.00 },{ label: '2019-09-17 (10:43 pm)', y: 230.00 },{ label: '2019-09-17 (10:44 pm)', y: 230.00 },{ label: '2019-09-17 (10:44 pm)', y: 230.00 },{ label: '2019-09-17 (10:45 pm)', y: 230.00 },{ label: '2019-09-17 (10:45 pm)', y: 230.00 },{ label: '2019-09-17 (10:46 pm)', y: 230.00 },{ label: '2019-09-17 (10:46 pm)', y: 230.00 },{ label: '2019-09-17 (10:47 pm)', y: 230.00 },{ label: '2019-09-17 (10:47 pm)', y: 230.00 },{ label: '2019-09-17 (10:48 pm)', y: 230.00 },{ label: '2019-09-17 (10:48 pm)', y: 230.00 },{ label: '2019-09-17 (10:49 pm)', y: 230.00 },{ label: '2019-09-17 (10:49 pm)', y: 230.00 },{ label: '2019-09-17 (10:50 pm)', y: 230.00 },{ label: '2019-09-17 (10:50 pm)', y: 230.00 },{ label: '2019-09-17 (10:51 pm)', y: 230.00 },{ label: '2019-09-17 (10:51 pm)', y: 230.00 },{ label: '2019-09-17 (10:52 pm)', y: 230.00 },{ label: '2019-09-17 (10:52 pm)', y: 230.00 },    ];


        dataSeries1.dataPoints = dataPoints1;
        dataSeries1.lineColor = "#d048b6";
        data1.push(dataSeries1);

        var options1 = {
            lineColor:"#d048b6",
            backgroundColor: "#27293d",
            zoomEnabled: true,
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Voltage Phase 2",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
            data: data1  // random data
        };

//FOR POWER CHART
        var limit2 = 291;
        var y = 100;
        var data2 = [];
        var dataSeries2 = { type: "line" };
        var    dataPoints2= [
            { label: '2019-09-17 (2:12 pm)', y: 1092.50 },{ label: '2019-09-17 (2:12 pm)', y: 1092.50 },{ label: '2019-09-17 (2:12 pm)', y: 1092.50 },{ label: '2019-09-17 (2:13 pm)', y: 1092.50 },{ label: '2019-09-17 (2:13 pm)', y: 1092.50 },{ label: '2019-09-17 (2:13 pm)', y: 1092.50 },{ label: '2019-09-17 (2:14 pm)', y: 1092.50 },{ label: '2019-09-17 (2:14 pm)', y: 1092.50 },{ label: '2019-09-17 (2:14 pm)', y: 1092.50 },{ label: '2019-09-17 (2:15 pm)', y: 1092.50 },{ label: '2019-09-17 (1:15 pm)', y: 1092.50 },{ label: '2019-09-17 (2:15 pm)', y: 1092.50 },{ label: '2019-09-17 (2:16 pm)', y: 1092.50 },{ label: '2019-09-17 (2:16 pm)', y: 1092.50 },{ label: '2019-09-17 (2:16 pm)', y: 1092.50 },{ label: '2019-09-17 (2:17 pm)', y: 1092.50 },{ label: '2019-09-17 (2:17 pm)', y: 1092.50 },{ label: '2019-09-17 (2:17 pm)', y: 1092.50 },{ label: '2019-09-17 (2:18 pm)', y: 1092.50 },{ label: '2019-09-17 (2:18 pm)', y: 1092.50 },{ label: '2019-09-17 (2:19 pm)', y: 1092.50 },{ label: '2019-09-17 (2:19 pm)', y: 1092.50 },{ label: '2019-09-17 (2:19 pm)', y: 1092.50 },{ label: '2019-09-17 (2:20 pm)', y: 1092.50 },{ label: '2019-09-17 (9:20 pm)', y: 1092.50 },{ label: '2019-09-17 (2:20 pm)', y: 1092.50 },{ label: '2019-09-17 (2:21 pm)', y: 1092.50 },{ label: '2019-09-17 (2:21 pm)', y: 1092.50 },{ label: '2019-09-17 (2:21 pm)', y: 1092.50 },{ label: '2019-09-17 (2:22 pm)', y: 1092.50 },{ label: '2019-09-17 (2:22 pm)', y: 1092.50 },{ label: '2019-09-17 (2:22 pm)', y: 1092.50 },{ label: '2019-09-17 (2:23 pm)', y: 1092.50 },{ label: '2019-09-17 (2:23 pm)', y: 1092.50 },{ label: '2019-09-17 (2:23 pm)', y: 1092.50 },{ label: '2019-09-17 (2:24 pm)', y: 1092.50 },{ label: '2019-09-17 (2:24 pm)', y: 1092.50 },{ label: '2019-09-17 (2:24 pm)', y: 1092.50 },{ label: '2019-09-17 (2:25 pm)', y: 1092.50 },{ label: '2019-09-17 (2:25 pm)', y: 1092.50 },{ label: '2019-09-17 (2:26 pm)', y: 1092.50 },{ label: '2019-09-17 (2:26 pm)', y: 1092.50 },{ label: '2019-09-17 (2:26 pm)', y: 1092.50 },{ label: '2019-09-17 (2:27 pm)', y: 1092.50 },{ label: '2019-09-17 (2:27 pm)', y: 1092.50 },{ label: '2019-09-17 (2:27 pm)', y: 1092.50 },{ label: '2019-09-17 (2:28 pm)', y: 1092.50 },{ label: '2019-09-17 (2:28 pm)', y: 1092.50 },{ label: '2019-09-17 (2:28 pm)', y: 1092.50 },{ label: '2019-09-17 (2:29 pm)', y: 1092.50 },{ label: '2019-09-17 (2:29 pm)', y: 1092.50 },{ label: '2019-09-17 (2:29 pm)', y: 1092.50 },{ label: '2019-09-17 (2:30 pm)', y: 1092.50 },{ label: '2019-09-17 (2:30 pm)', y: 1092.50 },{ label: '2019-09-17 (2:30 pm)', y: 1092.50 },{ label: '2019-09-17 (2:31 pm)', y: 1092.50 },{ label: '2019-09-17 (2:31 pm)', y: 1092.50 },{ label: '2019-09-17 (2:31 pm)', y: 1092.50 },{ label: '2019-09-17 (2:32 pm)', y: 1092.50 },{ label: '2019-09-17 (2:32 pm)', y: 1092.50 },{ label: '2019-09-17 (2:33 pm)', y: 1092.50 },{ label: '2019-09-17 (2:33 pm)', y: 1092.50 },{ label: '2019-09-17 (2:33 pm)', y: 1092.50 },{ label: '2019-09-17 (2:34 pm)', y: 1092.50 },{ label: '2019-09-17 (2:34 pm)', y: 1092.50 },{ label: '2019-09-17 (2:34 pm)', y: 1092.50 },{ label: '2019-09-17 (2:35 pm)', y: 1092.50 },{ label: '2019-09-17 (2:35 pm)', y: 1092.50 },{ label: '2019-09-17 (2:35 pm)', y: 1092.50 },{ label: '2019-09-17 (2:36 pm)', y: 1092.50 },{ label: '2019-09-17 (2:36 pm)', y: 1092.50 },{ label: '2019-09-17 (2:36 pm)', y: 1092.50 },{ label: '2019-09-17 (2:37 pm)', y: 1092.50 },{ label: '2019-09-17 (2:37 pm)', y: 1092.50 },{ label: '2019-09-17 (2:37 pm)', y: 1092.50 },{ label: '2019-09-17 (2:38 pm)', y: 1092.50 },{ label: '2019-09-17 (2:38 pm)', y: 1092.50 },{ label: '2019-09-17 (2:38 pm)', y: 1092.50 },{ label: '2019-09-17 (2:39 pm)', y: 1092.50 },{ label: '2019-09-17 (2:39 pm)', y: 1092.50 },{ label: '2019-09-17 (2:40 pm)', y: 1092.50 },{ label: '2019-09-17 (2:40 pm)', y: 1092.50 },{ label: '2019-09-17 (2:40 pm)', y: 1092.50 },{ label: '2019-09-17 (2:41 pm)', y: 1092.50 },{ label: '2019-09-17 (2:41 pm)', y: 1092.50 },{ label: '2019-09-17 (6:06 pm)', y: 1092.50 },{ label: '2019-09-17 (6:06 pm)', y: 1092.50 },{ label: '2019-09-17 (6:06 pm)', y: 1092.50 },{ label: '2019-09-17 (6:07 pm)', y: 1092.50 },{ label: '2019-09-17 (6:07 pm)', y: 1092.50 },{ label: '2019-09-17 (6:07 pm)', y: 1092.50 },{ label: '2019-09-17 (6:08 pm)', y: 1092.50 },{ label: '2019-09-17 (6:08 pm)', y: 1092.50 },{ label: '2019-09-17 (6:08 pm)', y: 1092.50 },{ label: '2019-09-17 (6:09 pm)', y: 1092.50 },{ label: '2019-09-17 (6:09 pm)', y: 1092.50 },{ label: '2019-09-17 (6:10 pm)', y: 1092.50 },{ label: '2019-09-17 (6:10 pm)', y: 1092.50 },{ label: '2019-09-17 (6:10 pm)', y: 1092.50 },{ label: '2019-09-17 (6:11 pm)', y: 1092.50 },{ label: '2019-09-17 (6:11 pm)', y: 1092.50 },{ label: '2019-09-17 (6:11 pm)', y: 1092.50 },{ label: '2019-09-17 (6:12 pm)', y: 1092.50 },{ label: '2019-09-17 (6:12 pm)', y: 1092.50 },{ label: '2019-09-17 (6:12 pm)', y: 1092.50 },{ label: '2019-09-17 (6:13 pm)', y: 1092.50 },{ label: '2019-09-17 (6:13 pm)', y: 1092.50 },{ label: '2019-09-17 (6:13 pm)', y: 1092.50 },{ label: '2019-09-17 (6:14 pm)', y: 1092.50 },{ label: '2019-09-17 (6:14 pm)', y: 1092.50 },{ label: '2019-09-17 (6:14 pm)', y: 1092.50 },{ label: '2019-09-17 (6:15 pm)', y: 1092.50 },{ label: '2019-09-17 (6:15 pm)', y: 1092.50 },{ label: '2019-09-17 (6:15 pm)', y: 1092.50 },{ label: '2019-09-17 (6:16 pm)', y: 1092.50 },{ label: '2019-09-17 (6:16 pm)', y: 1092.50 },{ label: '2019-09-17 (6:17 pm)', y: 1092.50 },{ label: '2019-09-17 (6:17 pm)', y: 1092.50 },{ label: '2019-09-17 (6:17 pm)', y: 1092.50 },{ label: '2019-09-17 (6:18 pm)', y: 1092.50 },{ label: '2019-09-17 (6:18 pm)', y: 1092.50 },{ label: '2019-09-17 (6:18 pm)', y: 1092.50 },{ label: '2019-09-17 (6:19 pm)', y: 1092.50 },{ label: '2019-09-17 (6:19 pm)', y: 1092.50 },{ label: '2019-09-17 (6:19 pm)', y: 1092.50 },{ label: '2019-09-17 (6:20 pm)', y: 1092.50 },{ label: '2019-09-17 (6:20 pm)', y: 1092.50 },{ label: '2019-09-17 (6:20 pm)', y: 1092.50 },{ label: '2019-09-17 (6:21 pm)', y: 1092.50 },{ label: '2019-09-17 (6:21 pm)', y: 1092.50 },{ label: '2019-09-17 (6:22 pm)', y: 1092.50 },{ label: '2019-09-17 (6:22 pm)', y: 1092.50 },{ label: '2019-09-17 (6:23 pm)', y: 1092.50 },{ label: '2019-09-17 (6:23 pm)', y: 1092.50 },{ label: '2019-09-17 (6:23 pm)', y: 1092.50 },{ label: '2019-09-17 (6:24 pm)', y: 1092.50 },{ label: '2019-09-17 (6:24 pm)', y: 1092.50 },{ label: '2019-09-17 (7:26 pm)', y: 1092.50 },{ label: '2019-09-17 (7:26 pm)', y: 1092.50 },{ label: '2019-09-17 (7:26 pm)', y: 1092.50 },{ label: '2019-09-17 (7:27 pm)', y: 1092.50 },{ label: '2019-09-17 (7:27 pm)', y: 1092.50 },{ label: '2019-09-17 (7:27 pm)', y: 1092.50 },{ label: '2019-09-17 (7:28 pm)', y: 1092.50 },{ label: '2019-09-17 (7:29 pm)', y: 1092.50 },{ label: '2019-09-17 (7:35 pm)', y: 1092.50 },{ label: '2019-09-17 (7:35 pm)', y: 1092.50 },{ label: '2019-09-17 (7:35 pm)', y: 1092.50 },{ label: '2019-09-17 (7:35 pm)', y: 1092.50 },{ label: '2019-09-17 (7:38 pm)', y: 1092.50 },{ label: '2019-09-17 (7:47 pm)', y: 1092.50 },{ label: '2019-09-17 (7:48 pm)', y: 1092.50 },{ label: '2019-09-17 (7:49 pm)', y: 1092.50 },{ label: '2019-09-17 (7:49 pm)', y: 1092.50 },{ label: '2019-09-17 (7:50 pm)', y: 1092.50 },{ label: '2019-09-17 (7:50 pm)', y: 1092.50 },{ label: '2019-09-17 (7:51 pm)', y: 1092.50 },{ label: '2019-09-17 (7:51 pm)', y: 1092.50 },{ label: '2019-09-17 (7:52 pm)', y: 1092.50 },{ label: '2019-09-17 (7:52 pm)', y: 1092.50 },{ label: '2019-09-17 (7:53 pm)', y: 1092.50 },{ label: '2019-09-17 (7:53 pm)', y: 1092.50 },{ label: '2019-09-17 (7:54 pm)', y: 1092.50 },{ label: '2019-09-17 (7:54 pm)', y: 1092.50 },{ label: '2019-09-17 (8:23 pm)', y: 1092.50 },{ label: '2019-09-17 (8:24 pm)', y: 1092.50 },{ label: '2019-09-17 (8:27 pm)', y: 1092.50 },{ label: '2019-09-17 (8:30 pm)', y: 1092.50 },{ label: '2019-09-17 (8:30 pm)', y: 1092.50 },{ label: '2019-09-17 (8:31 pm)', y: 1092.50 },{ label: '2019-09-17 (8:31 pm)', y: 1092.50 },{ label: '2019-09-17 (8:32 pm)', y: 1092.50 },{ label: '2019-09-17 (8:32 pm)', y: 1092.50 },{ label: '2019-09-17 (8:33 pm)', y: 1092.50 },{ label: '2019-09-17 (8:33 pm)', y: 1092.50 },{ label: '2019-09-17 (9:21 pm)', y: 1092.50 },{ label: '2019-09-17 (9:42 pm)', y: 1092.50 },{ label: '2019-09-17 (9:43 pm)', y: 1092.50 },{ label: '2019-09-17 (9:43 pm)', y: 0.00 },{ label: '2019-09-17 (9:44 pm)', y: 0.00 },{ label: '2019-09-17 (9:44 pm)', y: 0.00 },{ label: '2019-09-17 (9:45 pm)', y: 1092.50 },{ label: '2019-09-17 (9:45 pm)', y: 1092.50 },{ label: '2019-09-17 (9:46 pm)', y: 1092.50 },{ label: '2019-09-17 (9:46 pm)', y: 1092.50 },{ label: '2019-09-17 (9:47 pm)', y: 1092.50 },{ label: '2019-09-17 (9:47 pm)', y: 1092.50 },{ label: '2019-09-17 (9:48 pm)', y: 1092.50 },{ label: '2019-09-17 (9:48 pm)', y: 1092.50 },{ label: '2019-09-17 (9:49 pm)', y: 1092.50 },{ label: '2019-09-17 (9:49 pm)', y: 1092.50 },{ label: '2019-09-17 (9:50 pm)', y: 1092.50 },{ label: '2019-09-17 (9:50 pm)', y: 1092.50 },{ label: '2019-09-17 (9:51 pm)', y: 1092.50 },{ label: '2019-09-17 (9:51 pm)', y: 1092.50 },{ label: '2019-09-17 (9:52 pm)', y: 0.00 },{ label: '2019-09-17 (9:53 pm)', y: 0.00 },{ label: '2019-09-17 (9:53 pm)', y: 0.00 },{ label: '2019-09-17 (9:54 pm)', y: 0.00 },{ label: '2019-09-17 (9:54 pm)', y: 0.00 },{ label: '2019-09-17 (9:55 pm)', y: 0.00 },{ label: '2019-09-17 (9:55 pm)', y: 0.00 },{ label: '2019-09-17 (9:56 pm)', y: 0.00 },{ label: '2019-09-17 (9:56 pm)', y: 0.00 },{ label: '2019-09-17 (9:57 pm)', y: 0.00 },{ label: '2019-09-17 (9:57 pm)', y: 0.00 },{ label: '2019-09-17 (9:58 pm)', y: 0.00 },{ label: '2019-09-17 (9:58 pm)', y: 0.00 },{ label: '2019-09-17 (9:59 pm)', y: 0.00 },{ label: '2019-09-17 (9:59 pm)', y: 0.00 },{ label: '2019-09-17 (10:00 pm)', y: 0.00 },{ label: '2019-09-17 (10:01 pm)', y: 0.00 },{ label: '2019-09-17 (10:01 pm)', y: 0.00 },{ label: '2019-09-17 (10:02 pm)', y: 0.00 },{ label: '2019-09-17 (10:02 pm)', y: 0.00 },{ label: '2019-09-17 (10:03 pm)', y: 0.00 },{ label: '2019-09-17 (10:03 pm)', y: 0.00 },{ label: '2019-09-17 (10:04 pm)', y: 0.00 },{ label: '2019-09-17 (10:04 pm)', y: 0.00 },{ label: '2019-09-17 (10:05 pm)', y: 0.00 },{ label: '2019-09-17 (10:06 pm)', y: 0.00 },{ label: '2019-09-17 (10:06 pm)', y: 0.00 },{ label: '2019-09-17 (10:07 pm)', y: 0.00 },{ label: '2019-09-17 (10:07 pm)', y: 0.00 },{ label: '2019-09-17 (10:08 pm)', y: 0.00 },{ label: '2019-09-17 (10:08 pm)', y: 0.00 },{ label: '2019-09-17 (10:09 pm)', y: 0.00 },{ label: '2019-09-17 (10:10 pm)', y: 0.00 },{ label: '2019-09-17 (10:10 pm)', y: 0.00 },{ label: '2019-09-17 (10:11 pm)', y: 0.00 },{ label: '2019-09-17 (10:11 pm)', y: 0.00 },{ label: '2019-09-17 (10:12 pm)', y: 0.00 },{ label: '2019-09-17 (10:12 pm)', y: 0.00 },{ label: '2019-09-17 (10:13 pm)', y: 0.00 },{ label: '2019-09-17 (10:13 pm)', y: 0.00 },{ label: '2019-09-17 (10:14 pm)', y: 0.00 },{ label: '2019-09-17 (10:14 pm)', y: 0.00 },{ label: '2019-09-17 (10:15 pm)', y: 0.00 },{ label: '2019-09-17 (10:15 pm)', y: 0.00 },{ label: '2019-09-17 (10:16 pm)', y: 0.00 },{ label: '2019-09-17 (10:23 pm)', y: 218.50 },{ label: '2019-09-17 (10:23 pm)', y: 218.50 },{ label: '2019-09-17 (10:24 pm)', y: 437.00 },{ label: '2019-09-17 (10:24 pm)', y: 218.50 },{ label: '2019-09-17 (10:25 pm)', y: 437.00 },{ label: '2019-09-17 (10:25 pm)', y: 218.50 },{ label: '2019-09-17 (10:26 pm)', y: 218.50 },{ label: '2019-09-17 (10:26 pm)', y: 218.50 },{ label: '2019-09-17 (10:27 pm)', y: 0.00 },{ label: '2019-09-17 (10:27 pm)', y: 0.00 },{ label: '2019-09-17 (10:28 pm)', y: 0.00 },{ label: '2019-09-17 (10:28 pm)', y: 0.00 },{ label: '2019-09-17 (10:29 pm)', y: 0.00 },{ label: '2019-09-17 (10:29 pm)', y: 0.00 },{ label: '2019-09-17 (10:30 pm)', y: 0.00 },{ label: '2019-09-17 (10:30 pm)', y: 0.00 },{ label: '2019-09-17 (10:31 pm)', y: 0.00 },{ label: '2019-09-17 (10:36 pm)', y: 218.50 },{ label: '2019-09-17 (10:36 pm)', y: 218.50 },{ label: '2019-09-17 (10:37 pm)', y: 0.00 },{ label: '2019-09-17 (10:37 pm)', y: 0.00 },{ label: '2019-09-17 (10:38 pm)', y: 0.00 },{ label: '2019-09-17 (10:38 pm)', y: 0.00 },{ label: '2019-09-17 (10:39 pm)', y: 655.50 },{ label: '2019-09-17 (10:39 pm)', y: 655.50 },{ label: '2019-09-17 (10:40 pm)', y: 655.50 },{ label: '2019-09-17 (10:40 pm)', y: 655.50 },{ label: '2019-09-17 (10:41 pm)', y: 655.50 },{ label: '2019-09-17 (10:41 pm)', y: 218.50 },{ label: '2019-09-17 (10:42 pm)', y: 437.00 },{ label: '2019-09-17 (10:42 pm)', y: 437.00 },{ label: '2019-09-17 (10:43 pm)', y: 218.50 },{ label: '2019-09-17 (10:43 pm)', y: 218.50 },{ label: '2019-09-17 (10:44 pm)', y: 218.50 },{ label: '2019-09-17 (10:44 pm)', y: 218.50 },{ label: '2019-09-17 (10:45 pm)', y: 218.50 },{ label: '2019-09-17 (10:45 pm)', y: 218.50 },{ label: '2019-09-17 (10:46 pm)', y: 218.50 },{ label: '2019-09-17 (10:46 pm)', y: 218.50 },{ label: '2019-09-17 (10:47 pm)', y: 218.50 },{ label: '2019-09-17 (10:47 pm)', y: 218.50 },{ label: '2019-09-17 (10:48 pm)', y: 218.50 },{ label: '2019-09-17 (10:48 pm)', y: 218.50 },{ label: '2019-09-17 (10:49 pm)', y: 218.50 },{ label: '2019-09-17 (10:49 pm)', y: 218.50 },{ label: '2019-09-17 (10:50 pm)', y: 218.50 },{ label: '2019-09-17 (10:50 pm)', y: 218.50 },{ label: '2019-09-17 (10:51 pm)', y: 218.50 },{ label: '2019-09-17 (10:51 pm)', y: 218.50 },{ label: '2019-09-17 (10:52 pm)', y: 218.50 },{ label: '2019-09-17 (10:52 pm)', y: 218.50 },    ];



        dataSeries2.dataPoints = dataPoints2;
        dataSeries2.lineColor = "#d048b6";
        data2.push(dataSeries1);

        var options2 = {
            lineColor:"#d048b6",
            backgroundColor: "#27293d",
            zoomEnabled: true,
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Voltage Phase 3",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
            data: data2  // random data
        };


        chart.render();

        var chart0 = new CanvasJS.Chart("current_history_graph", options);
        chart0.render();

        var chart1 = new CanvasJS.Chart("voltage_history_graph", options1);
        chart1.render();

        var chart2 = new CanvasJS.Chart("power_history_graph", options2);
        chart2.render();

        //END OF THREE CHARTS




        //Three graphs of temperature

        var temp_graph_1 = new CanvasJS.Chart("temp_graph_1", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Temperature  1",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
                lineColor : "#c0504e",
                type: "spline",
                dataPoints: [
                    { y: 450, color: "#c0504e" },
                    { y: 414, color: "#c0504e" },
                    { y: 520, color: "#c0504e"  },
                    { y: 460, color: "#c0504e"  },
                    { y: 450, color: "#c0504e"  },
                    { y: 500, color: "#c0504e"  },
                    { y: 480, color: "#c0504e"  },
                    { y: 480, color: "#c0504e"  },
                    { y: 410, color: "#c0504e"  },
                    { y: 500, color: "#c0504e"  },
                    { y: 480, color: "#c0504e"  },
                    { y: 510, color: "#c0504e"  }
                ]
            }]
        });
        var temp_graph_2 = new CanvasJS.Chart("temp_graph_2", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Temperature  2",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
                lineColor : "#4f81bc",
                type: "spline",
                dataPoints: [
                    { y: 450, color: "#4f81bc"   },
                    { y: 414, color: "#4f81bc"   },
                    { y: 520, color: "#4f81bc"    },
                    { y: 460, color: "#4f81bc"    },
                    { y: 450, color: "#4f81bc"    },
                    { y: 500, color: "#4f81bc"    },
                    { y: 480, color: "#4f81bc"    },
                    { y: 480, color: "#4f81bc"    },
                    { y: 410, color: "#4f81bc"    },
                    { y: 500, color: "#4f81bc"    },
                    { y: 480, color: "#4f81bc"    },
                    { y: 510, color: "#4f81bc"    }
                ]
            }]
        });
        var temp_graph_3 = new CanvasJS.Chart("temp_graph_3", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Temperature  3",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
                lineColor : "#9bbb58",
                type: "spline",
                dataPoints: [
                    { y: 450, color: "#9bbb58"  },
                    { y: 414, color: "#9bbb58"   },
                    { y: 520, color: "#9bbb58"   },
                    { y: 460, color: "#9bbb58"   },
                    { y: 450, color: "#9bbb58"   },
                    { y: 500, color: "#9bbb58"   },
                    { y: 480, color: "#9bbb58"   },
                    { y: 480, color: "#9bbb58"   },
                    { y: 410, color: "#9bbb58"   },
                    { y: 500, color: "#9bbb58"   },
                    { y: 480, color: "#9bbb58"   },
                    { y: 510, color: "#9bbb58"   }
                ]
            }]
        });
        temp_graph_1.render();
        temp_graph_2.render();
        temp_graph_3.render();
///////////////////////////////////////////////////////////////////////////////////////////////////////////



        //THree power charts at the end

        var chart_power_1 = new CanvasJS.Chart("power_graph_1", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Power Phase 1",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
                lineColor : "#9bbb58",
                type: "spline",
                dataPoints: [
                    { y: 450, color: "#9bbb58"  },
                    { y: 414, color: "#9bbb58"   },
                    { y: 520, color: "#9bbb58"   },
                    { y: 460, color: "#9bbb58"   },
                    { y: 450, color: "#9bbb58"   },
                    { y: 500, color: "#9bbb58"   },
                    { y: 480, color: "#9bbb58"   },
                    { y: 480, color: "#9bbb58"   },
                    { y: 410, color: "#9bbb58"   },
                    { y: 500, color: "#9bbb58"   },
                    { y: 480, color: "#9bbb58"   },
                    { y: 510, color: "#9bbb58"   }
                ]
            }]
        });
        var chart_power_2 = new CanvasJS.Chart("power_graph_2", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Power Phase 2",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
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
                lineColor : "#c0504e",
                type: "spline",
                dataPoints: [
                    { y: 450, color: "#c0504e" },
                    { y: 414, color: "#c0504e" },
                    { y: 520, color: "#c0504e"  },
                    { y: 460, color: "#c0504e"  },
                    { y: 450, color: "#c0504e"  },
                    { y: 500, color: "#c0504e"  },
                    { y: 480, color: "#c0504e"  },
                    { y: 480, color: "#c0504e"  },
                    { y: 410, color: "#c0504e"  },
                    { y: 500, color: "#c0504e"  },
                    { y: 480, color: "#c0504e"  },
                    { y: 510, color: "#c0504e"  }
                ]
            }]
        });
        <?php
            require 'modules/db.php';
        $sql = "SELECT * FROM recorded_values1# Where mac='3C:71:BF:8C:08:74'";
        //echo $sql;
        $res = mysqli_query($con, $sql);
        ?>
        var chart_power_3 = new CanvasJS.Chart("power_graph_3", {
            zoomEnabled: true,
            backgroundColor: "#27293d",
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Power Phase 3",
                fontColor: "#d2d2c9",
                fontWeight: "normal"
            },
            axisY: {
                includeZero: false,
                lineThickness: 1,
                labelFontColor: "#d2d2c9",
                gridColor: "#ffffff1f"
            },
            axisX: {
                labelFontColor: "#d2d2c9",
                labelAngle: -90/90,
                labelWrap: true
            },
            data: [{
                lineColor : "#4f81bc",
                type: "line",
                dataPoints : [
                    <?php
                    while($row=mysqli_fetch_assoc($res)){
                        $time_24 = explode(':', date("H:i", strtotime($row["time_now"])));
//                        echo $time_24[0].'__'.$time_24[1];
                        $a = str_replace("-",",",$row["date_now"]);
                        /*
                        echo $a;*/
                        //echo "{ label: '".$row["date_now"]." (".$row['time_now'].")', y: ".$row['current_values'].",  color: '#4f81bc' },";
                        echo "{ x: new Date(".$a.",".$time_24[0].",".$time_24[1].",0), y: ".$row['current_values'].",  color: '#4f81bc' },";
                    }
                    ?>
                ]
            }]
        });
        chart_power_1.render();
        chart_power_2.render();
        chart_power_3.render();




















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