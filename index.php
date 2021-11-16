<?php
require 'modules/app.php';
$page_identifier = "./";
$title = "Login Page";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V15</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/css/garden.css">
	<?php require 'modules/head.php'; ?>

	<!--===============================================================================================-->
</head>
<body>

<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-form-title" style="background-image: url(assets/images/bg-02.jpg);">
					<span class="login100-form-title-1">
						Smart Garden
					</span>
			</div>

			<form class="login100-form validate-form" method="post" action="">
				<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
					<span class="label-input100">Username</span>
					<input class="input100" type="text" name="email" placeholder="Enter username">
					<span class="focus-input100"></span>
				</div>

				<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
					<span class="label-input100">Password</span>
					<input class="input100" type="password" name="pass" placeholder="Enter password">
					<span class="focus-input100"></span>
				</div>

				<div class="flex-sb-m w-full p-b-30">
					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>

					<div>
						<a href="#" class="txt1">
							Forgot Password?
						</a>
					</div>
				</div>

				<div class="container-login100-form-btn">
					<input name="submit" class="login100-form-btn" type="submit">
				</div>
			</form>
		</div>
	</div>
</div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="assets/js/main.js"></script>

</body>
</html>

<?php
if(isset($_POST["submit"])){
    require 'modules/classes/class.users.php';
    $user = new Users();
    $user_email = $_POST["email"];
    $user_password = $_POST["pass"];
    //echo '<script>alert("'.$user_password.'");</script>';
    $user_details = $user->logIn($user_email, $user_password);
//    print_r($user_details);die();exit();
    if($user_details){
        $is_admin = $user_details[0]['is_admin'];
        $_SESSION["status"]="alive@123";
        $_SESSION["id"] = $user_details[0]['id'];
        $_SESSION["username"] = $user_details[0]['username'];
        $_SESSION["email"] = $user_details[0]['email'];
        $_SESSION["is_admin"] = $is_admin;
//        js_alert('here');exit();
        if($is_admin){
            js_redirect('admin_dashboard.php');
        }if(!$is_admin){
            js_redirect('user_dashboard.php');
        }
    }else{
        js_alert('Invalid Username/Password!');
    }

}
?>