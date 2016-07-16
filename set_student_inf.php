<?php
	include('lib\\db_operate.php');
	$student = new Student();
	$student->id = $_POST['id'];
	$student->name = $_POST['name'];
	$student->gender = $_POST['gender'];
	$student->birthday = $_POST['birthday'];
	$student->credit = $_POST['credit'];
	$student->country = $_POST['country'];
	$student->province = $_POST['province'];
	$student->city = $_POST['city'];
	$student->address = $_POST['address'];
	$student->postCode = $_POST['post_code'];
	$student->phone = $_POST['phone'];
	setStudentInf($student->id, $student);
?>