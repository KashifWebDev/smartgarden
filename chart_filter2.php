<?php
    $page_identifier = "./";
    $title = "Home Page";
    require 'modules/app.php';
    require 'modules/db.php';
$page_link = secure_parameter($_POST["page_link"]);
$start_date = secure_parameter($_POST["range1"]);
$end_date = secure_parameter($_POST["range2"]);
$chart_heading1 = $_POST["chart_heading1"];
$chart_heading2 = $_POST["chart_heading2"];
$column_name1 = $_POST["column_name1"];
$column_name2 = $_POST["column_name2"];
$column_name3 = $_POST["column_name3"];
$mac = secure_parameter($_POST["mac"]);



if($column_name3=="Vlt1"){
    $chart_heading3 = "Voltage 1";
}
if($column_name3=="Vlt2"){
    $chart_heading3 = "Voltage 2";
}
if($column_name3=="Vlt3"){
    $chart_heading3 = "Voltage 3";
}
if($column_name3=="Tmp1"){
    $chart_heading3 = "Tmperature 1";
}
if($column_name3=="Tmp2"){
    $chart_heading3 = "Tmperature 2";
}
if($column_name3=="Tmp3"){
    $chart_heading3 = "Tmperature 3";
}
if($column_name3=="pow1"){
    $chart_heading3 = "Power 1";
}
if($column_name3=="pow2"){
    $chart_heading3 = "Power 2";
}
if($column_name3=="pow3"){
    $chart_heading3 = "Power 3";
}
if($column_name3=="Curr1"){
    $chart_heading3 = "Current 1";
}
if($column_name3=="Curr2"){
    $chart_heading3 = "Current 2";
}
if($column_name3=="Curr3"){
    $chart_heading3 = "Current 3";
}
?>
<!doctype html>
<html lang="en">
<head>
    <?php require 'modules/head.php'; ?>
</head>
    <body>
        <?php require 'modules/navbar.php'; ?>

        <div class="graph_plot pl-4 pr-4 mt-5">
            <div class="container mb-4 timing_headings d-flex">
                <p class="font-family-josefin font-size-large mr-5">
                    <a href="<?php echo $page_link; ?>" class="text-white">
                        <i class="fas fa-chevron-left mr-2"></i>Back To Dashboard
                    </a>
                </p>
                <p class="heading font-family-josefin font-size-large mr-2">Start Date: </p>
                <p class="date text-muted"><?php echo date("d M,Y", strtotime($start_date)); ?></p>
                <p class="heading font-family-josefin font-size-large mr-2 ml-5">End Date: </p>
                <p class="date text-muted"><?php echo date("d M,Y", strtotime($end_date)); ?></p>
<!--                <form class="ml-auto" action="modules/download.php" method="post">-->
<!--                    <input type="hidden" name="range1" value="--><?php //echo $start_date; ?><!--">-->
<!--                    <input type="hidden" name="range2" value="--><?php //echo $end_date; ?><!--">-->
<!--                    <input type="hidden" name="chart_heading" value="--><?php //echo $chart_heading; ?><!--">-->
<!--                    <input type="hidden" name="chart_type" value="--><?php //echo $chart_type; ?><!--">-->
<!--                    <input type="hidden" name="column_name" value="--><?php //echo $column_name; ?><!--">-->
<!--                    <button name="download" type="submit" class="btn btn-info">Download Data</button>-->
<!--                </form>-->
            </div>
            <div id="three_current_phases"></div>
        </div>
        <div class="spacer1">

            <?php require 'modules/footer.php'; ?>
        </div>
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
                text: "<?php echo $chart_heading1.' / '.$chart_heading2.' / '.$chart_heading3; ?>",
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
                name: "<?php echo $chart_heading1; ?>",
                type: "spline",
                showInLegend: true,
                dataPoints: [
                    <?php
                    require 'modules/db.php';
                    $sql = "SELECT * FROM api_data WHERE machine_mac='".$mac."'";
                    //                echo $sql;
                    $res = mysqli_query($con, $sql);
                    while($row=mysqli_fetch_assoc($res)){
                        $time = get_time($row["date_now"]);
                        $date = get_date($row["date_now"]);
                        echo "{ label: '".$date." (".$time.")', y: ".$row[$column_name1]."}, ";
                    }
                    ?>
                ]
            },
                {
                    name: "<?php echo $chart_heading2; ?>",
                    type: "spline",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$mac."'";
                        //                echo $sql;
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "{ label: '".$date." (".$time.")', y: ".$row[$column_name2]."}, ";
                        }
                        ?>
                    ]
                },
                {
                    name: "<?php echo $chart_heading3; ?>",
                    type: "spline",
                    showInLegend: true,
                    dataPoints: [
                        <?php
                        require 'modules/db.php';
                        $sql = "SELECT * FROM api_data WHERE machine_mac='".$mac."'";
                        //                echo $sql;
                        $res = mysqli_query($con, $sql);
                        while($row=mysqli_fetch_assoc($res)){
                            $time = get_time($row["date_now"]);
                            $date = get_date($row["date_now"]);
                            echo "{ label: '".$date." (".$time.")', y: ".$row[$column_name3]."}, ";
                        }
                        ?>
                    ]
                }
                ]
        });




