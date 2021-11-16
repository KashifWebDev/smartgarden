<?php
/*
	$servername = "server127.web-hosting.com";
	$username = "turkvjwp_fingerprinttest";
	$password = "fingerprinttest";
	$dbname = "turkvjwp_zenit";
*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_smartgarden";



	$con = mysqli_connect($servername, $username, $password, $dbname);
	if(!$con){ ?>
		
				<div class="container error_con">
                    <div class="alert alert-danger">
					  <center><b>*****!! DATABASE CONNECTION FALIED !!*****</b><hr>
					  <strong>Error!</strong> There's a problem connecting with database. <a href="#">Report to Fix. </a>Sorry for inconvenient.</center>
					</div>
				</div>
	<?php
			 }
	?>
