<?php
if(isset($_POST['mobile_num']))
{
    Include("../includes/connection.php");


    $mobile_num = $_POST['mobile_num'];
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
        $sqlData="SELECT * FROM `doner_profile` WHERE mobile='$mobile_num'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);




            $json_array['status'] = 'success';
            $json_array['doner_name'] = $row['doner_name'];
            $json_array['mobile'] = $row['mobile'];
            $json_array['address'] = $row['address'];
            $json_array['pan'] = $row['pan'];
            $json_response = json_encode($json_array);
            echo $json_response;
        }
        else {

            $json_array['status'] = 'success';
            $json_array['doner_name'] = '';
            $json_array['mobile'] = '';
            $json_array['address'] = '';
            $json_array['pan'] = '';
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
