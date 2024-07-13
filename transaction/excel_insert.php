<?php
date_default_timezone_set("Asia/Kolkata");
Include("../includes/connection.php");
 $current_date = date('Y-m-d');
$startTimeA = '06:00:00';
$endTimeA = '11:59:59';
$startTimeB = '12:00:00';
$endTimeB = '16:59:59';
$startTimeC = '17:00:00';
$endTimeC = '05:59:59';
$current_time = date('G.i');

$startA = date('G.i',strtotime($startTimeA));
$endA =date('G.i',strtotime($endTimeA));
$startB = date('G.i',strtotime($startTimeB));
$endB =date('G.i',strtotime($endTimeB));
$startC= date('G.i',strtotime($startTimeC));
$endC =date('G.i',strtotime($endTimeC));




$added_byy = $_COOKIE['staff_id'];
$branch_id = $_COOKIE['branch_id'];
$role = $_COOKIE['role'];
$file = $_FILES['file']['tmp_name'];
$handle = fopen($file, "r");
$c = 0;

function insert($checkSchool)
{

    global $current_date;
    global $current_time;
    global $startA;
    global $endA;
    global $startB;
    global $startC;
    global $endB;
    global $endC;
    global $branch_id;


    $api_key = $_COOKIE['api_key'];
    $added_byy = $_COOKIE['staff_id'];
global $role;

    $statusSucces = 0;
    if ($checkSchool == 0) {

        Include("../includes/connection.php");


        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $c = 0;
        $CNo = 0;
        while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {
            $CNo++;
         //   print_r($filesop);
           // echo $role;

            if ($c >1) {
            $sNo = $filesop[0];
            $pay_id = $filesop[1];
            $doner_id = $filesop[2];
            $entry_date = $filesop[3];
            $donation_date = $filesop[4];
            $donation_time = $filesop[5];
            $doner_name = $filesop[6];
            $doner_type = $filesop[7];
            $dob = $filesop[8];
            $pan_no = $filesop[9];
            $mobile_no = $filesop[10];
            $alter_mobile_no = $filesop[11];
            $amount = $filesop[12];
            $pay_mode = $filesop[13];
            $added_by = $filesop[14];
            $branch_name = $filesop[15];
            $batch_name = $filesop[16];
            $address = $filesop[17];
            $transaction_id = $filesop[18];
            $status = $filesop[19];
            $type = $filesop[20];
            $remark = $filesop[21];
            $date = date('Y-m-d');



                if($status == 'VERIFIED'){
                    $verfied_content = 1;
                }
                else if($status == 'CONFIRMED'){
                    $verfied_content = 2;
                }
                else if($status == 'UNVERIFIED'){
                    $verfied_content = 0;
                }




            if($role == 'Super Admin'){

                $sqlValidate = "SELECT * FROM `transaction` WHERE pay_id='$pay_id'";
                $resValidate = mysqli_query($conn, $sqlValidate);
                if (mysqli_num_rows($resValidate) > 0) {


                   $sqlUpdate = "UPDATE `transaction` SET `dob`='$dob',`donation_time`='$donation_time',`verify`='$verfied_content',`doner_name`='$doner_name',`doner_type`='$doner_type',`pan`='$pan_no',`mobile`='$mobile_no',`mobile1`='$alter_mobile_no',`amount`='$amount',`pay_mode`='$pay_mode',`address`='$address',`remark`='$remark',`type`='$type',`verify_date`='$date' WHERE `pay_id`='$pay_id'";
                    mysqli_query($conn, $sqlUpdate);
                    $statusSucces = 1;

                }
                if($verfied_content == 1)
                {

                    $sqlValidates = "SELECT * FROM `doner_profile` WHERE mobile='$mobile_no'";
                    $resValidates = mysqli_query($conn, $sqlValidates);
                    if (mysqli_num_rows($resValidates) > 0)
                    {

                        $sqlUpdates = "UPDATE `doner_profile` SET `verfied`='1' WHERE `mobile`='$mobile_no'";
                        mysqli_query($conn, $sqlUpdates);
                    }
                }
            }
                if($role == 'Admin'){

                    $sqlValidate = "SELECT * FROM `transaction` WHERE pay_id='$pay_id'";
                    $resValidate = mysqli_query($conn, $sqlValidate);
                    if (mysqli_num_rows($resValidate) > 0) {


                             $sqlUpdate = "UPDATE `transaction` SET `dob`='$dob',`donation_time`='$donation_time',`verify`='$verfied_content',`doner_name`='$doner_name',`doner_type`='$doner_type',`pan`='$pan_no',`mobile`='$mobile_no',`mobile1`='$alter_mobile_no',`amount`='$amount',`pay_mode`='$pay_mode',`address`='$address',`remark`='$remark',`confirm_date`='$date' WHERE `pay_id`='$pay_id'";
                        mysqli_query($conn, $sqlUpdate);
                        $statusSucces = 1;


                    }
                    if($verfied_content == 2)
                    {

                        $sqlValidates = "SELECT * FROM `doner_profile` WHERE mobile='$mobile_no'";
                        $resValidates = mysqli_query($conn, $sqlValidates);
                        if (mysqli_num_rows($resValidates) > 0)
                        {

                            $sqlUpdates = "UPDATE `doner_profile` SET `verfied`='2' WHERE `mobile`='$mobile_no'";
                            mysqli_query($conn, $sqlUpdates);
                        }
                    }
                }

            }

                $c = $c + 1;
            }

        if($current_time > $startA && $current_time<$endA){
            $batchupdate="`batchA_count`='$CNo',`batchA_date`='$current_date'";
        }
        elseif($current_time > $startB && $current_time<$endB){
            $batchupdate="`batchB_count`='$CNo',`batchB_date`='$current_date'";
        }
        elseif($current_time > $startC && $current_time<$endC){
            $batchupdate="`batchC_count`='$CNo',`batchC_date`='$current_date'";
        }
        $sqlUpdateCount = "UPDATE `branch_profile` SET $batchupdate  WHERE `branch_id`='$branch_id'";
        mysqli_query($conn, $sqlUpdateCount);
        }


        if ($statusSucces == 1) {
            $json_array['status'] = "success";
            $json_array['msg'] = "Added successfully !!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        } elseif ($statusSucces == 0) {
            $json_array['status'] = "failure";
            $json_array['msg'] = "No New Records Added !!!";
            $json_response = json_encode($json_array);
            echo $json_response;
        }

    }

insert(0);
?>