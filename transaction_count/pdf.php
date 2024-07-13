<?php

$name = $_GET['name'];
$mobile = $_GET['mobile'];
$mobile1 = $_GET['mobile1'];
$amount = $_GET['amount'];
$date = $_GET['date'];
$pan = $_GET['pan'];
$address = $_GET['address'];
$pay_mode = $_GET['pay_mode'];

?>

<html>
<head>
    <title>PDF</title>

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
                <img src="../images/annai.png">
            </div>
            <div class="headerCont">
                <h1>Annai Trust</h1>
                <h3><strong>UNIQUE REGD NO: AAFTA0991FF202213</strong></h3>
                <h3><strong> J.J.ACT REGD NO: M1082/DSD/2017</strong></h3>
                <h3><strong> UNIQUE REG DATE: 24-09-2021</strong></h3>
                <h3><strong> PAN NO: AAFTA0991F</strong></h3>
                <h3><strong> REGD NO: 255/2015</strong></h3>
            </div>
        </div>
        <div class="mainContent_pdf s">
            <h3 style="text-align: center;">Donation Receipt</h3>
            <div style="display: flex;justify-content: space-between;margin-top: 8px;">
                <h3>Receipt No: ATC625357</h3>
                <!--                <h3>Date: 31-08-2023</h3>-->
                <h3 style = "margin-right: 7px">Date: <?php echo date("d/m/Y");?></h3>
            </div>
            <div style="margin-top: 15px;">
                <div>
                    <div>
                        <h3 style="margin-top: 9px;display: inline-block;">Donor Name: </h3><strong> <?php echo strtoupper($name)?></strong>

                    </div>
                    <div>
                        <h3 style="margin-top: 9px;display: inline-block;"> Amount :</h3><strong> <?php echo $amount?></strong>

                    </div>

                </div>
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
                <div style="margin-top: 15px;display: flex;justify-content: space-between;">
                    <div>
                        <div>
                            <h3 style="display: inline-block;">Mobile No:</h3> <strong><?php echo $mobile?></strong>
                        </div>
                        <div>
                            <h3 style="display: inline-block;">PAN No:</h3> <strong><?php echo strtoupper($pan)?></strong>

                        </div>
                        <div>
                            <h3 style="display: inline-block;">Donation Date:</h3><strong> <?php echo $date?></strong>

                        </div>


                    </div>

                    <div>
                        <div>
                            <h3 style="display: inline-block;margin-right: 7px">Alternate No:</h3> <strong><?php echo $mobile1?></strong>

                        </div>
                        <div>
                            <h3 style="display: inline-block;margin-right: 7px">Payment Mode:</h3> <strong> <?php echo strtoupper($pay_mode)?></strong>

                        </div>
                        <!--                        <div>-->
                        <!--                            <h3 style="display: inline-block;">Date Of Birth:</h3> <strong> 29-06-1973</strong>-->
                        <!---->
                        <!--                        </div>-->


                    </div>



                </div>

            </div>

            <div style="width: 550px; margin-top: 30px;" class="end">
                <p style="word-wrap: break-word;font-weight: bold;margin-top: 10px;">Thank You Very Much To Support Company Name To Give A Better Life To <br>The Destitute And Orphan Childern's Who Are Greatly need.</p>
                <p style="word-wrap: break-word;font-weight: bold;margin-top: 8px;">Note: You Have Donated To An Organization Which Is Offer Tax-exemption<br> U/S 80G Of Income Tax Act 1961.</p>
            </div>

        </div>
        <br>

        <div class="footerPdf">
            <div class="col-md-6 col-lg-3" style ="padding-right:30px;">
                <div class="widget">
                    <h3 class="widget-title"></h3>
                    <ul class="pbmit_contact_widget_wrapper">
                        <li class="pbmit-contact-address  pbmit-base-icon-location-pin">
                            <strong>Coimbature Home:</strong>
                        </li>
                        <li style="word-wrap: break-word;font-weight: bold;">
                            No 22, Ramaligapuram,<br>
                            Opposite to Kannabiran mill,<br>
                            Sowripalayam road,<br>
                            Coimbatore- 641028.<br>
                            9710155541, 9150069724.
                        </li>



                    </ul>
                </div>
            </div>
            <!--            <div class="col-md-6 col-lg-3 d-flex justify-content-end" style ="padding-right:30px;">-->
            <!--                <div class="widget">-->
            <!--                    <h3 class="widget-title">Footer</h3>-->
            <!--                    <ul class="pbmit_contact_widget_wrapper">-->
            <!--                        <li class="pbmit-contact-address  pbmit-base-icon-location-pin">-->
            <!--                            <strong>Coimbature Home:</strong>-->
            <!--                        </li>-->
            <!--                        <li>-->
            <!--                            No 22, Ramaligapuram,<br>-->
            <!--                            Opposite to Kannabiran mill,<br>-->
            <!--                            Sowripalayam road,<br>-->
            <!--                            Coimboture- 641028.<br>-->
            <!--                            9710155541, 9150069724.-->
            <!--                        </li>-->
            <!---->
            <!---->
            <!---->
            <!--                    </ul>-->
            <!--                </div>-->
            <!--            </div>-->

        </div>

    </div>




</div>



<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
<script>

    // var element = document.getElementById('printPdf');
    //     html2pdf(element);
    if(timesPdf == 0) {
        var element = document.getElementById('printPdf');

        useCORS: true;
        var opt = {
            margin: 1,
            filename: 'reciept.pdf',
            image: {type: 'jpeg', quality: 0.98},
            html2canvas: {scale: 2, useCORS: true},
            jsPDF: {unit: 'in', format: 'a4', orientation: 'portrait'}
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();

        //  Old monolithic-style usage:
        // html2pdf(element, opt);

        timesPdf += 1;
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