<?php
include "../../application/config/config.php";
$ID = $_POST["AccountNumber"];

$query = "delete from user where AccountNumber = '$ID'";

mysqli_query($conn,$query);

echo json_encode(array('status'=>'success'));

