<?php
if(isset($_POST['staff_id']))
{
    Include("../includes/connection.php");


    $staff_id = $_POST['staff_id'];
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
    if(mysqli_num_rows($resValidateCookie) > 0)
    {
        $sqlData="SELECT * FROM `staff_profile` WHERE staff_id='$staff_id'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);

            $json_array['status'] = 'success';
            $json_array['staff_id'] = $row['staff_id'];
            $json_array['branch_name'] = $row['branch_name'];
            $json_array['staff_name'] = $row['staff_name'];
            $json_array['mobile'] = $row['mobile'];
            $json_array['email'] = $row['email'];
            $json_array['address'] = $row['address'];
            $json_array['doj'] = $row['doj'];
           // $json_array['user_name'] = $row['user_name'];
            $json_array['password'] = $row['password'];
            $json_array['access_type'] = $row['access_type'];
            $json_array['access_status'] = $row['access_status'];

            $json_response = json_encode($json_array);
            echo $json_response;
        }


    }
    else
    {
        //staff id already exist

        $json_array['status'] = "wrong";
        $json_array['msg'] = "Login Invalid";
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
