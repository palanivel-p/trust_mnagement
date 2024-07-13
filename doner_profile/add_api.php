<?php
date_default_timezone_set("Asia/Kolkata");

//if(isset($_POST['doner_name']) && isset($_POST['mobile']) &&isset($_POST['pan'])) {
    Include("../includes/connection.php");

    $doner_name = $_POST['doner_name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pan = $_POST['pan'];

    //$date = date('Y-m-d');
    $batch_date = date('Y-m-d h:i:s A', time());

    //$batch_date='2011-08-04 11:00';
        
    $timestamp = strtotime($batch_date);
    $date = date('n.j.Y', $timestamp); // d.m.YYYY
    $time = date('H:i', $timestamp); // HH:ss


// if ($time < 12 && $time > 06) {

//     //$batch_name="Batch-A";
//     echo "Batch-A";

// } else
if ($time < 18 && $time > 12) {

    $batch_name="Batch-B";
    //echo "Batch-B";

} elseif ($time < 06 && $time > 18) {

    $batch_name="Batch-C";
    //echo "Batch-C";

}
else{
    $batch_name="Batch-A";
}

    //$job_descriptions =  str_replace("'", "", $job_description);

//    $added_by = $_COOKIE['user_id'];

    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie = "SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `doner_profile`(`doner_id`,`doner_name`,`address`,`mobile`,`email`,`pan`,`batch_date`,`batch_name`) 
                                            VALUES ('','$doner_name','$address','$mobile','$email','$pan','$batch_date','$batch_name')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $doner_id="D".($ID);

        $sqlUpdate = "UPDATE doner_profile SET doner_id = '$doner_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);
        //log
//        $info = urlencode("Added Game - " . $game_id);
//        file_get_contents($website . "portal/includes/log.php?api_key=$api_key&info=$info");

        //inserted successfully

        $json_array['status'] = "success";
        $json_array['msg'] = "Added successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


    else {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Login !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
// }
// else
// {
//     //Parameters missing

//      $json_array['status'] = "failure";
//      $json_array['msg'] = "Please try after sometime !!!";
//      $json_response = json_encode($json_array);
//      echo $json_response;
//  }


function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

?>
