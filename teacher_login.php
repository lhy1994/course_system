<?php
	include('lib\\db_operate.php');
	session_start();
	$teacher_num=$_POST["teacher_num"];
	$password=$_POST["password"];
	$pat='/[^A-Za-z0-9_]/';
	if(preg_match($pat,$teacher_num)!=0 || preg_match($pat,$password)!=0)
		die("Illegal character");
	if(verify(1, $teacher_num, $password))
	{
		$_SESSION["teacher_num"]=$teacher_num;
		echo 1;
	}
	else
		echo 0;
?>