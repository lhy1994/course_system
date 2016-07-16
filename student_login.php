<?php
	include('lib\\db_operate.php');
	session_start();
	$student_num=$_POST["student_num"];
	$password=$_POST["password"];
	$pat='/[^A-Za-z0-9_]/';
	if(preg_match($pat,$student_num)!=0 || preg_match($pat,$password)!=0)
		die("Illegal character");
	if(verify(2, $student_num, $password))
	{
		$_SESSION["student_num"]=$student_num;
		echo 1;
	}
	else
		echo 0;
?>