<?php
    require 'modules/app.php';
    $page_identifier = "./";
    $title = "Login Page";
?>
<!doctype html>
<html lang="en">
<head>
    <?php require 'modules/head.php'; ?>
</head>
    <body>

    <div class="container d-flex mt-15">
        <div class="row align-self-center w-100">
            <div class="col-sm-10 col-md-6 col-lg-6 mx-auto">
                <div class="mycard">
                    <div id="mycard-header">
                        <div class="container">
                            <div class="text-center">
                                <img class="img-thumbnail" src="assets/images/logo.jpg">
                                <img class="img-thumbnail ml-3" src="assets/images/bgard.png" style="height: 56px;width: 151px;">
                            </div>
                        </div>
                        <p class="display-4 text-white text-center font-size-35px">Welcome Back!</p>
                        <?php
                            if(isset($_GET["err"])){
                                switch ($_GET["err"]){
                                    case 'SessionOut':
                                        echo '
                                                <div class="alert alert-danger">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <strong>Error!</strong> Please Login again to access dashboard!
                                                </div>
                                            ';
                                        break;
                                    case 'incorrect':
                                        echo '
                                                <div class="alert alert-danger">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <strong>Error!</strong> Incorrect User Credentials!
                                                </div>
                                            ';
                                        break;
                                }
                            }
                            if(isset($_GET["success"])){
                                switch ($_GET["success"]){
                                    case 'loggedOut':
                                        echo '
                                                <div class="alert alert-info">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <strong>Info: </strong> Logged Out Successfully!
                                                </div>
                                            ';
                                        break;
                                }
                            }
                        ?>
                    </div>
                    <div class="mycard-body col-md-11 mx-auto">
                        <form action="" method="post">
                            <div class="input-group mb-2">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-at"></i>
                            </span>
                                <input type="email" name="email" class="form-control " placeholder="Email Address" required>
                            </div>
                            <div class="input-group mb-3">
                            <span class="input-group-text text-secondary">
                                <i class="fas fa-lock"></i>
                            </span>
                                <input type="password" name="pass" class="form-control " placeholder="Password" required>
                            </div>

                            <button name="login-btn" type="submit" class="btn btn-block btn-danger" id="login-animation" style="max-height: 38px;">
                                Sign In
                            </button>
                        </form>
                    </div>
                    <div class="mycard-footer mt-4 pb-2">
                        <a class="float-right text-white" href="#">Forgot Your Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'modules/footer.php'; ?>
        <script>
            //Login Button Animation
            $('#login-animation').click(function(){
                var $this = $(this);
                $this.text('Logging In....');
            });
        </script>
    </body>

</html>


<?php
    if(isset($_POST["login-btn"])){
        require 'modules/classes/class.users.php';
        $user = new Users();
        $user_email = $_POST["email"];
        $user_password = $_POST["pass"];
        //echo '<script>alert("'.$user_password.'");</script>';
        $user_details = $user->logIn($user_email, $user_password);
        //print_r($user_details);
        if($user_details){
            $is_admin = $user_details[0]['is_admin'];
            $_SESSION["status"]="alive@123";
            $_SESSION["id"] = $user_details[0]['id'];
            $_SESSION["username"] = $user_details[0]['username'];
            $_SESSION["email"] = $user_details[0]['email'];
            $_SESSION["is_admin"] = $is_admin;
            if($is_admin){
                js_redirect('admin_dashboard.php');
            }if(!$is_admin){
                js_redirect('user_dashboard.php');
            }
        }else{
            header('Location: index.php?err=incorrect');
        }

    }
?>