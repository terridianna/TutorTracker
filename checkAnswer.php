<?php

session_start();

$post = json_decode(file_get_contents("php://input"), true);

$code = $post['answer'];
$qID = $post['qID'];

if( !isset($post) ) { echo json_encode(array('error'=>'no data')); }
else {
  $dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/getQuestion.php";
  $dbData = json_encode(array('get'=>'answer', 'qID'=>$qID));
  
  HTTPPost($dbURL, $dbData);
  checkAns($code, $_SESSION['method'], $_SESSION['test'], $_SESSION['answer']);
  
}

function HTTPPost($url, $data) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  $result = json_decode(curl_exec($ch), true);
  
  $_SESSION['method'] = $result['name'];
  $_SESSION['test'] = $result['test'];
  $_SESSION['answer'] = $result['answer'];
  
	curl_close($ch);
}

function checkAns($userCode, $method, $test, $ans) {
  $score = 10;
  
  $errors = array();

  if( !strpos($userCode, $method) ) {
    $score -= 4;
    $errors['method'] = "Incorrect method name";
    // change header if incorrect
    $userCode = preg_replace('/^def.*[(]/', 'def '.$method.'(', $userCode);
  }
  
  if( !strpos($userCode, ":") ) {
    $score -= 1;
    $errors['colon'] = "Missing : at end of method declaration";
  }
  
  if( !strpos($userCode, "return") ) {
    $score -= 1;
    $errors['return'] = "No return statement";
  }
  
  $file = fopen("test.py", "w");
  fwrite($file, $userCode);
  fwrite($file, "\nprint($test)");
  fclose($file);
  
  $output = exec("python test.py");
  
  if( $output !== $ans ) {
    $score -= 4;
    $errors['output'] = "Incorrect output";
  }
  
  echo json_encode(array('errors'=>$errors, 'score'=>$score));
}

?>