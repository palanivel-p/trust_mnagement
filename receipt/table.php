<html>
<head>
    <title>PDF</title>
</head>
<style>
    h1 {
        color: red;
    }
</style>
<body>

<button onclick="Pdf('onizukaaa',2285965477')">Reciept Download</button>

<?php

// Include autoloader
require_once 'dompdf/autoload.inc.php';

// Reference the Dompdf namespace
use Dompdf\Dompdf;

// Instantiate and use the dompdf class
$dompdf = new Dompdf();
// Load content from html file
$html = file_get_contents("pdf1.html");
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
ob_end_clean();
// Output the generated PDF (1 = download and 0 = preview)
$dompdf->stream("codexworld", array("Attachment" => 0));
?>
<script>

    function Pdf(name,mobile){
        window.location.href=`pdf1.php?name=${name}&mobile=${mobile}`;

    }



</script>

</body>
</html>