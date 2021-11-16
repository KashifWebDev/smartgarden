<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  require '../modules/db.php';

  $data = json_decode(file_get_contents("php://input"));

  if(isset($data->Machine_MAC) && isset($data->Curr1) && isset($data->Curr2) && isset($data->Curr3)
      && isset($data->Vlt1) && isset($data->Vlt2) && isset($data->Vlt3) && isset($data->Tmp1)
       && isset($data->Pwr1) && isset($data->Pwr2) && isset($data->Pwr3)
      && isset($data->Tmp2) && isset($data->Tmp3) && isset($data->Alarm) && isset($data->Detect)
      && isset($data->Relay) && isset($data->Cmpressor)
  ) {
      $Machine_Mac = $data->Machine_MAC;
      $Curr1 = $data->Curr1;
      $Curr2 = $data->Curr2;
      $Curr3 = $data->Curr3;
      $Pow1 = $data->Pwr1;
      $Pow2 = $data->Pwr2;
      $Pow3 = $data->Pwr3;
      $Vlt1 = $data->Vlt1;
      $Vlt2 = $data->Vlt2;
      $Vlt3 = $data->Vlt3;
      $Tmp1 = $data->Tmp1;
      $Tmp2 = $data->Tmp2;
      $Tmp3 = $data->Tmp3;
      $alarm = $data->Alarm;
      $detect = $data->Detect;
      $relay = $data->Relay;
      $compressor = $data->Cmpressor;


      date_default_timezone_set("Asia/Karachi");
      $a = date("h:i:sa");
//echo date("d-M,Y  g:i a", strtotime($a));
      $date_now = date("Y-m-d", strtotime($a));
      $time_now = date("g:i a", strtotime($a));

      $sql = "
            INSERT INTO api_data (machine_mac, Curr1,  Curr2, Curr3, Vlt1, Vlt2, Vlt3, pow1, pow2, pow3, Tmp1, Tmp2, Tmp3, Alarm, Detect, Relay,
            Cmpressor)
             VALUES ('$Machine_Mac', '$Curr1', '$Curr2', '$Curr3', '$Vlt1', '$Vlt2', '$Vlt3', '$Pow1', '$Pow2', '$Pow3', '$Tmp1', '$Tmp2', '$Tmp3',
             '$alarm', '$detect', '$relay', '$compressor')
        ";
      if($res = mysqli_query($con, $sql)){
            success_msg();
      }else{
          err_msg("Error Occured while saving data!\n".mysqli_error($con));
      }


  }else{
      err_msg("Parameters are not set correctly!");
  }





function success_msg(){
    echo json_encode(
      array(
          'Response' => 'ACK'
      )
    );
  }

function err_msg($msg){
    echo json_encode(
      array(
          'Response' => 'NACK',
          'Message' => $msg

      )
    );
  }


?>