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

$query_str = "SELECT procedures.*, addresses.id as aid, addresses.lat as alat, addresses.lng as alng, addresses.street as astreet, addresses.number as anumber,addresses.room as aroom, addresses.floor as afloor, addresses.contact as acontact, users.name as uname FROM procedures LEFT JOIN addresses ON addresses.id = procedures.aid LEFT JOIN users ON users.id = procedures.pid WHERE procedures.uid = '$uid' ORDER BY procedures.id DESC";
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
		$name = null;

		if ($row['id']) $id = $row['id'];

		if ($row['type']) $type = $row['type'];
		if ($row['subtype']) $subtype = $row['subtype'];
		if ($row['description']) $desc = $row['description'];
		if ($row['status']) $status = $row['status'];
		else $status = 0;

		if ($row['uname']) $name = $row['uname'];

		///////////////////
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

		if ($row['astreet']) $astreet = $row['astreet'];
		if ($row['anumber']) $anumber = $row['anumber'];

		if ($row['aroom'] && $row['aroom'] != "null") $aroom = $row['aroom'];
		else $aroom = "";
		if ($row['afloor'] && $row['afloor'] != "null") $afloor = $row['afloor'];
		else $afloor = "";

		if ($row['acontact']) $acontact = $row['acontact'];

		if ($row['alat']) $alat = $row['alat'];
		if ($row['alng']) $alng = $row['alng'];

		$aname = $astreet . " " . $anumber . " " . $afloor . " " . $aroom . " - (" . $acontact . ")";

		$address = array ('id' => $aid,'name' => $aname,'lat' => $alat,'lng' => $alng);
		///////////////////////////////////////////////////////////////////////////////

		$procedures[] = array ('id' => $id,'type' => $type,'subtype' => $subtype,'name'=> $name,'desc' => $desc,'status' => $status,'address' => $address);

		//array_push($procedures, $procedure);
	}
	$result = array ('STATUS'=>'OK','procedures'=>$procedures);
} else $result = array ('STATUS'=>'ERROR');

mysqli_close($connection);
echo json_encode($result);

?>
