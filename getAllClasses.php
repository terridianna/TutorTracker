<?php

$dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/getAllClasses.php";
  
HTTPPost($dbURL);

function HTTPPost($url) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  $result = json_decode(curl_exec($ch), true);
  
  echo json_encode($result);
  
	curl_close($ch);
}

?>