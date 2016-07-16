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
				width: 35%;
			}
			
			.text-label {
				width: 100px;
				display:inline-block;
			}
			
			input {
				height: 24px;
				width: 172px;
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
				$('#search').click(function() {
					var parameter = {
						week: $('#weekText').val(),
						day: $('#dayText').val(),
						start_hour: $('#startHourText').val(),
						hours: $('#hourText').val(),
						building: $('#buildingText').val()
					};
					$.post('search_classroom.php', parameter, function(data) {
						$('tbody').empty();
						classrooms = JSON.parse(data);
						classrooms.forEach(function(item, index, array) {
							$('tbody').append('<tr><td>' + item.building + '</td><td>' + item.room + '</td></tr>');
						});
					});
				});
			});
		</script>
	</head>

	<body>

		<?php
			include('student_header.html');
		?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">自习室列表</h3>
			</div>
			<div class="panel-body" id="seletedList">
				<div>
					<h3>查询条件</h3>
					<p><span class="text-label"><strong>周次：</strong></span><input type="number" id="weekText" class="basic-input" autocomplete="off"><span class="label label-danger">必填</span></p>
					<p><span class="text-label"><strong>星期：</strong></span><input type="number" id="dayText" class="basic-input" autocomplete="off"><span class="label label-danger">必填</span></p>
					<p><span class="text-label"><strong>节次：</strong></span><input type="number" id="startHourText" class="basic-input" autocomplete="off"><span class="label label-danger">必填</span></p>
					<p><span class="text-label"><strong>节数：</strong></span><input type="number" id="hourText" class="basic-input" autocomplete="off"><span class="label label-danger">必填</span></p>
					<p><span class="text-label"><strong>教学楼：</strong></span><input type="text" id="buildingText" class="basic-input" autocomplete="off"><span class="label label-info">选填</span></p>
					<div style="margin-left:auto; margin-right:auto; width:50px">
						<span><button type="button" id="search" class="btn btn-sm btn-success">查询</button></span>
					</div>
					<table class="table">
					<thead>
						<tr>
							<th>教学楼</th>
							<th>教室号</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</div>
			</div>
		</div>
	</body>
</html>