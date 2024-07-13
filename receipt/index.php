<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
//$f_date = $_GET['f_date'];
//$t_date = $_GET['t_date'];
$search= $_GET['search'];
$transaction_id= $_GET['transaction_id'];
$branch_nameS= $_GET['branch_nameS']== ''?"all":$_GET['branch_nameS'];
if($page=='') {
    $page=1;
}


$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}

//if($f_date == ''){
//    $f_date = date('Y-m-01');
//}
//if($t_date == ''){
//    $t_date = date('Y-m-d');
//}
//
//$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
//
//$to_date = date('Y-m-d 23:59:59',strtotime($t_date));

$currentDates = date('Y-m-d');
$twoDaysAhead = date('Y-m-d', strtotime($currentDates.'-1 days')); // Get the date 2 days ahead in the format compatible with your database

$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];

if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = "AND verify='1'";
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND verify='1' AND branch_name='$cookieBranch_Id'";

    }
    elseif($_COOKIE['role'] == 'Staff'){
        $addedBranchSerach = "AND verify='1' AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id' AND verify_date > '$twoDaysAhead'";

    }

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
if($transaction_id != ""){
    $transaction_id= "AND transaction_id = $transaction_id";
}
else{
    $transaction_id ="";
}

//else {
//    $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";
//
//}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Receipt</title>
    <link rel="icon" type="image/png" sizes="16x16" href="https://gcct.donatecrp.in/portal/images/favicon_New.png">


    <!--    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_New.png">-->
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css">

    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="../vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <link href="../vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">



    <link href="../vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="../vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="../vendor/pickadate/themes/default.date.css">
    <link href="../vendor/summernote/summernote.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


</head>
<style>
    .error {
        color:red;
    }

</style>
<body>


<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>

