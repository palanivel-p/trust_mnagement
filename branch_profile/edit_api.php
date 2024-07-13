<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['branch_id']))
{
    Include("../includes/connection.php");

    $branch_id = $_POST['branch_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $branch_name = $_POST['branch_name'];
    $incharge = $_POST['incharge'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $access_status = $_POST['active_status'];
    $password = $_POST['password'];

    //$date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];
    $role = $_COOKIE['role'];


   // $sqlValidateCookie="SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
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

        $sqlValidate = "SELECT * FROM `branch_profile` WHERE branch_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($branch_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `branch_profile` SET `branch_id`='$branch_id',`branch_name`='$branch_name',`incharge`='$incharge',`mobile`='$mobile',`email`='$email',`location`='$location',`access_status`='$access_status',`password`='$password' WHERE `branch_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);



            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Branch ID Is Not Valid";
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
