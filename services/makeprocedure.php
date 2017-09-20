<?php
require "connect.php";

$uid = null;
$aid = null;

$type = null;
$subtype = null;
$desc = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$uid = $_POST["uid"];
		$aid = $_POST["aid"];

		$type = $_POST["type"];
		$subtype = $_POST["subtype"];
		$desc = $_POST["desc"];
	}
} else {
	if (!empty($_GET)) {

	}
}

$result = array ();

if (!isset($type)) $result = array ('error'=>'dataempty');
else {
	$insert_str = "INSERT INTO procedures (ID,UID,PID,AID,TYPE,SUBTYPE,DESCRIPTION,STATUS) VALUES (NULL,'$uid',NULL,'$aid','$type','$subtype','$desc','0')";
	$insert = mysqli_query($connection, $insert_str);

	if ($insert) $result = array ('status'=>'OK');
	else $result = array ('status'=>'ERROR');
}

mysqli_close($connection);
echo json_encode($result);

 ?>
