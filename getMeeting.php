<?phpx

$post = json_decode(file_get_contents("php://input"), true);

$ID = $post['id'];

if( !isset($post) ) { echo json_encode(array('error'=>'no data')); }
else {
  $dbURL = "http://afsaccess3.njit.edu/~kp495/cs490/beta/getMeeting.php";
  $dbData = json_encode(array('ID'=>$ID));
  
  HTTPPost($dbURL, $dbData);


function HTTPPost($url, $data) {
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  
  $result = json_decode(curl_exec($ch), true);
  
  echo json_encode($result);
  
	curl_close($ch);
  
}

?>