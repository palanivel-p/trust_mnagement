<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$search= $_GET['search'];
$branch_nameS= $_GET['branch_nameS']== ''?"all":$_GET['branch_nameS'];
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
    <title>Report</title>
    <link rel="icon" type="image/png" sizes="16x16" href="https://trusterp.gbtechcorp.com/trust_crm/images/favicon_New.png">


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

$header_name ="Report";
    Include ('../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Report</a></li>
                <!--<div style="display:flex;">-->
                <!--                <button type="button" class="btn btn-rounded btn-success" onclick="excel()"> Excel Download </button>-->
                <!--</div>-->
            </ol>
            <div class="d-flex justify-content-end">
                <button type="button" class="excel_download btn btn-rounded btn-success"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i>
            </span>Excel Download</button>
            </div>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Report List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">
                            <div class="form-group mx-sm-3 mb-2">
                                <label>Status</label>
                                <select data-search="true" class="form-control tail-select w-full" id="statuss" name="statuss" style="border-radius:20px;color:black;border:1px solid black;">
                                    <option value='all'>All</option>
                                    <option value= 1 >verified</option>
                                    <option value= 3 >Not Ok</option>

                                </select>
                            </div>
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

                                    <h5 class="text font-medium mr-auto">
                                            From Date
                                            <input type="date" id="f_date" name="f_date" class="form-control" value="<?php echo $from_date;?>"  min="1900-01-01" max="<?php echo date("Y-m-d")?>">
                                    </h5>
                                        <h5 class="text font-medium mr-auto">
                                            To Date
                                            <input type="date" id="t_date" name="t_date" class="form-control" value="<?php echo $to_date;?>"  min="1900-01-01" max="<?php echo date("Y-m-d")?>">
                                        </h5>
                             <div class="form-group mx-sm-3 mb-2">
                                <input type="text" class="form-control" placeholder="Search By Mobile" name="search" id="search" style="border-radius:20px;color:black;border:1px solid black;">
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
                                <th><strong>PAN_NO</strong></th>
                                <th><strong>MOBILE_NO</strong></th>
                                <th><strong>AMOUNT</strong></th>
                                <th><strong>TRANSACTION ID</strong></th>
                                <th><strong>PAY_MODE</strong></th>
                                <th><strong>EMP_NAME</strong></th>
                                <th><strong>BRANCH</strong></th>
                                <th><strong>TYPE</strong></th>
                                <th><strong>BATCH_NAME</strong></th>
                                <th><strong>REMARK</strong></th>
                                <th><strong>STATUS</strong></th>

                            </tr>
                            </thead>
                            <?php
                           if ($branch_nameS == 'all'&& $statuss == "all" && $search =="") {
                                 $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach$statussSql ORDER BY id DESC LIMIT $start,10";

                        } else {
                                 $sql = "SELECT * FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $searchSql$statussSql$addedBranchSerach$branch_nameSSql ORDER BY id DESC LIMIT $start,10";
                        }

                            // if($branch_nameS == "all") {
                            //     $sql = "SELECT * FROM transaction  ORDER BY id  LIMIT $start,10";
                            // }
                            // elseif($search != "" && $branch_nameS == "all") {
                            //     $sql = "SELECT * FROM installation WHERE staff_id='$staffs_id' AND date_time  BETWEEN '$from_date' AND '$to_date' ORDER BY id DESC LIMIT $start,10";

                            //     $sql = "SELECT * FROM transaction WHERE doner_name LIKE '%$search%' ORDER BY id  LIMIT $start,10";
                            // }
                            // elseif($search == "" && $branch_nameS != "all") {
                            //     $sql = "SELECT * FROM transaction WHERE doner_name = '$branch_nameS' ORDER BY id  LIMIT $start,10";
                            // }
                            // else {
                            //     $sql = "SELECT * FROM transaction WHERE doner_name LIKE '%$search%' AND branch_name = '$branch_nameS ORDER BY id  LIMIT $start,10";
                            // }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;
                            $verify = $row["verify"];
                            if($verify == 1){
                                $verfied_content = "VERIFIED";
                            }
                            else if($verify == 2){
                                $verfied_content = "CONFIRMED";
                            }
                             else if($verify == 0){
                                $verfied_content = "UNVERIFIED";
                            }
                             else{
                                 $verfied_content = "NOT OK";
                             }
                            $entry_date = $row['date'];
                            $edate = date('d-m-Y', strtotime($entry_date));
                            if($edate == '30-11--0001'){
                                $edate = 'NILL';
                            }
                            $donation_date= $row['donation_date'];
                            $ddate= date('d-m-Y', strtotime($donation_date));
                            // $img = $row['img'];
                            // if($img == 1) {
                            //     $img_upload = "badge-success";
                            //     $img_modal = '#image_modal';
                            // }
                            // else {
                            //     $img_upload = "badge-danger";
                            // }
                        //   $career_dates =   $row['career_date'];
                        //   $career_date =   date('d-F-Y');

                            //   $branchId = $row['branch_name'];
                            //
                            // $sqlbranchName="SELECT * FROM `branch_profile` WHERE branch_id='$branchId'";
                            // $resultBranchName=mysqli_query($conn,$sqlbranchName);
                            // if(mysqli_num_rows($resultBranchName) > 0) {
                            //  $rowBranchName = mysqli_fetch_assoc($resultBranchName);
                            //
                            //   $branchName = $rowBranchName['branch_name'];
                            //
                            //   }

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
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td> <?php echo $edate?> </td>
                                <td> <?php echo $ddate?> </td>
                                <td> <?php echo strtoupper($row['doner_name'])?> </td>
                                <td> <?php echo strtoupper($row['pan'])?> </td>
                                <td> <?php echo $row['mobile']?> </td>
                                <td> <?php echo $row['amount']?> </td>
                                <td><?php echo strtoupper($row['transaction_id'])?></td>
                                <td> <?php echo strtoupper($row['pay_mode'])?> </td>
                                <td> <?php echo strtoupper($added_byTable)?> </td>
                                <td> <?php echo strtoupper($branchNames)?> </td>
                                <td><?php echo strtoupper($row['type']) ?></td>
                                <td><?php echo strtoupper($batchName)?></td>
                                <td><?php echo strtoupper($row['remark'])?></td>
                                <td><?php echo strtoupper($verfied_content) ?></td>
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
                                                                                href="?page_no=<?php echo 1 ?>&branch_nameS=<?php echo $branch_nameS?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>&statuss=<?php echo $statuss?>&search=<?php echo $search?>"><i
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
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&branch_nameS=<?php echo $branch_nameS?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>&statuss=<?php echo $statuss?>&search=<?php echo $search?>"><i class="la la-angle-left" style ="margin-top: 8px;"></i></a></li>
                                        <?php
                                    }

