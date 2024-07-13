<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['pay_id']))
{
    Include("../includes/connection.php");

    $pay_id = $_POST['pay_id'];
    $old_pa_id = $_POST['old_pa_id'];
    $doner_name = $_POST['doner_name'];
    $donation_date = $_POST['donation_date'];
    $donation_time = $_POST['donation_time'];
    $doner_type = $_POST['doner_type'];
    $dob = $_POST['dob'];
    $transaction_id = $_POST['transaction_id'];

    $mobile = $_POST['mobile'];

    $address = $_POST['address'];
    $pan = $_POST['pan'];

    $amount = $_POST['amount'];
    $pay_mode = $_POST['pay_mode'];
    $branch_name =  $_COOKIE['branch_id'];
    //$branch_name = $_POST['branch_name'];
    $added_by = $_COOKIE['staff_id'];
    // $added_by = $_POST['added_by'];

    $mobile1 = $_POST['mobile1'];
    $remark = $_POST['remark'];
    $type = $_POST['type'];

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

        $sqlValidate = "SELECT * FROM `transaction` WHERE pay_id='$old_pa_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($pay_id==$old_pa_id))  {


            $sqlUpdate = "UPDATE `transaction` SET `pay_id`='$pay_id',`doner_name`='$doner_name',`doner_type`='$doner_type',`dob`='$dob',`pan`='$pan',`address`='$address',`mobile`='$mobile',`amount`='$amount',`pay_mode`='$pay_mode',`mobile1`='$mobile1',`remark`='$remark',`transaction_id`='$transaction_id',`type`='$type',`donation_date`='$donation_date',`donation_time`='$donation_time' WHERE `pay_id`='$old_pa_id'";
            mysqli_query($conn, $sqlUpdate);

            $uploadDir = 'pay_img/';
            $new_image_name = $pay_id.'.jpg';
            $maxSize =1000000;
            $uploadedFile = '';

            //inserted successfully

            if (!empty($_FILES["upload_image"]["tmp_name"])) {


                if(($_FILES['upload_image']['size']) <= $maxSize) {

                    $targetFilePath = $uploadDir . $new_image_name;
                    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                    $allowTypes = array('jpg','jpeg');
                    if (in_array($fileType, $allowTypes)) {

                        if (!move_uploaded_file($_FILES["upload_image"]["tmp_name"], $targetFilePath)) {

                            //not uploaded
                            $json_array['status'] = "success";
                            $json_array['msg'] = "Updated Successfully, but Image not uploaded!!!";
                            $json_response = json_encode($json_array);
                            echo $json_response;
                        }
                        else{
                            $sqlUpdates = "UPDATE transaction SET img =1 WHERE pay_id ='$pay_id'";
                            mysqli_query($conn, $sqlUpdates);

                            $emp_id = $_COOKIE['staff_id'];
                            $info = urlencode("Edited Transaction" );
                            file_get_contents($website . "portal/includes/log.php?emp_id=$emp_id&info=$info");

                            $json_array['status'] = "success";
                            $json_array['msg'] = "Updated Successfully !!!";
                            $json_response = json_encode($json_array);
                            echo $json_response;


                        }

                    }
                    else {
                        //allow type
                        $json_array['status'] = "success";
                        $json_array['msg'] = "Updated Successfully, but change Image type not uploaded!!!";
                        $json_response = json_encode($json_array);
                        echo $json_response;
                    }


                }
                else {
                    // max size
                    $json_array['status'] = "success";
                    $json_array['msg'] = "Updated Successfully, but change Image size not uploaded!!!";
                    $json_response = json_encode($json_array);
                    echo $json_response;
                }




            }
            else {
                //not upload
                $json_array['status'] = "success";
                $json_array['msg'] = "Updated Successfully, but Image not uploaded!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            }

        } else {


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
