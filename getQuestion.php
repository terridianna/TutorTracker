<?php

$post = json_decode(file_get_contents("php://input"), true);

$ID = $post['id'];
$course = $post['course'];
$type = $post['type'];
$qID = $post['qID'];
$mID =  $post['meetingId'];

if( !isset($post) ) { echo json_encode(array('error'=>'no data')); }
else {
  $tags = array($course, $type);
  if( $mID != 0 ) { array_push($tags, $mID); }
  
  $dbData = json_encode(array('ID'=>$ID, 'qID'=>$qID, 'tags'=>$tags));
  $dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/getQuestion.php";
  
  HTTPPost($dbURL, $dbData);
}

function HTTPPost($url, $data) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  $result = json_decode(curl_exec($ch), true);
  
  echo json_encode(array('text'=>$result['text'], 'qID'=>$result['qID']));
  
	curl_close($ch);
  
}

?>