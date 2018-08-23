<?php

$post = json_decode(file_get_contents("php://input"), true);

$ID = $post['id'];
$tutorName = $post['appointTutors'][0];
$day = $post['appointDay'][0];
$tutorData = preg_split("/,/", $post['appointTime'][0]);

$time = $tutorData[0];
$location = $tutorData[1];

if( !isset($post) ) { echo json_encode(array('error'=>'no data')); }
else {
  $dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/addMeeting.php";
  $dbData = json_encode(array('ID'=>$ID, 'tutor'=>$tutorName, 'day'=>$day, 'time'=>$time, 'location'=>$location));

  HTTPPost($dbURL, $dbData);
}

function HTTPPost($url, $data) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  $result = json_decode(curl_exec($ch), true);
  
  print_r($result);
  
	curl_close($ch);
}

?>