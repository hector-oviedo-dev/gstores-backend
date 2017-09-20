<?php

$error = "false";

//database configuration
$dbServer = 'localhost'; //Define database server host
//$dbUsername = 'id2388623_root'; //Define database username
$dbUsername = 'root'; //Define database username
//$dbPassword = 'Pepe1234'; //Define database password
$dbPassword = ''; //Define database password
//$dbName = 'id2388623_gstores'; //Define database name
$dbName = 'gstores'; //Define database name

//connect databse
$connection = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);

if (mysqli_connect_errno()) {
	$error = mysqli_connect_error();
	//die("Failed to connect with MySQL: ".mysqli_connect_error());
}

error_reporting(0);

$formData = json_decode(file_get_contents('php://input'));
foreach ((array) $formData as $key=>$value) {
    $_POST[$key] = $value;
}

?>
