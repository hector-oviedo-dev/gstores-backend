<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');*/

require "connect.php";

$result = array ();


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

//$query_str = "SELECT * FROM procedures LEFT JOIN addresses ON addresses.id = procedures.aid WHERE procedures.pid = '$uid' ORDER BY procedures.id DESC";
$inner1 = " INNER JOIN addresses AS address ON address.id = procedures.aid";
$inner2 = " INNER JOIN users ON users.id = procedures.uid";

$query_str = "SELECT procedures.*, users.id as userid, users.name as username FROM procedures " . $inner1 . $inner2 . " WHERE procedures.pid = '$uid' ORDER BY procedures.id DESC";
$query = mysqli_query($connection, $query_str) or $error = mysqli_error();

$procedures;

if ($query) {
	while($row = mysqli_fetch_array($query)) {
		$procedure = array();

		$id = null;

		$type = null;
		$subtype = null;
		$desc = null;
		$status = null;

		if ($row['id']) $id = $row['id'];

		if ($row['type']) $type = $row['type'];
		if ($row['subtype']) $subtype = $row['subtype'];
		if ($row['description']) $desc = $row['description'];
		if ($row['status']) $status = $row['status'];
		else $status = "0";
		if ($row['username']) $username = $row['username'];

		////////////////////
		$address = array();

		$aid = null;

		$astreet = null;
		$anumber = null;

		$aroom = null;
		$afloor = null;

		$acontact = null;

		$alng = null;
		$alat = null;

		if ($row['aid']) $aid = $row['aid'];

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

		$address = array ('id' => $aid,'name' => $aname,'lat' => $alat,'lng' => $alng);
		///////////////////////////////////////////////////////////////////////////////

		$procedures[] = array ('id' => $id,'type' => $type,'subtype' => $subtype,'desc' => $desc,'status' => $status,'address' => $address,'username' => $username);

		//array_push($procedures, $procedure);
	}
	$result = array ('STATUS'=>'OK','procedures'=>$procedures);
} else $result = array ('STATUS'=>'ERROR');

mysqli_close($connection);
echo json_encode($result);

?>
