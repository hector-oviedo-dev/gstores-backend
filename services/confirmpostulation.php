<?php
require "connect.php";

$uid = null;
$aid = null;

$type = null;
$subtype = null;
$desc = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$pid = $_POST["pid"];
		$prid = $_POST["prid"];
	}
} else {
	if (!empty($_GET)) {

	}
}

$result = array ();

if (!isset($pid) || !isset($prid)) $result = array ('error'=>'dataempty');
else {
	$query_str = "UPDATE procedures SET status='2', pid='$pid' WHERE id='$prid'";
	$query = mysqli_query($connection, $query_str);

	if ($query) $result = array ('status'=>'OK');
	else $result = array ('status'=>'ERROR');
}

mysqli_close($connection);
echo json_encode($result);

 ?>