<div id="main-wrapper">


    <?php

    $header_name ="Receipt";
    Include ('../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Receipt</a></li>
                <!--<div style="display:flex;">-->
                <!--                <button type="button" class="btn btn-rounded btn-success" onclick="excel()"> Excel Download </button>-->
                <!--</div>-->
            </ol>
            <!--            <button type="button" class="excel_download btn btn-rounded btn-success"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i>-->
            <!--            </span>Excel Download</button>-->

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Receipt List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">
                            <?php
                            if($_COOKIE['role'] == 'Super Admin'){


                                ?>

                                <div class="form-group mx-sm-3 mb-2">

                                    <label>Branch</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="branch_nameS" name="branch_nameS" style="border-radius:20px;color:black;border:1px solid black;">
                                        <option value='all'>All</option>
                                        <?php
                                        $sqlDevice="SELECT * FROM `branch_profile`";
                                        $resultDevice=mysqli_query($conn,$sqlDevice);
                                        if(mysqli_num_rows($resultDevice) > 0)
                                        {
                                            while($rowDevice = mysqli_fetch_array($resultDevice)) {
                                                ?>

                                                <option value='<?php echo $rowDevice['branch_id'];?>' ><?php echo strtoupper($rowDevice['branch_name']);?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                                <?php
                            }
                            ?>

<!--                            <h5 class="text font-medium mr-auto">-->
<!--                                From Date-->
<!--                                <input type="date" id="f_date" name="f_date" class="form-control" value="--><?php //echo $from_date;?><!--"  min="1900-01-01" max="--><?php //echo date("Y-m-d")?><!--">-->
<!--                            </h5>-->
<!--                            <h5 class="text font-medium mr-auto" style="margin-right: 125px!important;">-->
<!--                                To Date-->
<!--                                <input type="date" id="t_date" name="t_date" class="form-control" value="--><?php //echo $to_date;?><!--"  min="1900-01-01" max="--><?php //echo date("Y-m-d")?><!--">-->
<!--                            </h5>-->
                            <!-- <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By Doner Name" name="search" id="search" style="border-radius:20px;color:black;" >
                            </div> -->

                            <div class="form-group mx-sm-3 mb-2">
                                <input type="text" class="form-control" placeholder="Search By Mobile" name="search" id="search" style="border-radius:20px;color:black;border:1px solid black;">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <input type="text" class="form-control" placeholder="Search By Transaction Id" name="transaction_id" id="transaction_id" style="border-radius:20px;color:black;border:1px solid black;">
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>
                        <!-- <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#career_list" style="margin-left: 20px;" onclick="addTitle()">ADD</button> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>ENTRY_DATE</strong></th>
                                <th><strong>DONATION_DATE</strong></th>
                                <th><strong>DONER_NAME</strong></th>
                                <th><strong>DONER_TYPE</strong></th>
                                <th><strong>PAN_NO</strong></th>
                                <th><strong>MOBILE_NO</strong></th>
                                <th><strong>AMOUNT</strong></th>
                                <th><strong>TRANSACTION ID</strong></th>
                                <th><strong>PAY_MODE</strong></th>
                                <th><strong>EMP_NAME</strong></th>
                                <th><strong>BRANCH</strong></th>
                                <th><strong>TYPE</strong></th>
                                <th><strong>BATCH_NAME</strong></th>
                                <th><strong>STATUS</strong></th>

                                <th><strong>Print PDF</strong></th>
                                <?php
                                if($_COOKIE['role'] == "Super Admin") {

                                    ?>
                                    <th><strong>ACTION</strong></th>
                                    <?php
                                }

                                ?>
                            </tr>
                            </thead>
                            <?php

//                            if ($branch_nameS == 'all' && $search == "" && $transaction_id== "") {
//                                $sql = "SELECT * FROM transaction WHERE id > 0 $addedBranchSerach ORDER BY id DESC LIMIT $start,10";
//
//                            } else {
//                                  $sql = "SELECT * FROM transaction WHERE id > 0 $branch_nameSSql$searchSql$addedBranchSerach$transaction_id ORDER BY id DESC LIMIT $start,10";
//                            }
//                            if ($branch_nameS == 'all' && $search == "") {
//                                $sql = "SELECT * FROM transaction WHERE date BETWEEN '$from_date' AND '$to_date' $addedBranchSerach ORDER BY id DESC LIMIT $start,10";
//
//                            } else {
//                                $sql = "SELECT * FROM transaction WHERE branch_name ='$branch_nameS' AND date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach$searchSql ORDER BY id DESC LIMIT $start,10";
//                               $sql = "SELECT * FROM transaction WHERE id > 0 $branch_nameSSql$searchSql$addedBranchSerach AND date  BETWEEN '$from_date' AND '$to_date' ORDER BY id  LIMIT $start,10";
//                            }

                            if ($branch_nameS == 'all' && $search == "" && $transaction_id== "") {
                                $sql = "SELECT * FROM transaction WHERE id > 0 $addedBranchSerach ORDER BY id DESC LIMIT $start,10";
                            } else {
                                  $sql = "SELECT * FROM transaction WHERE id > 0 $branch_nameSSql$searchSql$addedBranchSerach$transaction_id ORDER BY id DESC LIMIT $start,10";
                            }

                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;
                            $verify = $row["verify"];
                            if($verify == 1){
                                $verfied_content = "verified";
                            }
                            else{
                                $verfied_content = "unverified";
                            }

                            $verify_date = $row['verify_date'];

                            $currentDate = date('Y-m-d');

                            $v_date=date('Y-m-d', strtotime($verify_date. ' + 2 days'));
                            if($_COOKIE['role'] == 'Staff'){

                                if ($currentDate >= $v_date) {

                                    $disableButton = true;

                                } else {
                                    $disableButton = false;
                                }
                            }
                            $entry_date = $row['date'];
                            $edate = date('d-m-Y', strtotime($entry_date));
                            if($edate == '30-11--0001'){
                                $edate = 'NILL';
                            }
                            $donation_date= $row['donation_date'];
                            $ddate= date('d-m-Y', strtotime($donation_date));

                            $verify_date = $row['verify_date'];
                            
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

                            ?>

<!--                            --><?php
//                             Create a DateTime object for the current date
//                            $currentDate = new DateTime();
//
//                             Replace 'verifiedDate' with your actual verified date in the format 'Y-m-d H:i:s'
//                            $verifiedDate = new DateTime('2023-10-21 12:00:00');
//                            $verify_date;
//                             Subtract 2 days from the verified date
//                            $verify_date->sub(new DateInterval('P2D'));
//                            $verify_date->add(new DateInterval('P2D'));
//
//                             Compare the current date to the verified date minus 2 days
//                            if ($currentDate >= $verify_date) {
//                                $disableButton = true;
//
//                                    echo "urrent date is equal to or later than the verified date minus 2 days.";
//                            } else {
//                                $disableButton = false;
//
//                                    echo "Current date is earlier than the verified date minus 2 days.";
//                            }
//
//                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td> <?php echo $edate?> </td>
                                <td> <?php echo $ddate?> </td>
                                <td> <?php echo strtoupper($row['doner_name'])?> </td>
                                <td> <?php echo strtoupper($row['doner_type'])?> </td>
                                <td> <?php echo strtoupper($row['pan'])?> </td>
                                <td> <?php echo $row['mobile']?> </td>
                                <td> <?php echo $row['amount']?> </td>
                                <td><?php echo strtoupper($row['transaction_id'])?></td>
                                <td> <?php echo strtoupper($row['pay_mode'])?> </td>
                                <td> <?php echo strtoupper($added_byTable)?> </td>
                                <td> <?php echo strtoupper($branchNames)?> </td>
                                <td><?php echo strtoupper($row['type']) ?></td>
                                <td><?php echo strtoupper($batchName)?></td>
                                <td><?php echo strtoupper($verfied_content) ?></td>

                                    <td>
                                        <button <?php if ($disableButton) echo 'disabled'; ?>
                                                onclick="pdf('<?php echo $row['doner_name'] ?>','<?php echo $row['mobile'] ?>',
                                                        '<?php echo $row['amount'] ?>','<?php echo $row['date'] ?>','<?php echo $row['pan'] ?>','<?php echo $row['address'] ?>',
                                                        '<?php echo $row['mobile1'] ?>','<?php echo $row['pay_mode'] ?>','<?php echo $row['type'] ?>','<?php echo $row['transaction_id'] ?>','<?php echo $row['dob'] ?>','<?php echo $row['pay_id'] ?>','<?php echo $ddate ?>')"
                                                class="btn btn-success" type="button" id="pdf">PDF
                                        </button>
                                    </td>

                                <!-- <td><?php //echo $career_date?></td> -->


                                <?php
                                if($_COOKIE['role'] == "Super Admin") {

                                    ?>

                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-success light sharp"
                                                    data-toggle="dropdown">
                                                <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <circle fill="#000000" cx="5" cy="12" r="2"></circle>
                                                        <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                        <circle fill="#000000" cx="19" cy="12" r="2"></circle>
                                                    </g>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu">

                                                <a class="dropdown-item" data-toggle="modal" data-target="#career_list"
                                                   style="cursor: pointer"
                                                   onclick="editTitle('<?php echo $row['pay_id']; ?>')">Edit</a>

                                            </div>
                                        </div>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php } }
                            ?>

                            </tbody>
                        </table>

                        <div class="col-12 pl-3" style="display: flex;justify-content: center;">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">

                                    <?php

                                    $prevPage=abs($page-1);
                                    if ($prevPage > 0) {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link"
                                                                                href="?page_no=<?php echo 1 ?>&search=<?php echo $search ?>&branch_nameS=<?php echo $branch_nameS ?>&transaction_id=<?php echo $transaction_id ?>"><i
                                                    class="la la-angle-double-left"  style="padding-top: 9px;"></i></a></li>
                                        <?php
                                    }
                                    if($prevPage==0)
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="la la-angle-left" style ="margin-top: 8px;"></i></a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
<!--                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=--><?php //echo $prevPage?><!--&search=--><?php //echo $search?><!--&branch_nameS=--><?php //echo $branch_nameS ?><!--&f_date=--><?php //echo $f_date ?><!--&t_date=--><?php //echo $t_date ?><!--"><i class="la la-angle-left" style ="margin-top: 8px;"></i></a></li>-->
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&search=<?php echo $search?>&branch_nameS=<?php echo $branch_nameS ?>&transaction_id=<?php echo $transaction_id ?>"><i class="la la-angle-left" style ="margin-top: 8px;"></i></a></li>
                                        <?php
                                    }

