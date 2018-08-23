<?php

$post = json_decode(file_get_contents("php://input"), true);

$meetingID = $post['meetingId'];
$rating = $post['rate'];
$score = $post['score'];

if( !isset($post) ) { echo json_encode(array('error'=>'no data')); }
else {
  $dbData = json_encode(array('meeting'=>$meetingID, 'rating'=>$rating, 'score'=>$score));
  $dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/setRating.php";
  
  HTTPPost($dbURL, $dbData);
}

function HTTPPost($url, $data) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  $result = json_decode(curl_exec($ch), true);
  
	curl_close($ch);
  
}

?>