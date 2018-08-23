<?php

$post = json_decode(file_get_contents("php://input"), true);

$user = $post['username'];
$pass = $post['password'];

if( !isset($post) ) { echo json_encode(array('error'=>'no data')); }
else {
  $njitURL = "https://directory.njit.edu/PersDetails.aspx?persid=$user";
  $dbData = "username=$user&password=$pass";
  $dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/login.php";

  if( acctTypeCheck($njitURL) ) { HTTPPost($dbURL, $dbData); }
  else { echo json_encode(array('login'=>'!NJIT')); }
}

function acctTypeCheck($url) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  $result = curl_exec($ch);

  if( strpos($result, "lblPersClass\">Student") ) { return true; }
  else { return false; }

  curl_close($ch);
}

function HTTPPost($url, $data) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  $result = json_decode(curl_exec($ch), true);
  
  if( $result['id'] == 'invalid' ) { echo json_encode(array('login'=>'invalid')); }
  else { echo json_encode(array('id'=>$result['id'])); }
  
	curl_close($ch);
  
}

?>