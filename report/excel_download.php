<?php
require_once 'excel_generator/PHPExcel.php';
Include("../includes/connection.php");

$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$search= $_GET['search'];
$statuss= $_GET['statuss']== ''?"all":$_GET['statuss'];
$branch_nameS= $_GET['branch_nameS']== ''?"all":$_GET['branch_nameS'];


if($branch_nameS != "all"){
    $branch_nameSSql= " AND branch_name = '".$branch_nameS."'";
}
else{
    $branch_nameSSql ="";
}
if($statuss != "all"){
    $statussSql= " AND verify = '".$statuss."'";
}
else if($statuss == "all"){
    $statussSql ="AND verify IN (1, 3)";
}

if($search != ""){
    $searchSql= "AND mobile LIKE '%".$search."%'";
}
else{
    $searchSql ="";
}
if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}

$from_date = date('Y-m-d 00:00:00',strtotime($f_date));

$to_date = date('Y-m-d 23:59:59',strtotime($t_date));

$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];

if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = '';
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";

    }
    else{
        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";

    }

}

// Create new PHPExcel object
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
//$objPHPExcel->getActiveSheet()->mergeCells('A2:J2');

$objPHPExcel->getActiveSheet()->setCellValue('A2', '#');
$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Reference Id');
$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Doner Id');
$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Entry Date');
$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Donation Date');
$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Donation Time');
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Doner Name');
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Doner Type');
$objPHPExcel->getActiveSheet()->setCellValue('I2', 'Date Of Birth');
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'Pan No');
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'Mobile No');
$objPHPExcel->getActiveSheet()->setCellValue('L2', 'Alter Mobile No');
$objPHPExcel->getActiveSheet()->setCellValue('M2', 'Amount');
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

//if ($branch_nameS == 'all') {
//    $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach ";
//
//} else {
//    $sql = "SELECT * FROM transaction WHERE branch_name ='$branch_nameS' AND date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach";
//}

if ($branch_nameS == 'all'&& $statuss == "all" && $search =="") {
    $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach$statussSql";

} else {
    $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $searchSql$statussSql$addedBranchSerach$branch_nameSSql";
}
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = $i;
    while($row = mysqli_fetch_assoc($result)) {

        $sNo++;
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
        elseif(($verify == 3)){
            $verfied_content = "NOT OK";
        }
        $staffId = $row['added_by'];

        $staffId = $row['added_by'];
        $branchId = $row['branch_name'];


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


        if($_COOKIE['role'] == 'Staff') {

            $sqlstaffid = "SELECT * FROM `staff_profile` WHERE staff_id='$staffId'";
            $resultstaffid = mysqli_query($conn, $sqlstaffid);
            if (mysqli_num_rows($resultstaffid) > 0) {
                $rowstaff_name = mysqli_fetch_assoc($resultstaffid);

                $added_by = $rowstaff_name['staff_name'];
                $staff_id = $rowstaff_name['staff_id'];


            }
            $branch=$_COOKIE['branch_id'];
            $sqlbranchName = "SELECT * FROM `branch_profile` WHERE branch_id='$branch'";
            $resultBranchName = mysqli_query($conn, $sqlbranchName);
            if (mysqli_num_rows($resultBranchName) > 0) {
                $rowBranchName = mysqli_fetch_assoc($resultBranchName);

                $added_by = $rowBranchName['incharge'];
                $branchName = $rowBranchName['branch_name'];

            }



        }
        $branchId = $row['branch_name'];

        if ($_COOKIE['role'] == 'Admin' || $_COOKIE['role'] =='Super Admin') {
            $sqlbranchName = "SELECT * FROM `branch_profile` WHERE branch_id='$branchId'";
            $resultBranchName = mysqli_query($conn, $sqlbranchName);
            if (mysqli_num_rows($resultBranchName) > 0) {
                $rowBranchName = mysqli_fetch_assoc($resultBranchName);

                $added_by = $rowBranchName['incharge'];
                $branchName = $rowBranchName['branch_name'];

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

            $batchName = $rowbatchName['batch_name'];

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



            $i++;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2) , ($i));
        $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2) , ($pay_id));
        $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2) , ($doner_id));
        $objPHPExcel->getActiveSheet()->setCellValue('D' . ($i + 2) ,$entry_date);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . ($i + 2) ,$donation_date);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . ($i + 2) ,$donation_time);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . ($i + 2) ,$doner_name);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . ($i + 2) ,$doner_type);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . ($i + 2) ,$dob);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . ($i + 2) ,$pan_no);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . ($i + 2) ,$mobile_no);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . ($i + 2) ,$alter_mobile_no);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . ($i + 2) ,$amount);
        $objPHPExcel->getActiveSheet()->setCellValue('N' . ($i + 2) ,$pay_mode);
        $objPHPExcel->getActiveSheet()->setCellValue('O' . ($i + 2) ,$added_byTable);
        $objPHPExcel->getActiveSheet()->setCellValue('P' . ($i + 2) ,$branchNames);
        $objPHPExcel->getActiveSheet()->setCellValue('Q' . ($i + 2) ,$batchName);
        $objPHPExcel->getActiveSheet()->setCellValue('R' . ($i + 2) ,$address);
        $objPHPExcel->getActiveSheet()->setCellValue('S' . ($i + 2) ,$transaction_id);
        $objPHPExcel->getActiveSheet()->setCellValue('T' . ($i + 2) ,$verfied_content);
        $objPHPExcel->getActiveSheet()->setCellValue('U' . ($i + 2) ,$type);
        $objPHPExcel->getActiveSheet()->setCellValue('V' . ($i + 2) ,$remark);

        }

}


$objPHPExcel->getActiveSheet()->setCellValue('A1'," Report");
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
$objWriter->save($_SERVER["DOCUMENT_ROOT"].'/portal/report/report.xlsx');
sleep(1);

header('Content-type: application/octet-stream');
header("Content-Disposition: attachment; filename=report.xlsx");
readfile($_SERVER["DOCUMENT_ROOT"].'/portal/report/report.xlsx');

@unlink($_SERVER["DOCUMENT_ROOT"].'/portal/report/report.xlsx');



?>