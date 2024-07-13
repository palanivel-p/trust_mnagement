<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['pay_id']) && isset($_POST['doner_id']))
{
    Include("../includes/connection.php");

    $pay_id = $_POST['pay_id'];
    $doner_id = $_POST['doner_id'];


    $confirm_date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];


    //$sqlValidateCookie="SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
    $role = $_COOKIE['role'];
    if($role == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";

    }
    elseif ($role == 'Admin'){
        $sqlValidateCookie = "SELECT * FROM `branch_profile` WHERE panel_api_key='$api_key'";

    }
    else {
        $sqlValidateCookie = "SELECT * FROM `staff_profile` WHERE panel_api_key='$api_key'";

    }
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `transaction` WHERE pay_id='$pay_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 )  {


            $sqlUpdate = "UPDATE `transaction` SET `verify`='2',`confirm_date`='$confirm_date' WHERE `pay_id`='$pay_id'";
            mysqli_query($conn, $sqlUpdate);

            $sqlUpdateD = "UPDATE `doner_profile` SET `verfied`='2' WHERE `doner_id`='$doner_id'";
            mysqli_query($conn, $sqlUpdateD);

            $json_array['status'] = "success";
            $json_array['msg'] = "Confirmed successfully";
            $json_response = json_encode($json_array);
            echo $json_response;
        }

        else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "pay ID Is Not Valid";
            $json_response = json_encode($json_array);
            echo $json_response;
        }
    }
    else
    {
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

?>
