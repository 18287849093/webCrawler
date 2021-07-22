<?php

include "../../application/config/config.php";
$ID = $_POST["rank"];

$query = "delete from rankingList where rank = $ID";

mysqli_query($conn, $query);

echo json_encode(array('status' => 'success'));