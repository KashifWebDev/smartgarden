<?php
    session_start();
    error_reporting(E_ALL);
    $project_path = "http://localhost/smartgarden/";
//    $project_path = "http://turktronics.com/zenit/";

    ///FUNCTIONS
function site_logo(){
    return  $GLOBALS["project_path"].'assets/images/logo.jpg';
}

function secure_parameter($parm){
    $parm = trim($parm);
    //$parm = mysqli_real_escape_string($parm);
    $parm = htmlentities($parm);
    $parm = strip_tags($parm);
    return $parm;
}

function check_session(){
    if(!isset($_SESSION['status'])){
        header("Location: ".$GLOBALS['project_path']."index.php?err=SessionOut");
        die();
    }
}

function logout(){
    $_SESSION["status"]="";
    $_SESSION["status"] = empty($_SESSION["status"]);
    session_unset();
    session_destroy();
    header("location: ".$GLOBALS["project_path"]."index.php?success=loggedOut");
}

function js_redirect($url){
    header('Location: '.$url);
    echo '
        <script>
            window.location.href = "'.$url.'";
        </script>
    ';
}

function verify_is_admin(){
    if(!$_SESSION["is_admin"]){
        js_redirect('user_dashboard.php');
    }
}

function js_alert($msg){
    echo '
        <script>
            alert("'.$msg.'");
        </script>
    ';
}

function handle_sql_errors($query, $error_message)
{
    echo '<pre>';
    echo $query;
    echo '</pre>';
    echo $error_message;
    die;
}

?>


