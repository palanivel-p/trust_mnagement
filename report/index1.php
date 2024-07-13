<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$search= $_GET['search'];
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
    <title>Report1</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_New.png">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    $header_name ="Report1";
    Include ('../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Report1</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <!--                    <h4 class="card-title">Transaction List</h4>-->
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">
                            <div class="form-group mx-sm-3 mb-2">
                                <label>Status</label>
                                <select data-search="true" class="form-control tail-select w-full" id="statuss" name="statuss" style="border-radius:20px;color:black;border:1px solid black;">
                                    <option value='all'>All</option>
                                    <option value= 1 >Verify</option>
                                    <option value= 0 >Unverify</option>

                                </select>
                            </div>
                            <label>Batch</label>
                            <select data-search="true" class="form-control tail-select w-full" id="batch_ids" name="batch_ids" style="border-radius:20px;color:black;border:1px solid black;">
                                <option value='all'>All</option>
                                <?php

                                $sqlDevice="SELECT * FROM `batch_profile`";
                                $resultDevice=mysqli_query($conn,$sqlDevice);
                                if(mysqli_num_rows($resultDevice) > 0)
                                {
                                    while($rowDevice = mysqli_fetch_array($resultDevice)) {
                                        ?>

                                        <!-- <option value='<?php //echo $rowDevice['branch_name'];?>' ><?php //echo strtoupper($rowDevice['branch_name']);?></option> -->
                                        <option value='<?php echo $rowDevice['batch_id'];?>' ><?php echo $rowDevice['batch_name'];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>

                            <?php
                            if($_COOKIE['role'] == 'Super Admin'){


                                ?>


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

                                            <!-- <option value='<?php //echo $rowDevice['branch_name'];?>' ><?php //echo strtoupper($rowDevice['branch_name']);?></option> -->
                                            <option value='<?php echo $rowDevice['branch_id'];?>' ><?php echo $rowDevice['branch_name'];?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>

                                <?php
                            }
                            ?>


                            <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By Mobile" name="search" id="search" style="border-radius:20px;color:black;border:1px solid black;">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>

                        <?php
                        if($_COOKIE['role'] != 'Super Admin'){


                            ?>
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#career_list" style="margin-left: 20px;" onclick="addTitle()">ADD</button>
                            <?php
                        }
                        ?>


                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <!-- <th><strong>Payment ID</strong></th> -->
                                <th><strong>Doner Name</strong></th>
                                <th><strong>mobile</strong></th>
                                <th><strong>Pan No</strong></th>
                                <th><strong>Amount</strong></th>
                                <th><strong>Address</strong></th>
                                <th><strong>Payment method</strong></th>
                                <th><strong>Branch Name</strong></th>
                                <th><strong>Date & Time</strong></th>
                                <th><strong>Added By</strong></th>
                                <!-- <th><strong>Status</strong></th> -->
                                <!-- <th><strong>Action</strong></th> -->

                            </tr>
                            </thead>
                            <?php
                            if ($branch_nameS == 'all') {
                                $sql = "SELECT * FROM transaction WHERE verify = 1 AND date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach ORDER BY id DESC LIMIT $start,10";

                            } else {
                                $sql = "SELECT * FROM transaction WHERE verify = 1 AND branch_name ='$branch_nameS' AND date  BETWEEN '$from_date' AND '$to_date' $addedBranchSerach ORDER BY id DESC LIMIT $start,10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;

                            $staffId = $row['added_by'];

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
                                <!-- <td><?php //echo $row['pay_id']?></td> -->

                                <td> <?php echo $row['doner_name']?> </td>
                                <td> <?php echo $row['mobile']?> </td>
                                <td> <?php echo $row['pan']?> </td>
                                <td> <?php echo $row['amount']?> </td>
                                <td> <?php echo $row['address']?> </td>

                                <!-- <td style="cursor: pointer">   <span class="badge badge-pill <?php //echo $img_upload?> ml-2" data-toggle="modal" data-target="<?php //echo $img_modal?>" onclick="imgModal('<?php// echo $row['team_id']; ?>')"> -->

                                <td> <?php echo $row['pay_mode']?> </td>

                                <td> <?php echo $branchName?> </td>
                                <td> <?php echo $row['date']?> </td>
                                <td> <?php echo $added_by ?> </td>
                                <!-- <td><?php //echo $career_date?></td> -->


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

                                    if($prevPage==0)
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="la la-angle-left"></i></a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>"><i class="la la-angle-left"></i></a></li>
                                        <?php
                                    }

                                    $sql = 'SELECT COUNT(id) as count FROM transaction;';
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
                                                                                               href="?page_no=<?php echo $i ?>"><?php echo $i ?></a>
                                                </li>
                                                <?php
                                            }
                                        }

                                        $nextPage=$page+1;


                                        if($nextPage>$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="la la-angle-right"></i></a></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>"><i class="la la-angle-right"></i></a></li>
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




    <?php Include ('../includes/footer.php') ?>



</div>

<script>
    function imgModal(src) {
        document.getElementById('modal_images').setAttribute("src",'pay_img/'+src+'.jpg');

    }

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






</body>
</html>
