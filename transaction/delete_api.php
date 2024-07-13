<?php
if(isset($_POST['pay_id']))
{
    Include("../includes/connection.php");


    $pay_id = $_POST['pay_id'];
    $api_key = $_COOKIE['panel_api_key'];

    $role = $_COOKIE['role'];

    // $sqlValidateCookie = "SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
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


        $sqlUpdate = "DELETE FROM `transaction` WHERE pay_id='$pay_id'";
        mysqli_query($conn, $sqlUpdate);

        //deleted successfully

        $json_array['status'] = "success";
        $json_array['msg'] = "Deleted successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;


    }
    else
    {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Please try after sometime!!!";
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
