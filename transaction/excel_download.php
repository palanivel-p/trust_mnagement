<?php
require_once 'excel_generator/PHPExcel.php';
Include("../includes/connection.php");



date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$search= $_GET['search'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$branch_nameS= $_GET['branch_nameS']== ''?"all":$_GET['branch_nameS'];
$batch_ids= $_GET['batch_ids']== ''?"all":$_GET['batch_ids'];
$statuss= $_GET['statuss']== ''?"all":$_GET['statuss'];

if($page=='') {
    $page=1;
}


$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}

$from_date = date('Y-m-d 00:00:00',strtotime($f_date));

$to_date = date('Y-m-d 23:59:59',strtotime($t_date));
if($statuss != "all"){
    $statussSql= " AND verify = '".$statuss."'";

}
else{
    $statussSql ="";
}

if($batch_ids != "all"){
    $batch_idsSql= " AND batch_id = '".$batch_ids."'";

}
else{
    $batch_idsSql ="";
}

if($branch_nameS != "all"){
    $branch_nameSSql= " AND branch_name = '".$branch_nameS."'";

}
else{
    $branch_nameSSql ="";
}

if($search != ""){
    $searchSql= "AND mobile LIKE '%".$search."%'";

}
else{
    $searchSql ="";
}

$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];
if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = "AND verify='2'";
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND verify='0' AND branch_name='$cookieBranch_Id'";

    }
    else{
        $addedBranchSerach = "AND verify='0' AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";

    }

}

 //Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Mark Baker")
    ->setLastModifiedBy("Mark Baker")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");

// Add some data
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
//$objPHPExcel->getActiveSheet()->mergeCells('A2:P2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Reference Id');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Doner Id');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Entry Date');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Donation Date');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Donation Time');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Doner Name');
//$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Donation Date');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Doner Type');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Date Of Birth');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Pan No');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Mobile No');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Alter Mobile No');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Amount');
//$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Payment ID');
$objPHPExcel->getActiveSheet()->setCellValue('N2', 'Pay Mode');
$objPHPExcel->getActiveSheet()->setCellValue('O2', 'Emp Name');
$objPHPExcel->getActiveSheet()->setCellValue('P2', 'Branch Name');
$objPHPExcel->getActiveSheet()->setCellValue('Q2', 'Batch Name');
$objPHPExcel->getActiveSheet()->setCellValue('R2', 'Address');
$objPHPExcel->getActiveSheet()->setCellValue('S2', 'Transaction_ID');
$objPHPExcel->getActiveSheet()->setCellValue('T2', 'Status');
$objPHPExcel->getActiveSheet()->setCellValue('U2', 'Type');
$objPHPExcel->getActiveSheet()->setCellValue('V2', 'Remark');




$i = 0;

