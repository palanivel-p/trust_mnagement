<?php
if(isset($_POST['branch_id']))
{
    Include("../includes/connection.php");


    $branch_id = $_POST['branch_id'];
    $api_key = $_COOKIE['panel_api_key'];
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
   // $sqlValidateCookie="SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";

    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0)
    {
        $sqlData="SELECT * FROM `branch_profile` WHERE branch_id='$branch_id'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);

            $json_array['status'] = 'success';
            $json_array['branch_id'] = $row['branch_id'];
            $json_array['branch_name'] = $row['branch_name'];
            $json_array['incharge'] = $row['incharge'];
            $json_array['mobile'] = $row['mobile'];
            $json_array['email'] = $row['email'];
            $json_array['password'] = $row['password'];
            $json_array['location'] = $row['location'];
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
