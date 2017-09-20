<?php
require "connect.php";

$prid = null;
$pid = null;
$aid = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$prid = $_POST["prid"];
		$pid = $_POST["pid"];
		$aid = $_POST["aid"];
	}
} else {
	if (!empty($_GET)) {

	}
}

$result = array ();

if (!isset($prid)) $result = array ('error'=>'dataempty');
else {
	$query_str = "SELECT * FROM procedures WHERE id='$prid'";
	$query = mysqli_query($connection, $query_str);

	$valid = false;

	if ($query) {
		if (mysqli_num_rows($query) > 0) {
			while($row = mysqli_fetch_array($query)) if ($row['status']) $status = $row['status'];
			$valid = true;
		} else $result = array ('status'=>'NO VALID');
	} else $result = array ('status'=>'ERROR');

	if ($valid) {
		$insert_str = "INSERT INTO postulations (ID,PRID,PID,AID) VALUES (NULL,'$prid','$pid','$aid')";
		$insert = mysqli_query($connection, $insert_str);

		if ($insert) {
			$update_str = "UPDATE procedures SET status='1' WHERE id='$prid'";
			$update = mysqli_query($connection, $update_str);

			if ($update) $result = array ('status'=>'OK');
			else $result = array ('status'=>'UPDATE ERROR');
		} else $result = array ('status'=>'INSERT ERROR');
	} else $result = array ('status'=>'NO VALID 2');
}

mysqli_close($connection);
echo json_encode($result);

 ?>
