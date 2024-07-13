<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$search= $_GET['search'];
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
        $addedBranchSerach = "AND branch_id='$cookieBranch_Id'";

    }
    else{
        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_id='$cookieBranch_Id'";

    }

}
//else {
//    $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_id='$cookieBranch_Id'";
//
//}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Doner profile</title>

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

$header_name ="Doner";
    Include ('../includes/header.php') ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Doner</a></li>


            </ol>

        </div>


        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Doner List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">

                            <div class="form-group mx-sm-3 mb-2">

                                <input type="text" class="form-control" placeholder="Search By Doner Mobile" name="search" id="search" style="border-radius:20px;color:black;" >
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
                                <th><strong>DONER NAME</strong></th>
                                <th><strong>MOBILE</strong></th>
                                <th><strong>TOTAL AMOUNT</strong></th>
                                <th><strong>LAST TRANSACTION</strong></th>
                                <th><strong>ADDRESS</strong></th>
                                <th><strong>TRANSACTION COUNT</strong></th>
                              <!-- <th><strong>Action</strong></th> -->

                            </tr>
                            </thead>
                            <?php
                            if($search == "") {
                                $sql = "SELECT * FROM doner_profile WHERE verfied = 1 $addedBranchSerach ORDER BY id DESC LIMIT $start,10";
                            }
                            else {
                              $sql = "SELECT * FROM doner_profile WHERE mobile = '$search' AND verfied = 1 $addedBranchSerach ORDER BY id DESC LIMIT $start,10";
                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;

                               $doner_id =   $row['doner_id'];

                            $sqldoner = "SELECT COUNT(id) as count FROM transaction WHERE verify=1 AND doner_id='$doner_id'";
                            $resultdoner = mysqli_query($conn, $sqldoner);
                            $rowdoner = mysqli_fetch_assoc($resultdoner);
                            $transCount = $rowdoner['count'];

                            $sqldonerAmount = "SELECT SUM(amount) as totalAmount FROM transaction WHERE verify=1 AND doner_id='$doner_id'";
                            $resultdonerAmount = mysqli_query($conn, $sqldonerAmount);
                            $rowdonerAmount = mysqli_fetch_assoc($resultdonerAmount);
                            $totalAmount = $rowdonerAmount['totalAmount'];

                            $sqldonerRecent = "SELECT * FROM transaction WHERE verify=1 AND doner_id='$doner_id' ORDER BY id DESC LIMIT 1";
                            $resultdonerRecent = mysqli_query($conn, $sqldonerRecent);
                            $rowdonerRecent = mysqli_fetch_assoc($resultdonerRecent);
                            $lastTransAmount = $rowdonerRecent['amount'];

                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>

                                   <td> <?php echo strtoupper($row['doner_name'])?> </td>
                                   <td> <?php echo strtoupper($row['mobile'])?> </td>
                                 <td> <?php echo strtoupper($totalAmount)?> </td>
                                 <td> <?php echo strtoupper($lastTransAmount)?> </td>
                                   <td> <?php echo strtoupper($row['address'])?> </td>
                                   <td>
                                       <a href ="../transaction_count/?doner_id=<?php echo $doner_id?>" target="_blank">
                                           <i class="flaticon-381-focus"></i>
                                           <?php echo $transCount?></td>

                                <!-- <td><?php //echo $career_date?></td> -->




                                <!-- <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">

                                            <a class="dropdown-item" data-toggle="modal" data-target="#career_list" style="cursor: pointer" onclick="editTitle('<?php echo $row['doner_id'];?>')">Edit</a>
                                            <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php echo $row['doner_id'];?>')">Delete</a>

                                        </div>
                                    </div>
                                </td> -->
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
                                                                                href="?page_no=<?php echo 1 ?>&search=<?php echo $search?>"><i
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
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>&search=<?php echo $search?>"><i class="la la-angle-left"></i></a></li>
                                        <?php
                                    }
                                    if($search == "") {
                                        //$sql = "SELECT COUNT(id) as count FROM doner_profile WHERE verfied = 1";
                                        $sql = "SELECT COUNT(id) as count FROM doner_profile WHERE verfied = 1 $addedBranchSerach";
                                    }
                                    else {
                                        $sql = "SELECT COUNT(id) as count FROM doner_profile WHERE mobile LIKE '%$search%' AND verfied = 1 $addedBranchSerach";
                                      //  $sql = "SELECT COUNT(id) as count FROM doner_profile WHERE mobile LIKE '%$search%' AND verfied = 1";
                                    }
                                  //  $sql = 'SELECT COUNT(id) as count FROM  doner_profile;';
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
                                                                                               href="?page_no=<?php echo $i ?>&search=<?php echo $search?>"><?php echo $i ?></a>
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
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>&search=<?php echo $search?>"><i class="la la-angle-right"></i></a></li>
                                            <?php
                                        }
                                        if($nextPage<$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $pageFooter ?>&search=<?php echo $search?>"><i class="la la-angle-double-right"></i></a></li>
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


                        <h5 class="modal-title" id="title">Doner Details</h5>

                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">




                        <div class="basic-form" style="color: black;">
                            <form id="doner_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <label>Doner Name *</label>
                                        <input type="text" class="form-control" placeholder="Doner Name" id="doner_name" name="doner_name" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="doner_id" name="doner_id">
                                    </div>

                                   
                                    <div class="form-group col-md-12">
                                        <label>Mobile *</label>
                                        <input type="number" class="form-control" placeholder="Mobile" id="mobile" name="mobile" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Pan NO *</label>
                                        <input type="text" class="form-control" placeholder="Pan No" id="pan" name="pan" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label>Email *</label>
                                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                    </div>

                                    
                                    <div class="form-group col-md-12">
                                        <label>Address *</label>
                                        <textarea class="form-control" placeholder="Address" id="address" name="address" cols="70" rows="4" maxlength="40" style="border: 1px solid black;color: black;text-transform: uppercase;"></textarea>

                                    </div>


                                </div>


                            </form>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;text-transform: uppercase;">Close</button>
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
       $("#title").html("Add Doner");
       $('#doner_form')[0].reset();
       $('#api').val("add_api.php")
       // $('#game_id').prop('readonly', false);

   }

   function editTitle(data) {

       $("#title").html("Edit Doner- "+data);
       $('#doner_form')[0].reset();
       $('#api').val("edit_api.php");

       $.ajax({

           type: "POST",
           url: "view_api.php",
           data: 'doner_id='+data,
           dataType: "json",
           success: function(res){
               if(res.status=='success')
               {
                   $("#doner_id").val(res.doner_id);
                   $("#doner_name").val(res.doner_name);
                   $("#mobile").val(res.mobile);
                   $("#pan").val(res.pan);
                   $("#email").val(res.email);
                   $("#address").val(res.address);



                   $("#old_pa_id").val(res.doner_id);
                   $("#doner_id").val(res.doner_id);

                //    if(Number(res.access_status) == 1){
                //         document.getElementById("access_status").checked = true;
                //     }
                //     else {
                //         document.getElementById("access_status").checked = false;

                //     }




                   // $('#game_id').prop('readonly', true);

                   var edit_model_title = "Edit Doner - "+data;
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
   $("#doner_form").validate(
       {
           ignore: '.ignore',
           // Specify validation rules
           rules: {

               doner_name: {
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
                   required: true
               },
               pan: {
                   required: true
               },
              

           },
           // Specify validation error messages
           messages: {
            doner_name: "*This field is required",
            address: "*This field is required",
           
            mobile: {
                    required:"*This field is required",
                    maxlength:"*Mobile Number Should Be 10 Character",
                    minlength:"*Mobile Number Should Be 10 Character"
                },
            email: "*This field is required",
            pan: "*This field is required",
           
           }
           // Make sure the form is submitted to the destination defined
       });

   //add data

   $('#add_btn').click(function () {
       $("#doner_form").valid();
       if($("#doner_form").valid()==true) {

            var api = $('#api').val();
           // var form = $("#doner_form");
            // var access_status = $('#access_status').is(":checked");
           
            // console.log(access_status);

            // if(access_status == true)
            // {
            //     access_status =1;
            // }
            // else{
            //     access_status =0;
            // }
            //    var formData = new FormData(form[0]);
            //    formData.append("active_status",access_status);

               this.disabled = true;
               this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
               $.ajax({

                   type: "POST",
                   url: api,
                 //  data: formData,
                   data: $('#doner_form').serialize(),
                   dataType: "json",
                //    contentType: false,
                //    cache: false,
                //    processData:false,
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
                    data: 'doner_id='+data,
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

    });

</script>


</body>
</html>
