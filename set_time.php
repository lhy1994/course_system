<?php
	session_start();
	$admin_num = $_SESSION['admin_num'];
	include('lib\\db_operate.php');
	$time = new TimePeriod();
	$time->startTime = $_POST['start_time'];
	$time->endTime = $_POST['end_time'];
	setTime($time);	
?>