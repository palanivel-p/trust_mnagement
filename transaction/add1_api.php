<?php

date_default_timezone_set("Asia/Kolkata");
//date_default_timezone_set("Asia/Tokyo");
//date_default_timezone_set('Europe/London');

//date_default_timezone_set("America/California");
//date_default_timezone_set("America/New_York");


if(isset($_POST['doner_name']) && isset($_POST['mobile']) &&isset($_POST['amount'])) {
    Include("../includes/connection.php");




    $doner_name = $_POST['doner_name'];
    $doner_type = $_POST['doner_type'];
    $dob = $_POST['dob'];
    $donation_date = $_POST['donation_date'];
    $donation_time = $_POST['donation_time'];
    $transaction_id = $_POST['transaction_id'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $pan = $_POST['pan'];
    $amount = $_POST['amount'];
    $pay_mode = $_POST['pay_mode'];
    // $branch_name = $_POST['branch_name'];
    $branch_name =  $_COOKIE['branch_id'];
    //  $added_by = $_POST['added_by'];
    $added_by = $_COOKIE['staff_id'];
    $remark = $_POST['remark'];
    $mobile1 = $_POST['mobile1'];
    $type = $_POST['type'];



    $sqladded_by="SELECT * FROM `staff_profile` WHERE staff_id='$added_by'";
    $resultadded_by=mysqli_query($conn,$sqladded_by);
    if(mysqli_num_rows($resultadded_by) > 0) {
        $rowadded_by = mysqli_fetch_assoc($resultadded_by);

        $added_bys = $rowadded_by['staff_id'];

    }

    //$access_type = $_POST['access_type'];
    //$access_status = $_POST['active_status'];


    //$date = date('Y-m-d');
    $date = date('Y-m-d H:i:s', time());


    //$job_descriptions =  str_replace("'", "", $job_description);

    //  $added_by = $_COOKIE['staff_id'];

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
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidateDonor = "SELECT * FROM `doner_profile` WHERE mobile='$mobile'";
        $resValidateDonor = mysqli_query($conn, $sqlValidateDonor);
        if (mysqli_num_rows($resValidateDonor) > 0) {
            $rowDonor = mysqli_fetch_array($resValidateDonor);

            $doneriD = $rowDonor['doner_id'];

        }
        else {

//            $batch_idT = '';
//
//            $sqlB = "SELECT * FROM batch_profile";
//            $resultB = mysqli_query($conn, $sqlB);
//            if (mysqli_num_rows($resultB) > 0) {
//
//                while ($rowB = mysqli_fetch_assoc($resultB)) {
//
//                    $startTime = $rowB['start_time'];
//                    $endTime = $rowB['end_time'];
//                    $batch_id = $rowB['batch_id'];
//
//                    $current_time = date('G.i');
//                    $sunrise = date('G.i', strtotime($startTime));
//                    $end = date('G.i', strtotime($endTime));
//
//
//                    if ($current_time > $sunrise && $current_time < $end) {
//                        $batch_idT = $batch_id;
//                        break;
//                    } else {
//                        $batch_idT = $batch_id;
//
//                    }
//
//
//                }
//            }

            $sqlInsertd = "INSERT INTO `doner_profile`(`doner_id`,`doner_name`,`doner_type`,`mobile`,`address`,`pan`,`added_by`,`branch_id`) 
                                            VALUES ('','$doner_name','$doner_type','$mobile','$address','$pan','$added_bys','$branch_name')";

            mysqli_query($conn, $sqlInsertd);

            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $doneriD = "D" . ($ID);

            $sqlUpdate = "UPDATE doner_profile SET doner_id = '$doneriD' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);

        }

        $batch_idT = '';

        $sqlB = "SELECT * FROM batch_profile";
        $resultB = mysqli_query($conn, $sqlB);
        if (mysqli_num_rows($resultB)>0) {

            while($rowB = mysqli_fetch_assoc($resultB)) {

                $startTime = $rowB['start_time'];
                $endTime = $rowB['end_time'];
                $batch_id = $rowB['batch_id'];

                $current_time = date('G.i');
                $sunrise = date('G.i',strtotime($startTime));
                $end =date('G.i',strtotime($endTime));


                if($current_time > $sunrise && $current_time<$end){
                    $batch_idT = $batch_id;
                    break;
                }
                else{
                    $batch_idT =$batch_id;

                }



            }
        }


        $sqlInsert = "INSERT INTO `transaction`(`pay_id`,`doner_name`,`doner_type`,`donation_date`,`donation_time`,`dob`,`address`,`mobile`,`pan`,`amount`,`pay_mode`,`added_by`,`branch_name`,`date`,`doner_id`,`batch_id`,`mobile1`,`remark`,`transaction_id`,`type`) 
                                            VALUES ('','$doner_name','$doner_type','$donation_date','$donation_time','$dob','$address','$mobile','$pan','$amount','$pay_mode','$added_by','$branch_name','$date','$doneriD','$batch_idT','$mobile1','$remark','$transaction_id','$type')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $pay_id="R".($ID);

        $sqlUpdate = "UPDATE transaction SET pay_id = '$pay_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);

        $uploadDir = 'pay_img/';
        $new_image_name = $pay_id.'.jpg';
        $maxSize =1000000;
        $uploadedFile = '';
        //log
        //        $info = urlencode("Added Game - " . $game_id);
        //        file_get_contents($website . "portal/includes/log.php?api_key=$api_key&info=$info");

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
                        $json_array['msg'] = "Added Successfully, but Image not uploaded!!!";
                        $json_response = json_encode($json_array);
                        echo $json_response;
                    }
                    else{
                        $sqlUpdates = "UPDATE transaction SET img =1 WHERE pay_id ='$pay_id'";
                        mysqli_query($conn, $sqlUpdates);

                        $json_array['status'] = "success";
                        $json_array['msg'] = "Added Successfully !!!";
                        $json_response = json_encode($json_array);
                        echo $json_response;


                    }

                }
                else {
                    //allow type
                    $json_array['status'] = "success";
                    $json_array['msg'] = "Added Successfully, but change Image type not uploaded!!!";
                    $json_response = json_encode($json_array);
                    echo $json_response;
                }


            }
            else {
                // max size
                $json_array['status'] = "success";
                $json_array['msg'] = "Added Successfully, but change Image size not uploaded!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            }




        }
        else {
            //not upload
            $json_array['status'] = "success";
            $json_array['msg'] = "Added Successfully, but Image not uploaded!!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        }

    }


    else {
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



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>
