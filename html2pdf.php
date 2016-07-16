<?php
	//This version use mpdf
	$html = stripcslashes($_POST['data']);
	ini_set("memory_limit","516M");
	include("mpdf60/mpdf.php");
	$mpdf = new mPDF('zh-CN'); 
	$mpdf->useAdobeCJK = true;
	$mpdf->WriteHTML($html);
	$mpdf->Output();
?>