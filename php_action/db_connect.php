<?php 	

$localhost = "127.0.0.1";
$username = "root";
$password = "D)4ub7XFetWJswy)";
$dbname = "pos_stock";

// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>