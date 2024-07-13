<?php
if(isset($_POST['pay_id']))
{
    Include("../includes/connection.php");


    $pay_id = $_POST['pay_id'];
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
        $sqlData="SELECT * FROM `transaction` WHERE pay_id='$pay_id'";
        $resData=mysqli_query($conn,$sqlData);
        if(mysqli_num_rows($resData) > 0)
        {
            $row = mysqli_fetch_array($resData);

            $staffT = $row['added_by'];
            $branchT =  $row['branch_name'];

            $sqlstaff = "SELECT * FROM `staff_profile` WHERE staff_id='$staffT'";
            $resultstaff = mysqli_query($conn, $sqlstaff);
            if (mysqli_num_rows($resultstaff) > 0) {
                $rowstaff = mysqli_fetch_assoc($resultstaff);

                $staff = $rowstaff['staff_name'];

            }
            else{

                $sqlbranchD = "SELECT * FROM `branch_profile` WHERE branch_id='$staffT'";
                $resultBranchD = mysqli_query($conn, $sqlbranchD);
                if (mysqli_num_rows($resultBranchD) > 0) {
                    $rowBranchD = mysqli_fetch_assoc($resultBranchD);

                    $staff = $rowBranchD['incharge'];

                }
            }
            $sqlbranch = "SELECT * FROM `branch_profile` WHERE branch_id='$branchT'";
            $resultBranch = mysqli_query($conn, $sqlbranch);
            if (mysqli_num_rows($resultBranch) > 0) {
                $rowBranch = mysqli_fetch_assoc($resultBranch);

                $branch = $rowBranch['branch_name'];

            }

            $json_array['status'] = 'success';
            $json_array['pay_id'] = $row['pay_id'];
            $json_array['transaction_id'] = $row['transaction_id'];
            $json_array['doner_name'] = $row['doner_name'];
            $json_array['donation_date'] = $row['donation_date'];
            $json_array['donation_time'] = $row['donation_time'];
            $json_array['doner_type'] = $row['doner_type'];
            $json_array['dob'] = $row['dob'];
            $json_array['mobile'] = $row['mobile'];
            $json_array['address'] = $row['address'];
            $json_array['pan'] = $row['pan'];
            $json_array['amount'] = $row['amount'];
            $json_array['branch_name'] = $branch;
            $json_array['pay_mode'] = $row['pay_mode'];
            $json_array['added_by'] = $staff;
            $json_array['doner_id'] = $row['doner_id'];
            $json_array['mobile1'] = $row['mobile1'];
            $json_array['remark'] = $row['remark'];
            $json_array['type'] = $row['type'];




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
