<?php

include "../../application/config/config.php";
$ID = $_POST["collectionID"];

$query = "delete from Collection where collectionID = '$ID'";
mysqli_query($conn, $query);

echo json_encode(array('status' => 'success'));