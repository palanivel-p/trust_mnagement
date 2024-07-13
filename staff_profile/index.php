<?php Include("../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
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
$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];
if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = '';
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";

    }
//    else{
//        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";
//
//    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Staff profile</title>

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

$header_name ="Staff";
    Include ('../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Staff</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Staff List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">

                        <div class="form-group mx-sm-3 mb-2">
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
<!--                                    <label>Branch Name</label>-->
<!--                                        <select data-search="true" class="form-control tail-select w-full" id="branch_nameS" name="branch_nameS" style="border-radius:20px;color:black;border:1px solid black;">-->
<!--                                            <option value='all'>All</option>-->
<!--                                            --><?php //
//                                            $sqlDevice="SELECT * FROM `branch_profile`";
//                                            $resultDevice=mysqli_query($conn,$sqlDevice);
//                                           if(mysqli_num_rows($resultDevice) > 0)
//                                            {
//                                                while($rowDevice = mysqli_fetch_array($resultDevice)) {
//                                                    ?>
<!---->
<!--                                                    <option value='--><?php //echo $rowDevice['branch_id'];?><!--' >--><?php //echo strtoupper($rowDevice['branch_name']);?><!--</option>-->
<!--                                            --><?php
//                                                }
//                                            }
//                                            ?>
<!--                                        </select>  -->
                                    </div> 

                            <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By Staff Name" name="search" id="search" style="border-radius:20px;color:black;" >
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                        </form>
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#career_list" style="margin-left: 20px;" onclick="addTitle()">ADD</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">


                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>STAFF_ID</strong></th>
                                <th><strong>STAFF_NAME</strong></th>
                                <th><strong>MOBILE_NO</strong></th>
                                <th><strong>BRANCH_NAME</strong></th>
                                <th><strong>EMAIL</strong></th>
                                <th><strong>PASSWORD</strong></th>
<!--                                <th><strong>Access Type</strong></th>-->
                                <th><strong>ACTIVE_STATUS</strong></th>
                                <!-- <th><strong>Status</strong></th> -->
                              <th><strong>ACTION</strong></th>

                            </tr>
                            </thead>
                            <?php
                            if($search == "" && $branch_nameS == "all") {
                               $sql = "SELECT * FROM staff_profile WHERE id>0 $addedBranchSerach  ORDER BY id  LIMIT $start,10";
                            }
                            elseif($search != "" && $branch_nameS == "all") {
                                $sql = "SELECT * FROM staff_profile WHERE staff_name LIKE '%$search%' $addedBranchSerach ORDER BY id  LIMIT $start,10";
                            }
                            elseif($search == "" && $branch_nameS != "all") {
                                $sql = "SELECT * FROM staff_profile WHERE branch_name = '$branch_nameS' $addedBranchSerach ORDER BY id  LIMIT $start,10";
                            }
                            else {
                                $sql = "SELECT * FROM staff_profile WHERE staff_name LIKE '%$search%' AND branch_name = '$branch_nameS' $addedBranchSerach ORDER BY id  LIMIT $start,10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;
                            //$date = $row['dob'];
                            //$dates = date('d-F-Y', strtotime($date));

                        //   $career_dates =   $row['career_date'];
                        //   $career_date =   date('d-F-Y');

                            if($row['access_status'] == 1){
                                $statColor = 'success';
                                $statCont = 'Active';
                            }
                            else {
                                $statColor = 'danger';
                                $statCont = 'In Active';
                            }
                            $branchId = $row['branch_name'];


                            $sqlbranchName="SELECT * FROM `branch_profile` WHERE branch_id='$branchId'";
                            $resultBranchName=mysqli_query($conn,$sqlbranchName);
                            if(mysqli_num_rows($resultBranchName) > 0) {
                                $rowBranchName = mysqli_fetch_assoc($resultBranchName);

                                $branchName = $rowBranchName['branch_name'];

                            }

                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td><?php echo strtoupper($row['staff_id'])?></td>

                                   <td> <?php echo strtoupper($row['staff_name'])?> </td>
                                   <td> <?php echo $row['mobile']?> </td>
                                   <td> <?php echo strtoupper($branchName)?> </td>
                                   <td> <?php echo strtoupper($row['email'])?> </td>
                                   <td> <?php echo strtoupper($row['password'])?> </td>
<!--                                   <td> --><?php //echo $row['access_type']?><!-- </td>-->
                                   <td> <span class="badge badge-pill badge-<?php echo $statColor?>"><?php echo $statCont?></span>
                                   </td>
                                   <!-- <td> <?php //echo $row['status']?> </td> -->
                                <!-- <td><?php //echo $career_date?></td> -->
                                <!-- <td><?php //echo date('d-m-Y',strtotime($row['dob'])) ?></td> -->
                                <!-- <td><?php //echo date('d-m-Y',strtotime($row['date_of_joining'])) ?></td> -->




                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">

                                            <a class="dropdown-item" data-toggle="modal" data-target="#career_list" style="cursor: pointer" onclick="editTitle('<?php echo $row['staff_id'];?>')">Edit</a>
                                            

                                        </div>
                                    </div>
                                </td>
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
                                                                                href="?page_no=<?php echo 1 ?>&search=<?php echo $search ?>&branch_nameS=<?php echo $branch_nameS ?>"><i
                                                    class="la la-angle-double-left"  style="padding-top: 9px;"></i></a></li>
                                        <?php
                                    }

                                    if($prevPage==0)
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="la la-angle-left"></i></a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&search=<?php echo $search ?>&branch_nameS=<?php echo $branch_nameS ?>"><i class="la la-angle-left"></i></a></li>
                                        <?php
                                    }
                                    if($search == "" && $branch_nameS == "all") {
                                        $sql = "SELECT COUNT(id) as count FROM staff_profile WHERE id>0 $addedBranchSerach";
                                    }
                                    elseif($search != "" && $branch_nameS == "all") {
                                        $sql = "SELECT COUNT(id) as count FROM staff_profile WHERE staff_name LIKE '%$search%' $addedBranchSerach";
                                    }
                                    elseif($search == "" && $branch_nameS != "all") {
                                        $sql = "SELECT COUNT(id) as count FROM staff_profile WHERE branch_name = '$branch_nameS' $addedBranchSerach";
                                    }
                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM staff_profile WHERE staff_name LIKE '%$search%' AND branch_name = '$branch_nameS' $addedBranchSerach";
                                    }

                                  //  $sql = 'SELECT COUNT(id) as count FROM  staff_profile;';
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
                                                                                               href="?page_no=<?php echo $i ?>&search=<?php echo $search ?>&branch_nameS=<?php echo $branch_nameS ?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&search=<?php echo $search ?>&branch_nameS=<?php echo $branch_nameS ?>"><i class="la la-angle-right"></i></a></li>
                                            <?php
                                        }
                                        if($nextPage<$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $pageFooter ?>&search=<?php echo $search ?>&branch_nameS=<?php echo $branch_nameS ?>"><i class="la la-angle-double-right"></i></a></li>
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


                        <h5 class="modal-title" id="title">Staff Details</h5>

                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form" style="color: black;">
                            <form id="staff_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label>Staff Name *</label>
                                        <input type="text" class="form-control" placeholder="Staff Name" id="staff_name" name="staff_name" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="staff_id" name="staff_id">
                                    </div>

                                   
                                    <div class="form-group col-md-12">
                                        <label>Mobile *</label>
                                        <input type="number" class="form-control" placeholder="Mobile" id="mobile" name="mobile" style="border-color: #181f5a;color: black">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Email *</label>
                                        <input type="text" class="form-control" placeholder="Email" id="email" name="email" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    </div>

                                   
                                     <div class="form-group col-md-12">
                                        <label>Date of joining *</label>
                                        <input type="date" class="form-control"  max="<?php echo date("Y-m-d")?>" id="doj" name="doj" placeholder="Date of joining" style="border-color: #181f5a;color: black">
                                    </div> 
                                    <!-- <div class="form-group col-md-12">
                                        <label>Branch Name *</label>
                                        <input type="text" class="form-control" placeholder="Branch Name" id="branch_name" name="branch_name" style="border-color: #181f5a;color: black">
                                    </div> -->
                                     <div class="form-group col-md-12" >

                                         <label>Branch Name</label>
                                         <select data-search="true" class="form-control tail-select w-full" id="branch_name" name="branch_name" style="border-color: #181f5a;color: black;text-transform: uppercase">

                                             <?php
                                             $branchId_cookie = $_COOKIE['branch_id'];
                                             if($branchId_cookie == ''){
                                                 $sqlDeviceB="SELECT * FROM `branch_profile`";

                                             }
                                             else {
                                                 $sqlDeviceB="SELECT * FROM `branch_profile` WHERE branch_id='$branchId_cookie'";

                                             }
                                             $resultDeviceB=mysqli_query($conn,$sqlDeviceB);
                                             if(mysqli_num_rows($resultDeviceB) > 0)
                                             {
                                                 while($rowDeviceB = mysqli_fetch_array($resultDeviceB)) {
                                                     ?>
                                                     <option value='<?php echo $rowDeviceB['branch_id'];?>' ><?php echo strtoupper($rowDeviceB['branch_name']);?></option>
                                                     <?php
                                                 }
                                             }
                                             ?>
                                         </select>
<!--                                    <label>Branch Name</label>-->
<!--                                        <select data-search="true" class="form-control tail-select w-full" id="branch_name" name="branch_name" style="border-color: #181f5a;color: black">-->
<!--                                            -->
<!--                                            --><?php //
//                                            $sqlDevice="SELECT * FROM `branch_profile`";
//                                            $resultDevice=mysqli_query($conn,$sqlDevice);
//                                           if(mysqli_num_rows($resultDevice) > 0)
//                                            {
//                                                while($rowDevice = mysqli_fetch_array($resultDevice)) {
//                                                    ?>
<!--                                                    <option value='--><?php //echo $rowDevice['branch_id'];?><!--' >--><?php //echo strtoupper($rowDevice['branch_name']);?><!--</option>-->
<!--                                            --><?php
//                                                }
//                                            }
//                                            ?>
<!--                                        </select>  -->
                                    </div> 
<!--                                    <div class="form-group col-md-12">-->
<!--                                        <label>User Name *</label>-->
<!--                                        <input type="text" class="form-control" placeholder="User Name" id="user_name" name="user_name" style="border-color: #181f5a;color: black">-->
<!--                                    </div>-->
                                    <div class="form-group col-md-12">
                                        <label>Password *</label>
                                        <input type="text" class="form-control" placeholder="Password" id="password" name="password" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    </div>
                                    <!-- <div class="form-group col-md-12">
                                        <label>Access Type *</label>
                                        <input type="text" class="form-control" placeholder="Access Type" id="access_type" name="access_type" style="border-color: #181f5a;color: black">
                                    </div> -->

                                    <div class="form-group col-md-12">
                                        <label>Address</label>
                                        <textarea class="form-control" placeholder="Address" id="address" name="address" cols="70" rows="4" style="border: 1px solid black;color: black;text-transform: uppercase"></textarea>

                                    </div>

<!--                                    <div class="form-group col-md-12">-->
<!--                                        <label >Access Type</label>-->
<!--                                        <select  class="form-control" id="access_type" name="access_type" style="border-color: #181f5a;color: black">-->
<!--                                            <option value='admin' selected>Admin</option>-->
<!--                                            <option value='super admin'>Super Admin</option>-->
<!--                                            <option value='staff'>Staff</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
                                    <!-- <div class="form-group col-md-12">
                                        <label>Status *</label>
                                        <input type="text" class="form-control" placeholder="Status" id="status" name="status" style="border-color: #181f5a;color: black">
                                    </div> -->
                                    <div class="form-group col-md-12">
                                        <label>Active Status</label>
                                        <label class="switch">
                                            <input type="checkbox" checked id="access_status"  name="access_status">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>

                                    <!-- <div class="form-group col-md-12">
                                        <label>Description *</label>
                                        <textarea class="summernote form-control" id="job_description" name="job_description"></textarea>
                                                                           <div class="summernote"></div>
                                    </div> -->

                                </div>


                            </form>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;text-transform: uppercase">Close</button>
                        <button type="button" class="btn btn-primary" id="add_btn">ADD</button>
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




   function addTitle() {
       $("#title").html("Add Staff");
       $('#staff_form')[0].reset();
       $('#api').val("add_api.php")
       // $('#game_id').prop('readonly', false);

   }

   function editTitle(data) {

       $("#title").html("Edit Staff- "+data);
       $('#staff_form')[0].reset();
       $('#api').val("edit_api.php");

       $.ajax({

           type: "POST",
           url: "view_api.php",
           data: 'staff_id='+data,
           dataType: "json",
           success: function(res){
               if(res.status=='success')
               {
                   $("#staff_id").val(res.staff_id);
                   $("#staff_name").val(res.staff_name);
                   $("#branch_name").val(res.branch_name);
                   $("#mobile").val(res.mobile);
                   $("#email").val(res.email);
                   $("#address").val(res.address);
                   $("#doj").val(res.doj);
                   $("#user_name").val(res.user_name);
                   $("#password").val(res.password);
                   // $("#access_type").val(res.access_type);
                   $("#access_status").val(res.access_status);
                   


                   $("#old_pa_id").val(res.staff_id);
                   $("#staff_id").val(res.staff_id);

                   if(Number(res.access_status) == 1){
                        document.getElementById("access_status").checked = true;
                    }
                    else {
                        document.getElementById("access_status").checked = false;

                    }




                   // $('#game_id').prop('readonly', true);

                   var edit_model_title = "Edit Staff - "+data;
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
   $("#staff_form").validate(
       {
           ignore: '.ignore',
           // Specify validation rules
           rules: {

               staff_name: {
                   required: true
               },
               address: {
                   required: true
               },
               
               mobile: {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                },
               email: {
                   required: true,
                   email: true
               },
               doj: {
                   required: true
               },
               branch_name: {
                   required: true
               },
               // user_name: {
               //     required: true
               // },
               
               password: {
                   required: true
               },
               // access_type: {
               //     required: true
               // },


           },
           // Specify validation error messages
           messages: {
            staff_name: "*This field is required",
            address: "*This field is required",
            
            mobile: {
                    required:"*This field is required",
                    maxlength:"*Mobile Number Should Be 10 Character",
                    minlength:"*Mobile Number Should Be 10 Character"
                },
            email: "*This field is required",
            doj: "*This field is required",
            branch_name: "*This field is required",
            password: "*This field is required",
           // user_name: "*This field is required",

            // access_type: "*This field is required",
           }
           // Make sure the form is submitted to the destination defined
       });

   //add data

   $('#add_btn').click(function () {




       $("#staff_form").valid();



       if($("#staff_form").valid()==true) {

            var api = $('#api').val();
            var form = $("#staff_form");
            var access_status = $('#access_status').is(":checked");
           
            console.log(access_status);

            if(access_status == true)
            {
                access_status =1;
            }
            else{
                access_status =0;
            }
               var formData = new FormData(form[0]);
               formData.append("active_status",access_status);

               this.disabled = true;
               this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
               $.ajax({

                   type: "POST",
                   url: api,
                   data: formData,
                   dataType: "json",
                   contentType: false,
                    cache: false,
                    processData:false,
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
                    data: 'staff_id='+data,
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

    });

</script>


</body>
</html>
