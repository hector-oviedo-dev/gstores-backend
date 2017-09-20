<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');*/

require "connect.php";

$result = array ();

$logged = false;

$uid = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$uid = $_POST["uid"];
	}
} else {
	if (!empty($_GET)) {
		$uid = $_GET["uid"];
	}
}

$query_str = "SELECT * FROM addresses WHERE UID = '$uid' ORDER BY ID DESC";
$query = mysqli_query($connection, $query_str) or $error = mysqli_error();

$addresses;

if ($query) {
	while($row = mysqli_fetch_array($query)) {
		$address = array();

		$aid = null;

		$astreet = null;
		$anumber = null;

		$aroom = null;
		$afloor = null;

		$acontact = null;

		$alng = null;
		$alat = null;

		if ($row['id']) $aid = $row['id'];

		if ($row['street']) $astreet = $row['street'];
		if ($row['number']) $anumber = $row['number'];

		if ($row['room'] && $row['room'] != "null") $aroom = $row['room'];
		else $aroom = "";
		if ($row['floor'] && $row['floor'] != "null") $afloor = $row['floor'];
		else $afloor = "";

		if ($row['contact']) $acontact = $row['contact'];

		if ($row['lat']) $alat = $row['lat'];
		if ($row['lng']) $alng = $row['lng'];

		$aname = $astreet . " " . $anumber . " " . $afloor . " " . $aroom . " - (" . $acontact . ")";

		$addresses[] = array ('id' => $aid,'name' => $aname,'lat' => $alat,'lng' => $alng);
	}
	$result = array ('STATUS'=>'OK','addresses'=>$addresses);
	$resultvalid = true;
} else $result = array ('STATUS'=>'ERROR');

mysqli_close($connection);
echo json_encode($result);

?>
