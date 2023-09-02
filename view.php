<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

 $conn = mysqli_connect('localhost', 'root','', 'student');

if(!$conn){
die('connection Error' . mysql_connect_error());
 }
   echo "successfully connected";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$email = $data['email'];
$address = $data['address'];
$sql = "INSERT INTO users (name, email, address) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt) {
   mysqli_stmt_bind_param($stmt, "sss", $name, $email, $address);
   if (mysqli_stmt_execute($stmt)) {
      http_response_code(201); // Created
      echo json_encode(array("message" => "Data inserted successfully"));
  } else {
      http_response_code(500); // Internal Server Error
      echo json_encode(array("message" => "Failed to insert data: " . mysqli_error($conn)));
  }
  
  // Close the statement
  mysqli_stmt_close($stmt);
  
}
else{
   http_response_code(500); 
   echo json_encode(array("message" => "Failed to prepare the SQL statement"));
}
}
 else {

$sql = "SELECT * from users";
   $mysqli = mysqli_query($conn, $sql);
   $json_data = array();
   while($row = mysqli_fetch_assoc($mysqli)){
   $json_data[] = $row;
   }
    echo json_encode(['phpresult' => $json_data]);
}
mysqli_close($conn);
// die;

?> 
