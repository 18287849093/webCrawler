<?php
include "../../application/config/config.php";

$rank =  $_POST['rank'];
$name =  $_POST['name'];
$view =  $_POST['view'];
$followAnime =  $_POST['followAnime'];
$bullet =  $_POST['bullet'];
$animeType =  $_POST['animeType'];
$comments=  $_POST['comments'];
$collection=  $_POST['collection'];
$score=  $_POST['score'];
$url=  $_POST['url'];
$updateTime =  $_POST['updateTime'];

$sql  = "UPDATE `WebCrawler`.`rankingList` SET `name` = '$name', `view` = '$view', `followAnime` = '$followAnime', `bullet` = '$bullet', `animeType` = '$animeType'
                                    , `comments` = '$comments', `collection` = '$collection', `score` = '$score', `url` = '$url', `updateTime`
                                        = '$updateTime' WHERE `rank` = $rank;";

mysqli_query($conn, $sql);

echo json_encode(array('status' => 'success'));