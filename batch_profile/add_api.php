<?php
date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['batch_name'])) {
    Include("../includes/connection.php");

    $batch_name = $_POST["batch_name"];
    $batch_time = $_POST["batch_time"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

//    $added_by = $_COOKIE['user_id'];

    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie = "SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `batch_profile`(`batch_id`,`batch_name`,`start_time`,`end_time`) 
                                            VALUES ('','$batch_name','$start_time','$end_time')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $batch_id="B".($ID);

        $sqlUpdate = "UPDATE batch_profile SET batch_id = '$batch_id' WHERE id ='$ID'";
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
}
else
{
    //Parameters missing

     $json_array['status'] = "failure";
     $json_array['msg'] = "Please try after sometime !!!";
     $json_response = json_encode($json_array);
     echo $json_response;
 }


function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

?>
