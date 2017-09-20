<?php
require "connect.php";

$name = null;
$dni = null;
$email = null;

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

$mercadopago = null;

$bank_number = null;
$bank_type = null;
$bank_cbu = null;

$password = null;

$type = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST)) {
		$name = $_POST["name"];
		$dni = $_POST["dni"];
		$email = $_POST["email"];

		$address_street = $_POST["address_street"];
		$address_number = $_POST["address_number"];
		$address_room = $_POST["address_room"];
		$address_floor = $_POST["address_floor"];
		$address_cp = $_POST["address_cp"];
		$address_state = $_POST["address_state"];
		$address_city = $_POST["address_city"];
		$address_country = $_POST["address_country"];

		$address_lng = $_POST["address_lng"];
		$address_lat = $_POST["address_lat"];

		$address_phone = $_POST["address_phone"];
		$address_contact = $_POST["address_contact"];

		$mercadopago = $_POST["mercadopago"];

		$bank_number = $_POST["bank_number"];
		$bank_type = $_POST["bank_type"];
		$bank_cbu = $_POST["bank_cbu"];

		$password = $_POST["password"];

		$type = $_POST["type"];
	}
} else {
	if (!empty($_GET)) {

	}
}

$result = array ();

if (!isset($type)) $result = array ('error'=>'dataempty');
else {
	$insert_str = "INSERT INTO users (ID,NAME,DNI,EMAIL,MERCADOPAGO,BANK_NUMBER,BANK_TYPE,BANK_CBU,PASSWORD,TYPE) VALUES (NULL,'$name','$dni','$email','$mercadopago','$bank_number','$bank_type','$bank_cbu','$password','$type')";
	$insert = mysqli_query($connection, $insert_str);

	if ($insert) {
		$uid = mysqli_insert_id($connection);
		$insert_address_str = "INSERT INTO addresses (ID,UID,STREET,NUMBER,ROOM,FLOOR,CP,STATE,CITY,COUNTRY,LNG,LAT,PHONE,CONTACT) VALUES (NULL,$uid,'$address_street','$address_number','$address_room','$address_floor','$address_cp','$address_state','$address_city','$address_country','$address_lng','$address_lat','$address_phone','$address_contact')";
		$insert_address = mysqli_query($connection, $insert_address_str);
		if ($insert_address) {
			$result = array ('status'=>'OK');
		} else $result = array ('status'=>'ERROR');
	} else $result = array ('status'=>'ERROR');
}

mysqli_close($connection);
echo json_encode($result);

 ?>