//tHREE  Voltage chARTS

        var limit = 5000;
        var y = 100;
        var data = [];
        var dataSeries = { type: "spline" };
        var    dataPoints= [
            { label: '2019-12-12 (11:47 pm)', y: 468,  color: '#d048b6'}, { label: '2019-12-12 (11:46 pm)', y: 424,  color: '#d048b6'}, { label: '2019-12-12 (11:44 pm)', y: 476,  color: '#d048b6'}, { label: '2019-12-12 (11:43 pm)', y: 397,  color: '#d048b6'}, { label: '2019-12-12 (11:42 pm)', y: 395,  color: '#d048b6'}, { label: '2019-12-12 (11:41 pm)', y: 421,  color: '#d048b6'}, { label: '2019-12-12 (11:40 pm)', y: 385,  color: '#d048b6'}, { label: '2019-12-12 (11:39 pm)', y: 435,  color: '#d048b6'}, { label: '2019-12-12 (11:38 pm)', y: 370,  color: '#d048b6'}, { label: '2019-12-12 (11:37 pm)', y: 357,  color: '#d048b6'}, { label: '2019-12-12 (11:36 pm)', y: 463,  color: '#d048b6'}, { label: '2019-12-12 (11:35 pm)', y: 352,  color: '#d048b6'}, { label: '2019-12-12 (11:34 pm)', y: 366,  color: '#d048b6'}, { label: '2019-12-12 (11:33 pm)', y: 341,  color: '#d048b6'}, { label: '2019-12-12 (11:32 pm)', y: 397,  color: '#d048b6'}, { label: '2019-12-12 (11:31 pm)', y: 395,  color: '#d048b6'}, { label: '2019-12-12 (11:30 pm)', y: 421,  color: '#d048b6'}, { label: '2019-12-12 (11:29 pm)', y: 385,  color: '#d048b6'}, { label: '2019-12-12 (11:28 pm)', y: 435,  color: '#d048b6'}, { label: '2019-12-12 (11:27 pm)', y: 370,  color: '#d048b6'}, { label: '2019-12-12 (11:26 pm)', y: 357,  color: '#d048b6'}, { label: '2019-12-12 (11:25 pm)', y: 463,  color: '#d048b6'}, { label: '2019-12-12 (11:24 pm)', y: 352,  color: '#d048b6'}, { label: '2019-12-12 (11:23 pm)', y: 366,  color: '#d048b6'}, { label: '2019-12-12 (11:22 pm)', y: 341,  color: '#d048b6'}, { label: '2019-12-12 (11:21 pm)', y: 315,  color: '#d048b6'}, { label: '2019-12-12 (11:20 pm)', y: 372,  color: '#d048b6'}, { label: '2019-12-12 (11:19 pm)', y: 316,  color: '#d048b6'}, { label: '2019-12-12 (11:18 pm)', y: 385,  color: '#d048b6'}, { label: '2019-12-12 (11:17 pm)', y: 341,  color: '#d048b6'},
        ];


        dataSeries.dataPoints = dataPoints;
        dataSeries.lineColor = "#d048b6";
        data.push(dataSeries);


        var options = {
            backgroundColor: "#27293d",
            zoomEnabled: true,
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Voltage Phase 1 (V)",
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

//VOLTAGE2 CHART
        var limit1 = 291;
        var y = 100;
        var data1 = [];
        var dataSeries1 = { type: "spline" };
        var    dataPoints1= [
            { label: '2019-12-12 (11:47 pm)', y: 469,  color: '#d048b6'}, { label: '2019-12-12 (11:46 pm)', y: 431,  color: '#d048b6'}, { label: '2019-12-12 (11:44 pm)', y: 405,  color: '#d048b6'}, { label: '2019-12-12 (11:43 pm)', y: 425,  color: '#d048b6'}, { label: '2019-12-12 (11:42 pm)', y: 393,  color: '#d048b6'}, { label: '2019-12-12 (11:41 pm)', y: 462,  color: '#d048b6'}, { label: '2019-12-12 (11:40 pm)', y: 366,  color: '#d048b6'}, { label: '2019-12-12 (11:39 pm)', y: 331,  color: '#d048b6'}, { label: '2019-12-12 (11:38 pm)', y: 329,  color: '#d048b6'}, { label: '2019-12-12 (11:37 pm)', y: 364,  color: '#d048b6'}, { label: '2019-12-12 (11:36 pm)', y: 390,  color: '#d048b6'}, { label: '2019-12-12 (11:35 pm)', y: 386,  color: '#d048b6'}, { label: '2019-12-12 (11:34 pm)', y: 390,  color: '#d048b6'}, { label: '2019-12-12 (11:33 pm)', y: 451,  color: '#d048b6'}, { label: '2019-12-12 (11:32 pm)', y: 425,  color: '#d048b6'}, { label: '2019-12-12 (11:31 pm)', y: 393,  color: '#d048b6'}, { label: '2019-12-12 (11:30 pm)', y: 462,  color: '#d048b6'}, { label: '2019-12-12 (11:29 pm)', y: 366,  color: '#d048b6'}, { label: '2019-12-12 (11:28 pm)', y: 331,  color: '#d048b6'}, { label: '2019-12-12 (11:27 pm)', y: 329,  color: '#d048b6'}, { label: '2019-12-12 (11:26 pm)', y: 364,  color: '#d048b6'}, { label: '2019-12-12 (11:25 pm)', y: 390,  color: '#d048b6'}, { label: '2019-12-12 (11:24 pm)', y: 386,  color: '#d048b6'}, { label: '2019-12-12 (11:23 pm)', y: 390,  color: '#d048b6'}, { label: '2019-12-12 (11:22 pm)', y: 451,  color: '#d048b6'}, { label: '2019-12-12 (11:21 pm)', y: 348,  color: '#d048b6'}, { label: '2019-12-12 (11:20 pm)', y: 467,  color: '#d048b6'}, { label: '2019-12-12 (11:19 pm)', y: 347,  color: '#d048b6'}, { label: '2019-12-12 (11:18 pm)', y: 366,  color: '#d048b6'}, { label: '2019-12-12 (11:17 pm)', y: 451,  color: '#d048b6'},             ];


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
                text: "Voltage Phase 2 (V)",
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

//FOR Voltage3 CHART
        var limit2 = 291;
        var y = 100;
        var data2 = [];
        var dataSeries2 = { type: "spline" };
        var    dataPoints2= [
            { label: '2019-12-12 (11:47 pm)', y: 368,  color: '#d048b6'}, { label: '2019-12-12 (11:46 pm)', y: 304,  color: '#d048b6'}, { label: '2019-12-12 (11:44 pm)', y: 402,  color: '#d048b6'}, { label: '2019-12-12 (11:43 pm)', y: 373,  color: '#d048b6'}, { label: '2019-12-12 (11:42 pm)', y: 336,  color: '#d048b6'}, { label: '2019-12-12 (11:41 pm)', y: 416,  color: '#d048b6'}, { label: '2019-12-12 (11:40 pm)', y: 458,  color: '#d048b6'}, { label: '2019-12-12 (11:39 pm)', y: 407,  color: '#d048b6'}, { label: '2019-12-12 (11:38 pm)', y: 333,  color: '#d048b6'}, { label: '2019-12-12 (11:37 pm)', y: 364,  color: '#d048b6'}, { label: '2019-12-12 (11:36 pm)', y: 333,  color: '#d048b6'}, { label: '2019-12-12 (11:35 pm)', y: 448,  color: '#d048b6'}, { label: '2019-12-12 (11:34 pm)', y: 447,  color: '#d048b6'}, { label: '2019-12-12 (11:33 pm)', y: 358,  color: '#d048b6'}, { label: '2019-12-12 (11:32 pm)', y: 373,  color: '#d048b6'}, { label: '2019-12-12 (11:31 pm)', y: 336,  color: '#d048b6'}, { label: '2019-12-12 (11:30 pm)', y: 416,  color: '#d048b6'}, { label: '2019-12-12 (11:29 pm)', y: 458,  color: '#d048b6'}, { label: '2019-12-12 (11:28 pm)', y: 407,  color: '#d048b6'}, { label: '2019-12-12 (11:27 pm)', y: 333,  color: '#d048b6'}, { label: '2019-12-12 (11:26 pm)', y: 364,  color: '#d048b6'}, { label: '2019-12-12 (11:25 pm)', y: 333,  color: '#d048b6'}, { label: '2019-12-12 (11:24 pm)', y: 448,  color: '#d048b6'}, { label: '2019-12-12 (11:23 pm)', y: 447,  color: '#d048b6'}, { label: '2019-12-12 (11:22 pm)', y: 358,  color: '#d048b6'}, { label: '2019-12-12 (11:21 pm)', y: 332,  color: '#d048b6'}, { label: '2019-12-12 (11:20 pm)', y: 317,  color: '#d048b6'}, { label: '2019-12-12 (11:19 pm)', y: 310,  color: '#d048b6'}, { label: '2019-12-12 (11:18 pm)', y: 458,  color: '#d048b6'}, { label: '2019-12-12 (11:17 pm)', y: 358,  color: '#d048b6'},             ];


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
                text: "Voltage Phase 3 (V)",
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

/////////////////////////////End Of Temp Graphs/////////////////////////////////////////////////////





















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