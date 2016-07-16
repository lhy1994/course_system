<?php
	include('lib\\db_operate.php');
	$course = new Course();
	$course->id = $_POST['id'];
	$course->teacherId = $_POST['teacher_id'];
	$course->name = $_POST['name'];
	$course->type = $_POST['type'];
	$course->credit = $_POST['credit'];
	$course->hour = $_POST['hour'];
	$course->startWeek = $_POST['start_week'];
	$course->endWeek = $_POST['end_week'];
	$course->price = $_POST['price'];
	$course->courseDetail = json_decode(stripcslashes($_POST['details']));
	setCourseInf($course->id, $course);
?>