<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');*/

require "connect.php";

$result = array ();


$prid = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$prid = $_POST["prid"];
	}
} else {
	if (!empty($_GET)) {
		$prid = $_GET["prid"];
	}
}

$query_str = "SELECT postulations.*, addresses.id as aid, addresses.lat as alat, addresses.lng as alng, addresses.street as astreet, addresses.number as anumber,addresses.room as aroom, addresses.floor as afloor, addresses.contact as acontact FROM postulations LEFT JOIN addresses ON addresses.id = postulations.aid WHERE postulations.prid = '$prid' ORDER BY postulations.id DESC";
$query = mysqli_query($connection, $query_str) or $error = mysqli_error();

$postulations;

if ($query) {
	while($row = mysqli_fetch_array($query)) {
		$id = null;
		$pid = mull;

		$type = null;
		$subtype = null;
		$desc = null;
		$status = null;

		if ($row['id']) $id = $row['id'];
		if ($row['pid']) $pid = $row['pid'];

		$astreet = null;
		$anumber = null;

		$aroom = null;
		$afloor = null;

		$acontact = null;

		$alng = null;
		$alat = null;

		if ($row['astreet']) $astreet = $row['astreet'];
		if ($row['anumber']) $anumber = $row['anumber'];

		if ($row['aroom'] && $row['aroom'] != "null") $aroom = $row['aroom'];
		else $aroom = "";
		if ($row['afloor'] && $row['floor'] != "null") $afloor = $row['afloor'];
		else $afloor = "";

		if ($row['acontact']) $acontact = $row['acontact'];

		if ($row['alat']) $alat = $row['alat'];
		if ($row['alng']) $alng = $row['alng'];

		$aname = $astreet . " " . $anumber . " " . $afloor . " " . $aroom . " - (" . $acontact . ")";
		///////////////////////////////////////////////////////////////////////////////

		$postulations[] = array ('id' => $id,'pid' => $pid,'name' => $aname,'lat' => $alat,'lng' => $alng);

		//array_push($procedures, $procedure);
	}
	$result = array ('STATUS'=>'OK','postulations'=>$postulations);
} else $result = array ('STATUS'=>'ERROR');

mysqli_close($connection);
echo json_encode($result);

?>
