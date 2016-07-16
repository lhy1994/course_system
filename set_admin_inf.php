<?php
	include('lib\\db_operate.php');
	$admin = new Administrator();
	$admin->id = $_POST['id'];
	$admin->name = $_POST['name'];
	$admin->gender = $_POST['gender'];
	$admin->birthday = $_POST['birthday'];
	$admin->country = $_POST['country'];
	$admin->province = $_POST['province'];
	$admin->city = $_POST['city'];
	$admin->address = $_POST['address'];
	$admin->postCode = $_POST['post_code'];
	$admin->phone = $_POST['phone'];
	setAdminInf($admin->id, $admin);
?>