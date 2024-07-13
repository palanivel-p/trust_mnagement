<?php

$name = $_GET['name'];
$mobile = $_GET['mobile'];
$mobile1 = $_GET['mobile1'];
$amount = $_GET['amount'];
$date = $_GET['date'];
$newDate = date("d-m-Y", strtotime($date));
$pan = $_GET['pan'];
$address = $_GET['address'];
$pay_mode = $_GET['pay_mode'];
$type = $_GET['type'];
$transaction_id = $_GET['transaction_id'];
$dob = $_GET['dob'];
$dobDate = date("d-m-Y", strtotime($dob));


?>

<html>
    <head>
        <title>PDF</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap-grid.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
        <style>
            * {
                margin:0;
                padding:0;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            #printPdf{
                margin-top: 0px;
            }
            .headerPdf{
                margin-top: 0px;
            }
            .flex-container{
                padding: 0;
                margin: 0;
                list-style: none;
                display: flex;
            }
            .flex-start{
                justify-content: flex-start;
            }
            .flex-end {
                justify-content: flex-end;
                margin-left: 55px;
            }
            .end{
                margin-bottom: 15px;
            }
            .s{
                margin-top: 0px;margin-left: 0px;
                background-image: url('../images/re.png');
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            /** {*/
            /*    box-sizing: border-box;*/
            /*}*/

            /* Create two equal columns that floats next to each other */
            .column {
                float: left;
                width: 50%;
                padding: 10px;
                height: 300px; /* Should be removed. Only for demonstration */
            }

            /* Clear floats after the columns */
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
            .headerCont{
                text-transform: capitalize;
            }

        </style>
    </head>

    <body>
        <div id="printPdf">
            <div class="headerPdf flex-container">
                <div class="pdfLogo flex-start">
                    <img src="../images/logo.png">
                </div>
                <div class="headerCont flex-end">
                    <h3 style="margin-bottom: 10px;">ANNAI TERASA OLD AGE HOME AND <br>ANNAI TERASA CHILDREN'S<br> HOME CHARITABLE TRUST</h3>
                    <h5><strong>Trust Reg No: 4 /27B / 2022</strong></h5>
                    <h5><strong> 80G Reg No: AAJTA5888MF20221</strong></h5>
                    <h5><strong> Pan No: AAJTA5888M</strong></h5>
                    <h5><strong> Old No.63, New No.16, Bajanai Kovil Street,<br>
                        Madanankuppam,Kolathur,Chennai-600099.</strong></h5>
                </div>
            </div>
            <hr style="margin-top: 18px;">
                <!-- main content-->
        <div>
            <div class="mainContent_pdf s row" style="margin-top: 18px;">
                <h2 style="margin-left: 160px;margin-bottom: 20px;">Donation Receipt</h2>
        <!--        <h3 style="text-align: center;">Donation Receipt</h3>-->

                    <!--left side data-->
                <div class="left column">

                <div>
                    <h3 style="margin-top: 9px;display: inline-block;">Donor Name: </h3><strong> <?php echo strtoupper($name)?></strong>

                </div>
                <div>
                    <h3 style="margin-top: 9px;display: inline-block;">Mobile No:</h3> <strong><?php echo $mobile?></strong>

                </div>
                <div>
                    <h3 style="margin-top: 9px;display: inline-block;">Alternate No:</h3> <strong><?php echo $mobile1?></strong>

                </div>
                <div>
                    <h3 style="margin-top: 9px;display: inline-block;">D.O.B:</h3> <strong><?php echo $dobDate?></strong>

                </div>

                <?php
                if($type == '80G'){
                    ?>
                    <div style="margin-top: 9px;">
                        <h3 style="display: inline-block;">PAN No:</h3>
                        <strong><?php echo strtoupper($pan)?></strong>
                    </div>
                    <br>
                    <?php
                }
                ?>
                    <div style="width: 500px; margin-top: 5px; word-wrap: break-word;">
                        <h3 style="display: inline-block;">Address:</h3>
                        <strong><?php echo strtoupper($address)?></strong>
                    </div>

            </div>

                <!--Right side data-->
                <div class="right column">

                    <div style="display: flex;justify-content: space-between;margin-top: 7px;">
                        <!--  <h3>Receipt No: ATC625357</h3>-->
                        <h3 style = "margin-right: 7px">Date: <?php echo date("d-m-Y");?></h3>
                    </div>

                    <div>
                        <h3 style="margin-top: 9px;display: inline-block;"> Amount :₹</h3><strong> <?php echo $amount?></strong>
                    </div>

                    <div>
                        <h3 style="margin-top: 9px; display: inline-block;">Payment Mode:</h3> <strong> <?php echo strtoupper($pay_mode)?></strong>
                    </div>

                    <div>
                        <h3 style="margin-top: 9px; display: inline-block;">Transaction ID:</h3> <strong> <?php echo strtoupper($transaction_id)?></strong>
                    </div>

                    <div style="margin-top: 9px;">
                        <h3 style="display: inline-block;">Donation Date:</h3><strong> <?php echo $newDate?></strong>
                    </div>

                </div>

            </div>
            <div style="width: 550px; margin-top: 1px;" class="end">
                <p style="word-wrap: break-word;font-weight: bold;margin-top: 10px;">Thank You Very Much To Support Company Name To Give A Better Life To <br>The Destitute And Orphan Childern's Who Are Greatly need.</p>
                <p style="word-wrap: break-word;font-weight: bold;margin-top: 8px;">Note: You Have Donated To An Organization Which Is Offer Tax-exemption<br> U/S 80G Of Income Tax Act 1961.</p>
            </div>
            <div style="display: flex;justify-content: end; margin-right: 10px; height:50px !important;">
                <img src="../images/Signature1.png">
            </div>
            <div style="display: flex;justify-content: end; margin-right: 10px; margin-top: 10px!important;">

                <h5>ATHORIZED SIGNATORY</h5>
            </div>
        </div>
        <hr style="margin-top: 10px;">
                    <!--footer-->
        <div class="footerPdf end row" style="display:flex;margin-top: 10px;margin-left:75px; width: 100%">
            <h3 style="margin-left: 140px;margin-bottom: 20px;">ADDRESS :</h3>
                        <!--    left-->
            <div class="col-md-6 col-lg-3 col" style ="display: flex;justify-content: space-between;">

                <div class="widget">
                    <h3 class="widget-title"></h3>
                    <ul class="pbmit_contact_widget_wrapper">
                        <li class="pbmit-contact-address  pbmit-base-icon-location-pin">
                            <strong>Kilpuak Home:54 Members</strong>
                        </li>
                  <!-- <li style="word-wrap: break-word;font-weight: bold;">-->
                        <li style="list-style-type: none;">
                            No 47, outer circular road,<br>
                            Kilpauk garden colony,
                            Kilpauk,<br>
                            Chennai- 600010.<br>
                        </li>

                    </ul>
                </div>
            </div>
                    <!--    right-->
                <!--  <div style="display: flex;justify-content: end; margin-right: 10px; margin-top: 60px!important;">-->
            <div class="col-md-6 col-lg-3 col" style ="display: flex;justify-content:space-between;margin-left: 120px;">
                <div class="widget">
                    <h3 class="widget-title"></h3>
                    <ul class="pbmit_contact_widget_wrapper">
                        <li class="pbmit-contact-address  pbmit-base-icon-location-pin">
                            <strong>Kolathur Home:40 Members</strong>
                        </li>
                        <li style="list-style-type: none;">
                            No 63, bajana kovil street,<br>
<!--                            madhanakuppam,-->
                            Kolathur,<br>
                            Chennai- 600099.<br>
                        </li>

                    </ul>
                </div>
            </div>

        </div>

        </div>

        <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
        <script>
              //
               //     var element = document.getElementById('printPdf');
               //         html2pdf(element);

            let timesPdf = 0;

            if(timesPdf == 0){
                var element = document.getElementById('printPdf');

                useCORS: true;
                var opt = {
                    margin:       1,
                    filename:     'reciept.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2,useCORS: true },
                    jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save();

                //  Old monolithic-style usage:
                // html2pdf(element, opt);

                timesPdf+=1;
            }

            setTimeout(() => {
                window.location.href = "https://trusterp.gbtechcorp.com/trust_crm/receipt";
            }, 800);


        </script>

    </body>
</html>