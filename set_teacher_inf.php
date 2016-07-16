<?php
	include('lib\\db_operate.php');
	$teacher = new Teacher();
	$teacher->id = $_POST['id'];
	$teacher->name = $_POST['name'];
	$teacher->gender = $_POST['gender'];
	$teacher->birthday = $_POST['birthday'];
	$teacher->title = $_POST['title'];
	$teacher->salary = $_POST['salary'];
	$teacher->evaluateNum = $_POST['evaluate_num'];
	$teacher->score = $_POST['score'];
	$teacher->country = $_POST['country'];
	$teacher->province = $_POST['province'];
	$teacher->city = $_POST['city'];
	$teacher->address = $_POST['address'];
	$teacher->postCode = $_POST['post_code'];
	$teacher->phone = $_POST['phone'];
	setTeacherInf($teacher->id, $teacher);
?>