//                                    if ($branch_nameS == 'all') {
//                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE verify = 1 AND date  BETWEEN '$from_date' AND '$to_date'";
//
//                                    } else {
//                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE verify = 1 AND branch_name ='$branch_nameS' AND date  BETWEEN '$from_date' AND '$to_date'";
//                                    }
                                    if ($branch_nameS == 'all' && $search == "" && $transaction_id == "") {
                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE id > 0 $addedBranchSerach";

                                    } else {
                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE id > 0 $branch_nameSSql$searchSql$addedBranchSerach$transaction_id";
                                    }

//                                    if ($branch_nameS == 'all' && $search == "") {
//                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE verify = 1 AND date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach";
//
//                                    } else {
//                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE mobile = '$search' AND verify = 1 AND branch_name ='$branch_nameS' AND date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach";
//                                    }
                                    // $sql = 'SELECT COUNT(id) as count FROM  transaction;';
                                    $result = mysqli_query($conn, $sql);


                                    if (mysqli_num_rows($result)) {

                                        $row = mysqli_fetch_assoc($result);
                                        $count = $row['count'];
                                        $show = 10;


                                        $get = $count / $show;


                                        $pageFooter = floor($get);

                                        if ($get > $pageFooter) {
                                            $pageFooter++;
                                        }

                                        for ($i = 1; $i <= $pageFooter; $i++) {

                                            if($i==$page) {
                                                $active = "active";
                                            }
                                            else {
                                                $active = "";
                                            }

                                            if($i<=($pageSql+10) && $i>$pageSql || $pageFooter<=10) {

                                                ?>

                                                <li class="page-item <?php echo $active ?>"><a class="page-link"
                                                                                               href="?page_no=<?php echo $i ?>&search=<?php echo $search?>&branch_nameS=<?php echo $branch_nameS ?>&transaction_id=<?php echo $transaction_id ?>"><?php echo $i ?></a>
                                                </li>
                                                <?php
                                            }
                                        }

                                        $nextPage=$page+1;


                                        if($nextPage>$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="la la-angle-right" style ="margin-top: 8px;"></i></a></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&search=<?php echo $search?>&branch_nameS=<?php echo $branch_nameS ?>&transaction_id=<?php echo $transaction_id ?>"><i class="la la-angle-right" style ="margin-top: 8px;"></i></a></li>
                                            <?php
                                        }
                                        if($nextPage<$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $pageFooter ?>&search=<?php echo $search?>&branch_nameS=<?php echo $branch_nameS ?>&transaction_id=<?php echo $transaction_id ?>"><i class="la la-angle-double-right"></i></a></li>
                                            <?php
                                        }
                                    }
                                    ?>

                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="career_list"  data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">


                        <h5 class="modal-title" id="title">pay Details</h5>

                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">




                        <div class="basic-form" style="color: black;">
                            <form id="pay_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Mobile *</label>
                                        <input type="number" class="form-control" placeholder="Mobile" id="mobile" name="mobile" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Doner Name *</label>
                                        <input type="text" class="form-control" placeholder="Doner Name" id="doner_name" name="doner_name" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="doner_id" name="doner_id">
                                        <input type="hidden" class="form-control"  id="pay_id" name="pay_id">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Doner Type</label>
                                        <select  class="form-control" id="doner_type" name="doner_type" style="border-color: #181f5a;color: black">
                                            <option value=''>Select Type</option>
                                            <option value='NEW'>NEW</option>
                                            <option value='OLD'>OLD</option>
                                            <option value='TRUST'>TRUST</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>D.O.B </label>
                                        <input type="date" max="<?php echo date("Y-m-d")?>" class="form-control" placeholder="DOB" id="dob" name="dob" style="border-color: #181f5a;color: black">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Donation Date*</label>
                                        <input type="date" class="form-control" placeholder="Donation  Date" id="donation_date" name="donation_date" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Time *</label>
                                        <input type="text" class="form-control" placeholder=" Donation Time" id="donation_time" name="donation_time" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Alter Mobile </label>
                                        <input type="number" class="form-control" placeholder="Alter mobile" id="mobile1" name="mobile1" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Amount *</label>
                                        <input type="number" class="form-control" placeholder="amount" id="amount" name="amount" style="border-color: #181f5a;color: black">
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label>Pan No </label>
                                        <input type="text"  class="form-control" placeholder="Pan No" id="pan" name="pan" style="border-color: #181f5a;color: black; text-transform: uppercase;">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Transaction ID *</label>
                                        <input type="text" class="form-control" placeholder="Transaction ID" id="transaction_id" name="transaction_id" style="border-color: #181f5a;color: black; text-transform: uppercase;">
                                    </div>
                                    <!--                                    <input type="text" class="form-control " id="email" onkeypress="return emailKey(event)" name="email" placeholder="example@gmail.com">-->
                                    <!--                                    <p id="vemail" class="required" style="color:red"></p>-->

                                    <div class="form-group col-md-12">
                                        <label>Address </label>
                                        <textarea class="form-control" placeholder="Address" id="address" name="address" cols="70" rows="4" style="border: 1px solid black;color: black;text-transform: uppercase"></textarea>

                                    </div>

                                    <!-- <div class="form-group col-md-12">
                                        <label>Date of joining *</label>
                                        <input type="date" class="form-control"  max="<?php //echo date("Y-m-d")?>" id="doj" name="doj" placeholder="Date of joining" style="border-color: #181f5a;color: black">
                                    </div>  -->

                                    <div class="form-group col-md-6">
                                        <label>Type</label>
                                        <select  class="form-control" id="type" name="type" style="border-color: #181f5a;color: black">
                                            <option value='Normal'>NORMAL</option>
                                            <option value='80G'>80 G</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Payment Mode </label>
                                        <input type="text"  class="form-control" placeholder="Payment Mode" id="pay_mode" name="pay_mode" style="border-color: #181f5a;color: black; text-transform: uppercase;">
                                    </div>

                                    <?php
                                    $branchA= $_COOKIE['branch_id'];
                                    $sqlbranch = "SELECT * FROM `branch_profile` WHERE branch_id='$branchA'";
                                    $resultBranch = mysqli_query($conn, $sqlbranch);
                                    if (mysqli_num_rows($resultBranch) > 0) {
                                        $rowBranch = mysqli_fetch_assoc($resultBranch);
                                        $branch = $rowBranch['branch_name'];
                                    }
                                    $staffA= $_COOKIE['staff_id'];
                                    $sqlstaff = "SELECT * FROM `staff_profile` WHERE staff_id='$staffA'";
                                    $resultstaff = mysqli_query($conn, $sqlstaff);
                                    if (mysqli_num_rows($resultstaff) > 0) {
                                        $rowstaff = mysqli_fetch_assoc($resultstaff);
                                        $staff = $rowstaff['staff_name'];
                                    }
                                    else{
                                        $sqlbranchD = "SELECT * FROM `branch_profile` WHERE branch_id='$staffA'";
                                        $resultBranchD = mysqli_query($conn, $sqlbranchD);
                                        if (mysqli_num_rows($resultBranchD) > 0) {
                                            $rowBranchD = mysqli_fetch_assoc($resultBranchD);
                                            $staff = $rowBranchD['incharge'];
                                        }
                                    }
                                    ?>

                                    <div class="form-group col-md-6">
                                        <label>Emp Name</label>
                                        <input type="text" value="<?php echo $staff?>" readonly class="form-control" placeholder="Emp Name" id="added_by" name="added_by" style="border-color: #181f5a;color: black; text-transform: uppercase;">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Branch Name</label>
                                        <input type="text" value="<?php echo $branch?>" readonly class="form-control" placeholder="Branch Name" id="branch_name" name="branch_name" style="border-color: #181f5a;color: black; text-transform: uppercase;">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="upload_image">Image (1 MB)</label>
                                        <input type="file" class="form-control" placeholder="Upload Image" id="upload_image" name="upload_image" style="border-color: #181f5a;color: black" accept=".jpg,.jpeg">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Remark </label>
                                        <input type="text" class="form-control" placeholder="Remark" id="remark" name="remark" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    </div>
                                </div>

                            </form>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <?php
                        if($_COOKIE['role'] == 'Super Admin'){
                            ?>

                            <button type="button" class="btn btn-succes" id="verify_btn" onclick= "verify()" style="background-color: green; color: white;">Verify</button>
                            <?php
                        }
                        ?>
                        <?php
                        if($_COOKIE['role'] == 'Admin'){
                            ?>

                            <button type="button" class="btn btn-succes" id="confirm_btn" onclick= "confirm()" style="background-color: green; color: white;">Confirm</button>
                            <?php
                        }
                        ?>
                        <!-- <button type="button" class="btn btn-succes" id="add_btn" style="background-color: green; color: white;">Verify</button> -->
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;text-transform: uppercase">Close</button>
                        <button type="button" class="btn btn-primary" id="add_btn">ADD</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php Include ('../includes/footer.php') ?>

