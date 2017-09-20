<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');*/

require "connect.php";

$result = array ();

$logged = false;

$id = null;
$user = "";
$pass = "";
$type = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$user = $_POST["user"];
		$pass = $_POST["pass"];
	}
} else {
	if (!empty($_GET)) {
		$user = $_GET["user"];
		$pass = $_GET["pass"];
	}
}

$query_str = "SELECT * FROM users WHERE DNI = '$user' AND PASSWORD = '$pass'";
$query = mysqli_query($connection, $query_str) or $error = mysqli_error();

if (mysqli_num_rows($query) > 0) {
	while($row = mysqli_fetch_array($query)) {
		if ($row['id']) $id = $row['id'];
		if ($row['type']) $type = $row['type'];
	}
	$logged = true;
} else {
	$logged = false;
}

if ($logged) $result = array ('status'=>'OK','id'=>$id,'type'=>$type);
else $result = array ('status'=>'ERROR');

mysqli_close($connection);
echo json_encode($result);

?>