//                                    if ($branch_nameS == 'all') {
//                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE verify = 1 AND date  BETWEEN '$from_date' AND '$to_date'";
//
//                                    } else {
//                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE verify = 1 AND branch_name ='$branch_nameS' AND date  BETWEEN '$from_date' AND '$to_date'";
//                                    }
                                    if ($branch_nameS == 'all' && $statuss == "all") {
                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach$statussSql";

                                    } else {
                                        $sql = "SELECT COUNT(id) as count FROM transaction WHERE date  BETWEEN '$from_date' AND '$to_date' $searchSql$statussSql$addedBranchSerach$branch_nameSSql";
                                    }

//                                    $sql = 'SELECT COUNT(id) as count FROM  transaction;';
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
                                                                                               href="?page_no=<?php echo $i ?>&branch_nameS=<?php echo $branch_nameS?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>&statuss=<?php echo $statuss?>&search=<?php echo $search?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&branch_nameS=<?php echo $branch_nameS?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>&statuss=<?php echo $statuss?>&search=<?php echo $search?>"><i class="la la-angle-right" style ="margin-top: 8px;"></i></a></li>
                                            <?php
                                        }
                                        if($nextPage<$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $pageFooter ?>&branch_nameS=<?php echo $branch_nameS?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>&statuss=<?php echo $statuss?>&search=<?php echo $search?>"><i class="la la-angle-double-right"></i></a></li>
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

    </div>



    </div>



    <?php Include ('../includes/footer.php') ?>



</div>

<script>

</script>

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
        $('#f_date').val('<?php echo $from_date;?>');
        $('#t_date').val('<?php echo $to_date;?>');
        $('#branch_nameS').val('<?php echo $branch_nameS;?>');
        $('#statuss').val('<?php echo $statuss;?>');
        $('#search').val('<?php echo $search;?>');

    });

    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?&branch_nameS=<?php echo $branch_nameS?>&f_date=<?php echo $from_date?>&t_date=<?php echo $to_date?>&statuss=<?php echo $statuss?>&search=<?php echo $search?>";
    });

    // function pdf(name,mobile) {
    //    // window.location.href = 'pdf.php?name="+name+"&mobile="mobile"';
    //     window.location.href = 'https://trusterp.gbtechcorp.com/trust_crm/receipt/pdf.php?name=name&mobile=mobile';
    //    // https://www.example.com/index.html?name1=value1&name2=value2
    // }
    // function Pdf(name,mobile){
    //     window.location.href=`pdf.php?name=${name}&mobile=${mobile}`;
    //
    // }
</script>


</body>
</html>