</div>

<script src="../vendor/global/global.min.js"></script>
<script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../js/custom.min.js"></script>
<script src="../js/dlabnav-init.js"></script>
<script src="../vendor/owl-carousel/owl.carousel.js"></script>

<script src="../vendor/peity/jquery.peity.min.js"></script>

<!--<script src="../vendor/apexchart/apexchart.js"></script>-->

<script src="../js/dashboard/dashboard-1.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../vendor/jquery-validation/jquery.validate.min.js"></script>

<script src="../js/plugins-init/jquery.validate-init.js"></script>


<script src="../vendor/moment/moment.min.js"></script>
<script src="../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>



<script src="../vendor/summernote/js/summernote.min.js"></script>
<script src="../js/plugins-init/summernote-init.js"></script>



<script>
    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');
        $('#f_date').val('<?php echo $f_date;?>');
        $('#t_date').val('<?php echo $t_date;?>');
        $('#branch_nameS').val('<?php echo $branch_nameS;?>');

    });

    // $(document).on("click", ".excel_download", function () {
    //     window.location.href = "excel_download.php";
    //
    // });

    function pdf(name,mobile,amount,date,pan,address,mobile1,pay_mode,type,transaction_id,dob,pay_id,donation_date) {
       // $("#pdf").attr("disabled", true);

        window.location.href= 'https://gcct.donatecrp.in/portal/receipt/dompdf.php?name='+name+'&mobile='+mobile+'&amount='+amount+'&date='+date+'&pan='+pan+'&mobile1='+mobile1+'&address='+address+'&pay_mode='+pay_mode+'&type='+type+'&transaction_id='+transaction_id+'&dob='+dob+'&pay_id='+pay_id+'&donation_date='+donation_date;

        var role= getCookie('role');

        if(role==="Staff")
        {
            var button = document.getElementById('pdf');
            button.disabled = true;
        }

    }

    // function Pdf(name,mobile){
    //     window.location.href=`https://trusterp.gbtechcorp.com/trust_crm/receipt/pdf.php?name=${name}&mobile=${mobile}`;
    // https://www.example.com/index.html?name1=value1&name2=value2
    //alert(name,mobile);
    // window.location.href = 'pdf.php?name="+name+"&mobile="mobile"';
    // }