//if($search == "" && $branch_nameS == "all" && $statuss == "all" && $batch_ids =="all") {
//    $sql = "SELECT * FROM transaction WHERE id>0 $addedBranchSerach ";
//}
//else{
//    $sql = "SELECT * FROM transaction WHERE id > 0 $statussSql$batch_idsSql$branch_nameSSql$searchSql$addedBranchSerach ";
//}
if($search == "" && $branch_nameS == "all" && $statuss == "all" && $batch_ids =="all") {
    $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach";
}
else{
    $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $statussSql$batch_idsSql$branch_nameSSql$searchSql$addedBranchSerach ";
}

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;
        $img = $row['img'];
        if($img == 1) {
            $img_upload = "badge-success";
            $img_modal = '#image_modal';
        }
        else {
            $img_upload = "badge-danger";
        }
        $verify = $row["verify"];


        if($verify == 1){
            $verfied_content = "VERIFIED";
        }
        elseif(($verify == 0)){
            $verfied_content = "UNVERIFIED";
        }
        elseif(($verify == 2)){
            $verfied_content = "CONFIRMED";
        }

        $staffId = $row['added_by'];
        $branchId = strtoupper($row['branch_name']);


        $sqlStaf = "SELECT * FROM `staff_profile` WHERE staff_id='$staffId'";
        $resultStaf = mysqli_query($conn, $sqlStaf);
        if (mysqli_num_rows($resultStaf) > 0) {
            $rowstaf = mysqli_fetch_assoc($resultStaf);

            $added_byTable = $rowstaf['staff_name'];
        }
        else {
            $sqlBr = "SELECT * FROM `branch_profile` WHERE branch_id='$staffId'";
            $resultBr = mysqli_query($conn, $sqlBr);
            if (mysqli_num_rows($resultBr) > 0) {
                $rowBr = mysqli_fetch_assoc($resultBr);
                $added_byTable = $rowBr['incharge'];
            }
        }

        $sqlbranchNames = "SELECT * FROM `branch_profile` WHERE branch_id='$branchId'";
        $resultBranchNames = mysqli_query($conn, $sqlbranchNames);
        if (mysqli_num_rows($resultBranchNames) > 0) {
            $rowBranchNames = mysqli_fetch_assoc($resultBranchNames);

            $branchNames = $rowBranchNames['branch_name'];

        }
        $batchId = $row['batch_id'];


        $sqlbatchName="SELECT * FROM `batch_profile` WHERE batch_id='$batchId'";
        $resultbatchName=mysqli_query($conn,$sqlbatchName);
        if(mysqli_num_rows($resultbatchName) > 0) {
            $rowbatchName = mysqli_fetch_assoc($resultbatchName);

            $batchName = strtoupper($rowbatchName['batch_name']);

        }

            $date =  $row['date'];
            $entry_date = date("d-m-Y", strtotime($date));

            $doner_name =  strtoupper($row['doner_name']);
            $doner_type =  strtoupper($row['doner_type']);
            $doner_id =  strtoupper($row['doner_id']);
            $dob=  $row['dob'];
            $d_date=  $row['donation_date'];
            $donation_date=  date("d-m-Y", strtotime($d_date));
            if($donation_date == '30-11--0001'){
                $donation_date = 'NILL';
            }
            $donation_time=  $row['donation_time'];
            $pan_no =  strtoupper($row['pan']);
            $mobile_no =  $row['mobile'];
            $alter_mobile_no =  $row['mobile1'];
            $amount =  $row['amount'];
            $pay_id =  strtoupper($row['pay_id']);
            $pay_mode =  strtoupper($row['pay_mode']);
           // $added_by =  $rowvalue['date'];
            //$branch_name =  $rowvalue['date'];
            //$batch_name =  $rowvalue['date'];

            $address = strtoupper($row['address']);
            $transaction_id =  strtoupper($row['transaction_id']);
            $type =  strtoupper($row['type']);
            $remark =  strtoupper($row['remark']);
             $added_byTable;
            $branchNames;
            $batchName;
//                $staffId = $rowvalue['added_by'];
//                $branchId = $rowvalue['branch_name'];
//                $batchId = $rowvalue['batch_id'];




                $i++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
                $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($pay_id));
                $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($doner_id));
                $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$entry_date);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$donation_date);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$donation_time);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$doner_name);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$doner_type);
//                $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2) ,$dob);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 2) ,$pan_no);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 2) ,$mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . ($i + 2) ,$alter_mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . ($i + 2) ,$amount);
//                $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$pay_id);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . ($i + 2) ,$pay_mode);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . ($i + 2) ,$added_byTable);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . ($i + 2) ,$branchNames);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . ($i + 2) ,$batchName);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . ($i + 2) ,$address);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . ($i + 2) ,$transaction_id);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . ($i + 2) ,$verfied_content);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . ($i + 2) ,$type);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . ($i + 2) ,$remark);


          //  }
    }
}


//echo $_SERVER["DOCUMENT_ROOT"];

$objPHPExcel->getActiveSheet()->setCellValue('A1'," Transaction");
//$objPHPExcel->getActiveSheet()->setCellValue('A2');
$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getAlignment()
    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2')
//    ->getAlignment()
//    ->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getFont()
    ->setSize(16)
    ->setBold(true);

//$objPHPExcel->getActiveSheet()
//    ->getStyle('A2')
//    ->getFont()
//    ->setSize(13)
//    ->setBold(true);


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');

$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:B1')
    ->getProtection()->setLocked(
        PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
    );

function cellColor($cells,$color){
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}

if($_COOKIE['role'] == 'Super Admin'){

    cellColor('A2:V2', '#181f5a');

    $objPHPExcel->getActiveSheet()
        ->getStyle('A2:V2')
        ->getFont()
        ->getColor()
        ->setRGB('FFFFFF');

    $objPHPExcel->getActiveSheet()
        ->getStyle('A2:V2')
        ->getFont()
        ->setSize(12)
        ->setBold(true);
}

cellColor('A2:V2', '#181f5a');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:V2')
    ->getFont()
    ->getColor()
    ->setRGB('FFFFFF');

$objPHPExcel->getActiveSheet()
    ->getStyle('A2:V2')
    ->getFont()
    ->setSize(12)
    ->setBold(true);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/portal/transaction/transaction.csv');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=transaction.csv");
readfile($_SERVER["DOCUMENT_ROOT"].'/portal/transaction/transaction.csv');

@unlink($_SERVER["DOCUMENT_ROOT"].'/portal/transaction/transaction.csv');

?>