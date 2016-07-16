<?php
	include('lib\\db_operate.php');
	session_start();
	$student_num = $_SESSION['student_num'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>COURSE SYS</title>

		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="css/theme.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-toggle.css" rel="stylesheet">
		<link href="main-page.css" rel="stylesheet">
		<style>
			.panel {
				width: 1200px;
			}
			
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

		</style>
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="doc/script.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-toggle.js"></script>
		<script src="js/bootstrap-typeahead.js"></script>
		<script src="js/d3.v3.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#output').click(function() {
					$('#pdfData').val($('#table').html());
					//console.log($('#pdfData').val());
					$('#pdfForm').submit();
				});
			});
		</script>
		</head>

	<body>

		<?php
			include('student_header.html');
		?>
		<div id="table">
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
					<?php
						$current_courses = getStudentCurrentCourses($student_num);
						$schedule = array();
						for($i = 1; $i <= 8; ++$i)
							$schedule[$i] = array();
						foreach($current_courses as $course_id)
						{
							$course = getCourseInf($course_id);
							$courseDetail = $course->courseDetail;
							foreach($courseDetail as $detail)
								for($j = $detail->startHour; $j < $detail->startHour + $detail->hour; ++$j)
									$schedule[$j][$detail->day] .= "$course->name($course->startWeek~$course->endWeek 周)<br>$detail->building, $detail->room;<br>";
						}
						for($i = 1; $i <=8; ++$i)
						{
							echo "<tr><th>$i</th>";
							for($j = 0; $j < 7; ++$j)
								echo '<td>' . $schedule[$i][$j] . '</td>';
							echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
		<div style="margin:20px auto; width:70px"><button type="button" id="output" class="delete-course btn btn-sm btn-primary">导出PDF</button></div>
		<form id="pdfForm" target="_blank" method="post" action="html2pdf.php">
			<input id="pdfData" type="hidden" name="data" value="">
		</form>
	</body>

</html>