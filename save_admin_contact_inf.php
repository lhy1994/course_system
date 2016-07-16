<?php
	include('lib\\db_operate.php');
	$admin_id = $_POST['admin_id'];
	$country = $_POST['country'];
	$province = $_POST['province'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$post_code = $_POST['post_code'];
	$phone = $_POST['phone'];
	$admin = getAdminInf($admin_id);
	$student->country = $country;
	$student->province = $province;
	$student->city = $city;
	$student->address = $address;
	$student->postCode = $post_code;
	$student->phone = $phone;
	setAdminInf($admin_id, $admin);
?>