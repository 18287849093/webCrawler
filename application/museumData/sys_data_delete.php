<?php

include "../../application/config/config.php";
$ID = $_POST["museumID"];

$query = "delete from MuseumBasicInformation where museumID = '$ID'";
mysqli_query($conn, $query);

echo json_encode(array('status' => 'success'));

