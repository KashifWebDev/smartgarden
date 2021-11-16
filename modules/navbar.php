<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-custom static-top custom-navbar">
    <div class="container-fluid">
        <?php
        if($_SESSION["is_admin"]){
            $dashboard_link = "admin_dashboard.php";
        }else{
            $dashboard_link = "user_dashboard.php";
        }
        ?>
        <a class="navbar-brand" href="<?php  echo $dashboard_link; ?>">
            <p class="nav_font m-0 font-size-larger">Smart Garden</p>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto ml-4">
                <li class="nav-item <?php if($title == "Dashbaord") echo "active"; ?>">
                    <a class="nav-link" href="<?php echo $dashboard_link; ?>">Home
                    </a>
                </li>
<!--                --><?php //if($_SESSION["is_admin"]){ ?>
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="" data-toggle="modal" data-target="#add_device">Add Device</a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a class="nav-link" href="" data-toggle="modal" data-target="#add_user">Add User</a>-->
<!--                    </li>-->
<!--                --><?php //} ?>
                <li class="nav-item">
                    <a class="nav-link" href="" data-toggle="modal" data-target="#change_password">Change Password</a>
                </li>
<!--                <li class="nav-item">-->
<!--                    <a class="nav-link" href="modules/logout.php">Logout</a>-->
<!--                </li>-->
            </ul>
            <ul class="navbar-nav ml-5">
                <li class="nav-item d-flex">
                    <span>
                        <i class="fa fa-user text-white" aria-hidden="true"></i>
                        <?php echo $_SESSION["username"]; ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php if($_SESSION["is_admin"]){  //Inserting new device  ?>
    <!-- Change Add Device Modal -->
    <div class="modal" id="add_device">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header bg-modal-header border-bottom-red">
                        <h4 class="modal-title">Add New Device</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body bg-modal-body text-white">
                        <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-font"></i>
                            </span>
                            <input type="text" name="device_name" class="form-control " placeholder="Device Name" required>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-laptop-code"></i>
                            </span>
                            <input type="text" name="device_mac" class="form-control " placeholder="Device MAC Address" required>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-search-location"></i>
                            </span>
                            <input type="text" name="location" class="form-control" placeholder="Device Location" required>
                        </div>
                        <select class="form-control p-1" name="user_id">
                            <option>-- Link User --</option>
                            <?php
                            require 'modules/db.php';
                            $sql = "SELECT * FROM users WHERE is_admin=0";
                            $res = mysqli_query($con, $sql);
                            while ($row = mysqli_fetch_array($res)){
                                echo '
                                    <option value="'.$row["id"].'">'.$row["username"].' ('.$row["email"].')</option>
                                ';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-modal-header text-white border-top-red">
                        <button class="w-50 btn btn-success" type="submit" name="add_device">Add</button>
                        <button type="button" class="w-50 btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Change Password Date Modal -->
    <div class="modal" id="add_user">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header bg-modal-header border-bottom-red">
                        <h4 class="modal-title">Add New User</h4>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body bg-modal-body text-white">
                        <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-font"></i>
                            </span>
                            <input type="text" name="name" class="form-control " placeholder="Full Name" required>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-at"></i>
                            </span>
                            <input type="email" name="email" class="form-control " placeholder="Email Address" required>
                        </div>
                        <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-modal-header text-white border-top-red">
                        <button class="w-50 btn btn-success" type="submit" name="add_user">Add</button>
                        <button type="button" class="w-50 btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php }
    if(isset($_POST["add_device"])){
        $u_id = secure_parameter($_POST["user_id"]);
        $device_name = secure_parameter($_POST["device_name"]);
        $device_mac = secure_parameter($_POST["device_mac"]);
        $location = secure_parameter($_POST["location"]);
        require 'modules/classes/class.users.php';
        $add_device_obj = new Users();
        if($add_device_obj->add_device($u_id, $device_name, $device_mac, $location)){
            require 'modules/classes/class.logger.php';
            $device_add_log = new logger();
            $device_add_log->device_added($device_name, 1);
            js_alert("Device Added Successfully");
            js_redirect("admin_dashboard.php");
        }else{
            js_alert("Error Occrued while adding device!");
        }
    }
    if(isset($_POST["add_user"])){
        $name = secure_parameter($_POST["name"]);
        $email = secure_parameter($_POST["email"]);
        $password = secure_parameter($_POST["password"]);
        require 'modules/classes/class.users.php';
        $add_device_obj = new Users();
        if($add_device_obj->add_user($name, $email, $password)){
            require 'modules/classes/class.logger.php';
            $user_add_log = new logger();
            $user_add_log->user_added($name, 6);
            js_alert("User Added Successfully");
            js_redirect("admin_dashboard.php");
        }else{
            js_alert("Error Occrued while adding User!");
        }
    }
?>

        <!-- Change Password Date Modal -->
        <div class="modal" id="change_password">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="" method="post">
                        <!-- Modal Header -->
                        <div class="modal-header bg-modal-header border-bottom-red">
                            <h4 class="modal-title">Change Passwowrd</h4>
                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body bg-modal-body text-white">
                            <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-lock"></i>
                            </span>
                                <input type="password" name="pass" class="form-control " placeholder="Enter New Password" required>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer bg-modal-header text-white border-top-red">
                            <button class="w-50 btn btn-success" type="submit" name="submit-pass">Update</button>
                            <button type="button" class="w-50 btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
if(isset($_POST["submit-pass"])){
    require 'modules/classes/class.users.php';
    $pass_object = new Users();
    $uid = $_SESSION["id"];
    $user_password = secure_parameter(["pass"]);
    if($pass_object->change_pass($user_password, $uid)){
        js_alert("Password Changed!");
    }else{
        js_alert("Error Occurred while changing password!");
    }
}
?>