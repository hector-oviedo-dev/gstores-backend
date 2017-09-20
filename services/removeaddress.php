<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');*/

require "connect.php";

$result = array ();


$id = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$id = $_POST["id"];
	}
} else {
	if (!empty($_GET)) {
		$id = $_GET["id"];
	}
}

$query_str = "DELETE FROM addresses WHERE id='$id'";
$query = mysqli_query($connection, $query_str) or $error = mysqli_error();

if ($query) {
	$result = array ('STATUS'=>'OK');
} else $result = array ('STATUS'=>'ERROR');

mysqli_close($connection);
echo json_encode($result);

?>