</script>
<script>




    var roll_cokkie =  getCookie('role');

    function addTitle() {
        $("#title").html("Add Transaction");
        $('#pay_form')[0].reset();
        $('#api').val("add1_api.php")
        // $('#game_id').prop('readonly', false);

        if(roll_cokkie == 'Super Admin'){
            document.getElementById('verify_btn').hidden = true;

        }
        else if(roll_cokkie == 'Admin'){
            document.getElementById('confirm_btn').hidden = true;

        }

        document.getElementById('upload_image').classList.remove('ignore');
    }

    function editTitle(data) {

        $("#title").html("Edit Receipt- "+data);
        $('#pay_form')[0].reset();
        $('#api').val("edit_api.php");
        if(roll_cokkie == 'Super Admin'){
            document.getElementById('verify_btn').hidden = false;
        }
        else if(roll_cokkie == 'Admin'){
            document.getElementById('confirm_btn').hidden = false;

        }

        document.getElementById('upload_image').classList.add('ignore');
        $.ajax({

            type: "POST",
            url: "view_api.php",
            data: 'pay_id='+data,
            dataType: "json",
            success: function(res){
                if(res.status=='success')
                {
                    $("#pay_id").val(res.pay_id);
                    $("#transaction_id").val(res.transaction_id);
                    $("#doner_name").val(res.doner_name);
                    $("#donation_date").val(res.donation_date);
                    $("#donation_time").val(res.donation_time);
                    $("#doner_type").val(res.doner_type);
                    $("#dob").val(res.dob);

                    $("#mobile").val(res.mobile);
                    $("#amount").val(res.amount);
                    $("#address").val(res.address);
                    $("#pan").val(res.pan);
                    $("#pay_mode").val(res.pay_mode);
                    $("#branch_name").val(res.branch_name);
                    $("#added_by").val(res.added_by);
                    $("#doner_id").val(res.doner_id);
                    $("#remark").val(res.remark);
                    $("#mobile1").val(res.mobile1);
                    $("#type").val(res.type);


                    //    $("#access_type").val(res.access_type);
                    //    $("#access_status").val(res.access_status);



                    $("#old_pa_id").val(res.pay_id);
                    $("#pay_id").val(res.pay_id);

                    //    if(Number(res.access_status) == 1){
                    //         document.getElementById("access_status").checked = true;
                    //     }
                    //     else {
                    //         document.getElementById("access_status").checked = false;

                    //     }




                    // $('#game_id').prop('readonly', true);

                    var edit_model_title = "Edit Receipt - "+data;
                    $('#title').html(edit_model_title);
                    $('#add_btn').html("Save");


                    $('#career_list').modal('show');


                }
                else if(res.status=='wrong')
                {
                    swal("Invalid",  res.msg, "warning")
                        .then((value) => {
                            window.window.location.reload();
                        });

                }
                else if(res.status=='failure')
                {
                    swal("Failure",  res.msg, "error")
                        .then((value) => {
                            window.window.location.reload();

                        });

                }
            },
            error: function(){
                swal("Check your network connection");

                window.window.location.reload();

            }

        });

    }



    //to validate form
    $("#pay_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {

                doner_name: {
                    required: true
                },
                doner_type: {
                    required: true
                },
                // dob: {
                //     required: true
                // },
                transaction_id: {
                    required: true
                },
                // address: {
                //     required: true
                // },

                mobile: {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                },
                mobile1: {
                    // required: true,
                    maxlength: 10,
                    minlength: 10
                },
                amount: {
                    required: true
                },

                pan: {
                    //required: true,
                    maxlength: 10,
                    minlength: 10

                },
                pay_mode: {
                    required: true
                },
                branch_name: {
                    required: true
                },
                upload_image: {
                    required: true
                },
                added_by: {
                    required: true
                },




            },
            // Specify validation error messages
            messages: {
                doner_name: "*This field is required",
                doner_type: "*This field is required",
                // dob: "*This field is required",
                transaction_id: "*This field is required",
                // address: "*This field is required",

                mobile: {
                    required:"*This field is required",
                    maxlength:"*Mobile Number Should Be 10 Character",
                    minlength:"*Mobile Number Should Be 10 Character"
                },
                mobile1: {
                    // required:"*This field is required",
                    maxlength:"*Mobile Number Should Be 10 Character",
                    minlength:"*Mobile Number Should Be 10 Character"
                },
                pan: {
                    //required:"*This field is required",
                    maxlength:"*pan Number Should Be 10 Character",
                    minlength:"*pan Number Should Be 10 Character"
                },
                amount: "*This field is required",
                //pan: "*This field is required",
                pay_mode: "*This field is required",
                branch_name: "*This field is required",
                added_by: "*This field is required",
                upload_image: "*This field is required",

            }
            // Make sure the form is submitted to the destination defined
        });

    //add data

    $('#add_btn').click(function () {

        $("#pay_form").valid();

        if ($("#pay_form").valid() == true) {

            var pan_number = document.getElementById("pan").value;

            var isValidPan = panValid(pan_number);
            console.log(isValidPan);

            if (isValidPan == 0) {

                var api = $('#api').val();
                var form = $("#pay_form");

                var formData = new FormData(form[0]);
                //formData.append("active_status",access_status);

                this.disabled = true;
                this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                $.ajax({

                    type: "POST",
                    url: api,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        if (res.status == 'success') {
                            Swal.fire(
                                {
                                    title: "Success",
                                    text: res.msg,
                                    icon: "success",
                                    button: "OK",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                }
                            )
                                .then((value) => {
                                    window.window.location.reload();
                                });
                        } else if (res.status == 'failure') {

                            Swal.fire(
                                {
                                    title: "Failure",
                                    text: res.msg,
                                    icon: "warning",
                                    button: "OK",
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    closeOnClickOutside: false,
                                }
                            )
                                .then((value) => {

                                    document.getElementById("add_btn").disabled = false;
                                    document.getElementById("add_btn").innerHTML = 'Add';
                                });

                        }
                    },
                    error: function () {

                        Swal.fire('Check Your Network!');
                        document.getElementById("add_btn").disabled = false;
                        document.getElementById("add_btn").innerHTML = 'Add';
                    }

                });
            }
            else{
                Swal.fire('invalid pan No');
            }


        } else {
            document.getElementById("add_btn").disabled = false;
            document.getElementById("add_btn").innerHTML = 'Add';

        }


    });


    //
    //delete model

    function delete_model(data) {

        Swal.fire({
            title: "Delete",
            text: "Are you sure want to delete the record?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            closeOnClickOutside: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        })
            .then((value) => {
                if(value.isConfirmed) {

                    $.ajax({

                        type: "POST",
                        url: "delete_api.php",
                        data: 'pay_id='+data,
                        dataType: "json",
                        success: function(res){
                            if(res.status=='success')
                            {
                                Swal.fire(
                                    {
                                        title: "Success",
                                        text: res.msg,
                                        icon: "success",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();

                                    });
                            }
                            else if(res.status=='failure')
                            {
                                swal(
                                    {
                                        title: "Failure",
                                        text: res.msg,
                                        icon: "warning",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();
                                    });

                            }
                        },
                        error: function(){
                            swal("Check your network connection");

                        }

                    });

                }

            });

    }

    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');
        $('#branch_nameS').val('<?php echo $branch_nameS;?>');
        //$('#statuss').val('<?php //echo $statuss;?>//');

        $('#transaction_id').val('<?php echo $transaction_id;?>');


    });

    function verify() {

        Swal.fire({
            title: "Verify",
            text: "Are you sure want to verify the record",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            closeOnClickOutside: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        })
            .then((value) => {
                if(value.isConfirmed) {
                    var pay_id = document.getElementById("pay_id").value;
                    var doner_id = document.getElementById("doner_id").value;
                    $.ajax({

                        type: "POST",
                        url: "verify_api.php",
                        data: 'pay_id='+pay_id+'&doner_id='+doner_id,
                        dataType: "json",
                        success: function(res){
                            if(res.status=='success')
                            {
                                Swal.fire(
                                    {
                                        title: "Success",
                                        text: res.msg,
                                        icon: "success",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();

                                    });
                            }
                            else if(res.status=='failure')
                            {
                                swal(
                                    {
                                        title: "Failure",
                                        text: res.msg,
                                        icon: "warning",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();
                                    });

                            }
                        },
                        error: function(){
                            swal("Check your network connection");

                        }

                    });
                }
            });

    }
    //confirm ajax
    function confirm() {

        Swal.fire({
            title: "Confirm",
            text: "Are you sure want to Ccnfirm the record",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            closeOnClickOutside: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        })
            .then((value) => {
                if(value.isConfirmed) {
                    var pay_id = document.getElementById("pay_id").value;
                    var doner_id = document.getElementById("doner_id").value;
                    $.ajax({

                        type: "POST",
                        url: "confirm_api.php",
                        data: 'pay_id='+pay_id+'&doner_id='+doner_id,
                        dataType: "json",
                        success: function(res){
                            if(res.status=='success')
                            {
                                Swal.fire(
                                    {
                                        title: "Success",
                                        text: res.msg,
                                        icon: "success",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();

                                    });
                            }
                            else if(res.status=='failure')
                            {
                                swal(
                                    {
                                        title: "Failure",
                                        text: res.msg,
                                        icon: "warning",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();
                                    });

                            }
                        },
                        error: function(){
                            swal("Check your network connection");

                        }

                    });
                }
            });

    }
    //if pay mode is offline img field not mandatory
    $('#pay_mode').on('change', function() {
        if(this.value == 'offline'){
            document.getElementById('upload_image').classList.add('ignore');
        }
        else{
            document.getElementById('upload_image').classList.remove('ignore');
        }

    });




    function panValid(pan){
        let isValid = 0;

        for(let i =0;i<pan.length;i++){

            let changeIntoNumber = Number(pan[i]);

            if(i == 0){
                if(!isNaN(changeIntoNumber)){
                    isValid = 1;

                }
            }


            if(i == 9){
                if(!isNaN(changeIntoNumber)){
                    isValid = 1;

                }
            }

        }
        if(isValid == 0){
            console.log("pan valid");
            return 0;
        }
        else {
            console.log("pan Not valid");
            return 1;
        }

    }



    $("#mobile").keyup(function(){
        let num = this.value;

        if(num.length == 10){

            $.ajax({

                type: "POST",
                url: "mobile_api.php",
                data: 'mobile_num='+num,
                dataType: "json",
                success: function(res){
                    if(res.status=='success')
                    {
                        $("#doner_name").val(res.doner_name);
                        // $("#doner_type").val(res.doner_type);
                        //$("#mobile").val(res.mobile);
                        $("#address").val(res.address);
                        $("#pan").val(res.pan);


                    }
                    else if(res.status=='wrong')
                    {

                    }
                    else if(res.status=='failure')
                    {


                    }
                },
                error: function(){


                }

            });

        }


    });

    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?search=<?php echo $search?>&branch_nameS=<?php echo $branch_nameS?>&batch_ids=<?php echo $batch_ids?>&statuss=<?php echo $statuss?>";
    });



    //to validate form
    $("#itemProfileExcel").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {

                file: {
                    required: true
                },

            }
            // Make sure the form is submitted to the destination defined
        });

    $(document).on("click", ".btnn_excel_ajax", function () {

        $("#itemProfileExcel").valid();
        if($("#itemProfileExcel").valid()==true) {
            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

            var file_data = $('#excel_file').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: 'excel_insert.php', // point to server-side PHP script
                dataType: 'json',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (res) {
                    if (res.status == 'success') {
                        Swal.fire(
                            {
                                title: "Success",
                                text: res.msg,
                                icon: "success",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {
                                window.window.location.reload();

                            });
                    } else if (res.status == 'failure') {
                        Swal.fire(
                            {
                                title: "Failure",
                                text: res.msg,
                                icon: "warning",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {
                                window.window.location.reload();
                            });

                    }
                },
                error: function () {
                    Swal.fire("Check your network connection");
                    document.getElementById("btnn_excel_ajax").disabled = false;
                    document.getElementById("btnn_excel_ajax").innerHTML = 'Upload';
                }

            });
        }
        else {
            document.getElementById("btnn_excel_ajax").disabled = false;
            document.getElementById("btnn_excel_ajax").innerHTML = 'Upload';

        }


    });

</script>

</body>
</html>
