<?php
require "connect.php";

$uid = null;

$address_street = null;
$address_number = null;
$address_room = null;
$address_floor = null;
$address_cp = null;
$address_state = null;
$address_city = null;
$address_country = null;

$address_lng = null;
$address_lat = null;

$address_phone = null;
$address_contact = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {

		$uid = $_POST["uid"];

		$address_street =  $_POST["address_street"];
		$address_number =  $_POST["address_number"];
		$address_room =  $_POST["address_room"];
		$address_floor =  $_POST["address_floor"];
		$address_cp =  $_POST["address_cp"];
		$address_state =  $_POST["address_state"];
		$address_city =  $_POST["address_city"];
		$address_country =  $_POST["address_country"];

		$address_lng =  $_POST["address_lng"];
		$address_lat =  $_POST["address_lat"];

		$address_phone =  $_POST["address_phone"];
		$address_contact =  $_POST["address_contact"];
	}
} else {
	if (!empty($_GET)) {

	}
}

$result = array ();

if (!isset($uid)) $result = array ('error'=>'dataempty');
else {
	$insert_address_str = "INSERT INTO addresses (ID,UID,STREET,NUMBER,ROOM,FLOOR,CP,STATE,CITY,COUNTRY,LNG,LAT,PHONE,CONTACT) VALUES (NULL,$uid,'$address_street','$address_number','$address_room','$address_floor','$address_cp','$address_state','$address_city','$address_country','$address_lng','$address_lat','$address_phone','$address_contact')";
	$insert_address = mysqli_query($connection, $insert_address_str);
	if ($insert_address) {
		$result = array ('status'=>'OK');
	} else $result = array ('status'=>'ERROR');
}

mysqli_close($connection);
echo json_encode($result);

 ?>
