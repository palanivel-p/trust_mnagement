<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['doner_id']))
{
    Include("../includes/connection.php");

    $doner_id = $_POST['doner_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $doner_name = $_POST['doner_name'];

    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $pan = $_POST['pan'];


    //$date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];


    $sqlValidateCookie="SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `doner_profile` WHERE doner_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($doner_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `doner_profile` SET `doner_id`='$doner_id',`doner_name`='$doner_name',`address`='$address',`mobile`='$mobile',`email`='$email',`pan`='$pan' WHERE `doner_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);



            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Doner ID Is Not Valid";
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
