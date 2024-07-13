<?php
if(isset($_POST['pay_id']))
{
    Include("../includes/connection.php");
 

    $pay_id = $_POST['pay_id'];
    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie="SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";

    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0)
    {
        $sqlData="SELECT * FROM `transaction` WHERE pay_id='$pay_id'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);

            $json_array['status'] = 'success';
            $json_array['pay_id'] = $row['pay_id'];
            $json_array['doner_name'] = $row['doner_name'];
            $json_array['mobile'] = $row['mobile'];
            $json_array['address'] = $row['address'];
            $json_array['pan'] = $row['pan'];
            $json_array['amount'] = $row['amount'];
            $json_array['pay_mode'] = $row['pay_mode'];
            $json_array['added_by'] = $row['added_by'];




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
