                        <div class="container">
                            <form class="d-flex filter_form" action="chart_filter.php" method="post">
<!--                                <p class="mr-2">From</p>-->
                                <input type="date" name="range1" required>
<!--                                <p class="ml-3 mr-2">To</p>-->
                                <input type="date" name="range2" required>
                                <input type="hidden" name="chart_type" value="<?php echo $chart_type; ?>">
                                <input type="hidden" name="chart_heading" value="<?php echo $heading; ?>">
                                <input type="hidden" name="mac" value="<?php echo $device_mac_address; ?>">
                                <input type="hidden" name="page_link" value="<?php echo $actual_link; ?>">
                                <input type="submit" name="<?php echo $sub; ?>" value="Search" class="btn custom-btn-2">
                            </form>
                        </div>