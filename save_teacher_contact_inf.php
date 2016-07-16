<?php
	include('lib\\db_operate.php');
	$teacher_id = $_POST['teacher_id'];
	$country = $_POST['country'];
	$province = $_POST['province'];
	$city = $_POST['city'];
	$address = $_POST['address'];
	$post_code = $_POST['post_code'];
	$phone = $_POST['phone'];
	$student = getTeacherInf($teacher_id);
	$student->country = $country;
	$student->province = $province;
	$student->city = $city;
	$student->address = $address;
	$student->postCode = $post_code;
	$student->phone = $phone;
	setTeacherInf($teacher_id, $student);
?>