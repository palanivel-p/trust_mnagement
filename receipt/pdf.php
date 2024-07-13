<?php

$name = $_GET['name'];
$mobile = $_GET['mobile'];
$mobile1 = $_GET['mobile1'];
$amount = $_GET['amount'];
$date = $_GET['date'];
$pan = $_GET['pan'];
$address = $_GET['address'];
$pay_mode = $_GET['pay_mode'];
$type = $_GET['type'];

?>

<html>
<head>
    <title>PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap-grid.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
</head>
<style>
    * {
        margin:0;
        padding:0;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .s{
        margin-top: 0px;margin-left: 0px;
        background-image: url(watermark_logo.png);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    #printPdf {
        width: 100%;
        margin: 25px;
        height: 100%;
        display: flex;
        justify-content: center;

    }

    #printPdf .wrapDiv {
        /* display: flex;
        justify-content: center; */
    }
    .headerPdf {
        width: 100%;
        display: flex;
        border-bottom: 1px solid black;
        justify-content: space-between;
    }

    .headerPdf .pdfLogo img {
        width: 100px;
        height: 100px;
    }
    .headerCont h3 {
        margin: 5px;
    }
    .mainContent_pdf {
        margin-top: 15px;
        margin-bottom: 5px;
        border-bottom: 1px solid black;
    }
    .end{
        margin-bottom: 15px;
    }
    .footerPdf{
        margin-top: 30px;
    }
    .left-footer{
        justify-content-end
    }
</style>
<body>
<div id="printPdf">
    <div class="wrapDiv">
        <div class="headerPdf">
            <div class="pdfLogo">
                <img src="../images/donation.png">
            </div>
            <div class="headerCont">
                <h1>ANNAI TERESA OLD AGE <br>HOME AND ANNAI TERESA CHILDREN'S HOME CHARITABLE TRUST</h1>
                <h3><strong>TRUST REGD NO: 4 /27B / 2022</strong></h3>
                <h3><strong> 80G REGD NO: AAJTA5888MF20221</strong></h3>
<!--                <h3><strong> UNIQUE REG DATE: 24-09-2021</strong></h3>-->
                <h3><strong> PAN NO: AAJTA5888M</strong></h3>
                <h3><strong> OLD NO.63, NEW NO.16, BAJANAI KOVIL STREET,MADANANKUPPAM,LOLATHUR,CHENNAI-600099.</strong></h3>
            </div>
        </div>
        <div class="mainContent_pdf s">
            <h3 style="text-align: center;">Donation Receipt</h3>

            <div style="display: flex;justify-content: space-between;margin-top: 8px;">
<!--                <h3>Receipt No: ATC625357</h3>-->
<!--                <h3>Date: 31-08-2023</h3>-->
                <h3 style = "margin-right: 7px">Date: <?php echo date("d/m/Y");?></h3>
            </div>




                    <div class="" >
<!--                    <div class="" style="display: flex; justify-content: space-around;">-->


                        <div class="" style="font-size: small;">

                    <div>
                        <h3 style="margin-top: 9px;display: inline-block;">Donor Name: </h3><strong> <?php echo strtoupper($name)?></strong>

                    </div>

                        <div>
                            <h3 style="display: inline-block;">Alternate No:</h3> <strong><?php echo $mobile1?></strong>

                        </div>



                            <?php
                            if($type == '80G'){


                                ?>
                                <div>
                                    <h3 style="display: inline-block;">PAN No:</h3> <strong><?php echo strtoupper($pan)?></strong>

                                </div>
                                <br>
                                <?php
                            }
                            ?>

                                <div style="width: 500px; margin-top: 9px; word-wrap: break-word;">
                                    <h3 style="display: inline-block;">Address:</h3>
                                    <strong><?php echo strtoupper($address)?></strong>
                                    <!--                    <strong>No:21,8th Street,anna nagar-->
                                    <!--                        Lorem,ipsum dolor sit amet consect.-->
                                    <!--                        incidunt tenetur id quidem expedita-->
                                    <!--                        nisi eum voluptas, esse repellendue?,-->
                                    <!--                        chennai-->
                                    <!--                    </strong>-->
                                </div>


                            </div>


                            <div>
<!--                            <div style="display: flex;justify-content: space-between;width: 60%;">-->
                    <div>
                        <h3 style="margin-top: 9px;display: inline-block;"> Amount :</h3><strong> <?php echo $amount?></strong>

                    </div>



                <div style="margin-top: 15px;">

                            <h3 style="display: inline-block;">Donation Date:</h3><strong> <?php echo $date?></strong>

                        </div>
                        <br>

                        <br>
                        <div>
                            <h3 style="display: inline-block;">Payment Mode:</h3> <strong> <?php echo strtoupper($pay_mode)?></strong>

                        </div>
                        </div>



                    </div>





            <div style="width: 550px; margin-top: 30px;" class="end">
                <p style="word-wrap: break-word;font-weight: bold;margin-top: 10px;">Thank You Very Much To Support Company Name To Give A Better Life To <br>The Destitute And Orphan Childern's Who Are Greatly need.</p>
                <p style="word-wrap: break-word;font-weight: bold;margin-top: 8px;">Note: You Have Donated To An Organization Which Is Offer Tax-exemption<br> U/S 80G Of Income Tax Act 1961.</p>
            </div>

        </div>
<br>

        <div class="footerPdf" style="display: flex">
            <div class="col-md-6 col-lg-3" style ="display: flex;justify-content: space-around">
                <div class="widget">
                    <h3 class="widget-title"></h3>
                    <ul class="pbmit_contact_widget_wrapper">
                        <li class="pbmit-contact-address  pbmit-base-icon-location-pin">
                            <strong>Kilpauk Home:</strong>
                        </li>
                        <li style="word-wrap: break-word;font-weight: bold;">
                            No 47, outer circular road,<br>
                            Kilpauk garden colony,<br>
                            Kilpauk <br>
                            Chennai- 600010.<br>
<!--                            9710155541, 9150069724.-->
                        </li>



                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" style ="display: flex;justify-content:end;margin-left: 144px;">
                <div class="widget">
<!--                    <h3 class="widget-title">Footer</h3>-->
                    <ul class="pbmit_contact_widget_wrapper">
                        <li class="pbmit-contact-address  pbmit-base-icon-location-pin">
                            <strong>Kolathur Home:</strong>
                        </li>
                        <li>
                            No 63, bajana kovil street,<br>
                            madhanakuppam,<br>
                            Kolathur<br>
                            Chennai- 600099.<br>
                            9710155541, 9150069724.
                        </li>



                    </ul>
                </div>
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

     // setTimeout(() => {
    //     //    window.location.href = "table.php";
    //     // }, 800);




</script>

</body>
</html>