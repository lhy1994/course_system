<?php
	//This version use mpdf
	$html = '
	<table class="gridtable">
			<thead>
				<tr>
					<th>#</th>
					<th>周日</th>
					<th>周一</th>
					<th>周二</th>
					<th>周三</th>
					<th>周四</th>
					<th>周五</th>
					<th>周六</th>
				</tr>
			</thead>
			<tbody>
				<tr><th>1</th><td></td><td></td><td></td><td>软件工程(2~15 周)<br>逸夫楼, 301;<br></td><td></td><td></td><td></td></tr><tr><th>2</th><td></td><td></td><td>网页设计(1~12 周)<br>三教, 101;<br></td><td>软件工程(2~15 周)<br>逸夫楼, 301;<br></td><td></td><td></td><td></td></tr><tr><th>3</th><td></td><td></td><td>网页设计(1~12 周)<br>三教, 101;<br></td><td>软件工程(2~15 周)<br>逸夫楼, 301;<br>软件工程(2~15 周)<br>逸夫楼, 105;<br></td><td></td><td></td><td></td></tr><tr><th>4</th><td></td><td></td><td>网页设计(1~12 周)<br>三教, 101;<br></td><td>软件工程(2~15 周)<br>逸夫楼, 105;<br></td><td></td><td></td><td></td></tr><tr><th>5</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><th>6</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><th>7</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><th>8</th><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>			</tbody>
		</table>
	';
	$css = '
		table.gridtable {
			font-family: verdana,arial,sans-serif;
			font-size:11px;
			color:#333333;
			border-width: 1px;
			border-color: #666666;
			border-collapse: collapse;
		}
		table.gridtable th {
			border-width: 1px;
			padding: 8px;
			border-style: solid;
			border-color: #666666;
			background-color: #dedede;
			text-a
		}
		table.gridtable td {
			border-width: 1px;
			width: 150px;
			padding: 8px;
			border-style: solid;
			border-color: #666666;
			background-color: #ffffff;
		}
	';
	ini_set("memory_limit","516M");
	include("mpdf60/mpdf.php");
	$mpdf = new mPDF('zh-CN'); 
	$mpdf->useAdobeCJK = true;
	$mpdf->WriteHTML($html);
	$mpdf->Output();

?>