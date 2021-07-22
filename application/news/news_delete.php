<?php
include "../../application/config/config.php";
$ID = $_POST["id"];

$query = "delete from newsall where id = '$ID'";
mysqli_query($conn, $query);

echo json_encode(array('status' => 'success'));