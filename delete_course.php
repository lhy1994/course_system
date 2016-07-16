<?php
	$stu_id = $_POST['stu_id'];
	$course_id = $_POST['course_id'];
	include('lib\\db_operate.php');
	studentDeleteCourse($stu_id, $course_id);
?>