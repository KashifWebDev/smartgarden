<?php
    $page_identifier = "./";
    $title = "Home Page";
    require 'modules/app.php';
    require 'modules/db.php';
$page_link = secure_parameter($_POST["page_link"]);
$start_date = secure_parameter($_POST["range1"]);
$end_date = secure_parameter($_POST["range2"]);
$chart_heading = $_POST["chart_heading"];
$chart_type = $_POST["chart_type"];
$mac = secure_parameter($_POST["mac"]);


$column_name = secure_parameter($_POST["col_name"]);
if($column_name=="Curr1")
    $chart_heading = "Current 1";
if($column_name=="Curr2")
    $chart_heading = "Current 2";
if($column_name=="Curr3")
    $chart_heading = "Current 3";
if($column_name=="Vlt1")
    $chart_heading = "Voltage 1";
if($column_name=="Vlt2")
    $chart_heading = "Voltage 2";
if($column_name=="Vlt3")
    $chart_heading = "Voltage 3";
if($column_name=="Tmp1")
    $chart_heading = "Temperature 1";
if($column_name=="Tmp2")
    $chart_heading = "Temperature 2";
if($column_name=="Tmp3")
    $chart_heading = "Temperature 3";
if($column_name=="pow1")
    $chart_heading = "Power 1";
if($column_name=="pow2")
    $chart_heading = "Power 2";
if($column_name=="pow3")
    $chart_heading = "Power 3";
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
                <form class="ml-auto" action="modules/download.php" method="post">
                    <input type="hidden" name="range1" value="<?php echo $start_date; ?>">
                    <input type="hidden" name="range2" value="<?php echo $end_date; ?>">
                    <input type="hidden" name="chart_heading" value="<?php echo $chart_heading; ?>">
                    <input type="hidden" name="chart_type" value="<?php echo $chart_type; ?>">
                    <input type="hidden" name="column_name" value="<?php echo $column_name; ?>">
                    <button name="download" type="submit" class="btn btn-info">Download Data</button>
                </form>
            </div>
            <div id="graph_1"></div>
        </div>
        <div class="spacer1">

            <div class="text-center">
                <form action="chart_filter1.php" method="post" id="select_chart">
                    <input type="hidden" name="page_link" value="<?php echo $page_link; ?>">
                    <input type="hidden" name="range1" value="<?php echo $start_date; ?>">
                    <input type="hidden" name="range2" value="<?php echo $end_date; ?>">
                    <input type="hidden" name="chart_heading1" value="<?php echo $chart_heading; ?>">
                    <input type="hidden" name="column_name1" value="<?php echo $column_name; ?>">
                    <input type="hidden" name="mac" value="<?php echo $mac; ?>">
                    <p>Add Second Variable: </p>
                    <select onchange="DoSubmit()" name="column_name2" class="mx-2 form-control mx-auto" style="width: auto;" id="select_chart">
                        <option>Select Graph</option>
                        <option value="Curr1">Current 1</option>
                        <option value="Curr2">Current 2</option>
                        <option value="Curr3">Current 3</option>
                        <option value="Vlt1">Voltage 1</option>
                        <option value="Vlt2">Voltage 2</option>
                        <option value="Vlt3">Voltage 3</option>
                        <option value="Tmp1">Temperature 1</option>
                        <option value="Tmp2">Temperature 2</option>
                        <option value="Tmp3">Temperature 3</option>
                        <option value="pow1">Power 1</option>
                        <option value="pow2">Power 2</option>
                        <option value="pow3">Power 3</option>
                    </select>
                </form>
            </div>
            <script>
                function DoSubmit(){
                    document.getElementById("select_chart").submit();
                }
            </script>
            <?php
            if(isset($_POST["new_variable"])){
                $a = secure_parameter($_POST["new_variable"]);
                echo $a;
                die();
            }
            ?>

            <?php require 'modules/footer.php'; ?>
        </div>
    </body>

</html>


<script>
    window.onload = function () {



        <?php
        $sql = "SELECT * FROM api_data WHERE (date_now BETWEEN '$start_date' AND '$end_date' AND machine_mac='$mac')";
//        echo $sql;
        $res = mysqli_query($con, $sql);
        ?>
//tHREE chARTS

        var limit =  <?php echo mysqli_num_rows($res); ?>;
        var y = 100;
        var data = [];
        var dataSeries = { type: "spline" };
        var    dataPoints= [
            <?php
            while($row=mysqli_fetch_assoc($res)){
                $time = get_time($row["date_now"]);
                $date = get_date($row["date_now"]);
                echo "{ label: '".$date." (".$time.")', y: ".$row[$column_name].",  color: '#d048b6' },";
            }
            ?>
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
                text: "<?php echo $chart_heading; ?>",
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
            data: data  // random data
        };



        var chart = new CanvasJS.Chart("graph_1", options);
        chart.render();




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