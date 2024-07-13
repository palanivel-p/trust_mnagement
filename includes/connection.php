<?php

$website="https://gcct.donatecrp.in/";
$servername="localhost";
$username="developer_donatecrp";
$password="3Wj07p8x?";
$dbname="trust_crm";
$conn=mysqli_connect($servername,$username,$password,$dbname);
if(!$conn)
{
    die("connection failed:".mysqli_connect_error());
}
// else{
//     echo "success";
// }

?>