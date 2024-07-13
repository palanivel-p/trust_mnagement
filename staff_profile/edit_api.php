<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['staff_id']))
{
    Include("../includes/connection.php");

    $staff_id = $_POST['staff_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $staff_name = $_POST['staff_name'];
    $branch_name = $_POST['branch_name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $doj = $_POST['doj'];
   // $user_name = $_POST['user_name'];
    $password = $_POST['password'];
//    $access_type = $_POST['access_type'];
    $access_status = $_POST['active_status'];

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

        $sqlValidate = "SELECT * FROM `staff_profile` WHERE staff_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($staff_id==$old_pa_id))  {


           $sqlUpdate = "UPDATE `staff_profile` SET `staff_id`='$staff_id',`staff_name`='$staff_name',`branch_name`='$branch_name',`address`='$address',`mobile`='$mobile',`email`='$email',`doj`='$doj',`password`='$password',`access_status`='$access_status' WHERE `staff_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);



            //inserted successfully

            $json_array['status'] = "success";
            $json_array['msg'] = "Updated successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;


        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Staff ID Is Not Valid";
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
