<?php

date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['doner_name']) && isset($_POST['mobile']) &&isset($_POST['amount'])) {
    Include("../includes/connection.php");

    $doner_name = $_POST['doner_name'];
    
    $mobile = $_POST['mobile'];
    
    $address = $_POST['address'];
    $pan = $_POST['pan'];
    
    $amount = $_POST['amount']; 
    $pay_mode = $_POST['pay_mode'];
    $added_by = $_POST['added_by'];

    //$access_type = $_POST['access_type'];
    //$access_status = $_POST['active_status'];
    

    //$date = date('Y-m-d');

    //$job_descriptions =  str_replace("'", "", $job_description);

    //$added_by = $_COOKIE['user_id'];

    $api_key = $_COOKIE['panel_api_key'];



    $sqlValidateCookie = "SELECT * FROM `admin_login` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `transaction`(`pay_id`,`doner_name`,`address`,`mobile`,`pan`,`amount`,`pay_mode`,`added_by`) 
                                            VALUES ('','$doner_name','$address','$mobile','$pan','$amount','$pay_mode','$added_by')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $pay_id="PP".($ID);

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
