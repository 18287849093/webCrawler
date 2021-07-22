<?php
include "../../application/config/config.php";

$id =  $_POST['id'];
$museum =  $_POST['museum'];
$title1 =  $_POST['title1'];
$author =  $_POST['author'];
$time =  $_POST['time'];
$content =  $_POST['content'];
$url =  $_POST['url'];
$emotions=  $_POST['emotions'];
$title2 =  $_POST['title2'];


$sql =  "UPDATE `u606804608_MuseumSpider`.`newsall` SET `museum` = '$museum',
                                               `title1` = '$title1 ', 
                                               `author` = '$author ',
                                               `time` = '$time ',
                                               `content` = '$content ', 
                                               `url` = '$url ',
                                               `emotions` = $emotions,
                                               `title2` = '$title2 ' WHERE `id` = $id";


mysqli_query($conn, $sql);

echo json_encode(array('status' => 'success'));