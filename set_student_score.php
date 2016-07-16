<?php
	include('lib\db_operate.php');
	$stu_id = $_POST['stu_id'];
	$course_id = $_POST['course_id'];
	$score = $_POST['score'];
	setStudentScore($stu_id, $course_id, $score);
?>