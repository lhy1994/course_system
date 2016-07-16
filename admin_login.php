<?php
	include('lib\\db_operate.php');
	session_start();
	$admin_num=$_POST["admin_num"];
	$password=$_POST["password"];
	$pat='/[^A-Za-z0-9_]/';
	if(preg_match($pat,$admin_num)!=0 || preg_match($pat,$password)!=0)
		die("Illegal character");
	if(verify(0, $admin_num, $password))
	{
		$_SESSION["admin_num"]=$admin_num;
		echo 1;
	}
	else
		echo 0;
?>