<?php
	include('lib\\db_operate.php');
	$week = $_POST['week'];
	$day = $_POST['day'];
	$start_hour = $_POST['start_hour'];
	$hours = $_POST['hours'];
	$building = $_POST['building'];
	echo json_encode(getEmptyClassRoom($week, $day, $start_hour, $hours, $building));
?>