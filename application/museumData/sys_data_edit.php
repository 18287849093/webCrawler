<?php
include "../../application/config/config.php";

$museumID =  $_POST['museumID'];
$museumName =  $_POST['museumName'];
$address =  $_POST['address'];
$consultationTelephone =  $_POST['consultationTelephone'];
$publicityVideoLink =  $_POST['publicityVideoLink'];

$query = "UPDATE `MuseumBasicInformation` SET `museumName` = '$museumName ',                               
                                    `address` = '$address',
                                    `consultationTelephone` = '$consultationTelephone ', 
                                    `publicityVideoLink` = '$publicityVideoLink ' WHERE `museumID` = $museumID ";
mysqli_query($conn, $query);

echo json_encode(array('status' => 'success'));
/*
if(mysqli_affected_rows() > 0)
    echo json_encode(array('status' => 'success'));
else
    echo json_encode(array('status' => 'error'));*/


