<?php
	session_start();
	$admin_num = $_SESSION['admin_num'];
	include('lib\\db_operate.php');
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
			
			button {
				margin: 2px;
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
				$(document.body).on('click', '.edit', function() {
					$('#studentID').val($(this).parent().prevAll('th').text());
					$('#editReq').submit();
				});
				
				$(document.body).on('click', '.delete', function() {
					var parameter = {
						id: $(this).parent().prevAll('th').text()
					};
					$this = $(this);
					$.post('delete_student_inf.php', parameter, function() {
						$this.parent().parent().remove();
					});
				});
			});
		</script>
	</head>

	<body>
		<?php
			include('admin_header.html');
		?>
		
		<form id="editReq" method="post" action="edit_student_inf.php">
			<input id="studentID" type="hidden" name="student_id" value="">
		</form>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">学生列表</h3>
			</div>
			<div class="panel-body" id="genePanel">
				<table class="table">
					<thead>
						<tr>
							<th>学号</th>
							<th>姓名</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
				<?php
					$students = getAllStudents();
					foreach($students as $student_id)
					{
						$student = getStudentInf($student_id);
						echo "
						<tr>
							<th>$student->id</th>
							<td>$student->name</td>" . '
							<td><button type="button" class="edit btn btn-sm btn-primary">编辑</button><button type="button" class="delete btn btn-sm btn-danger">删除</button></td>
						</tr>';
					}
				?>
					</tbody>
			</div>
		</div>
		
	</body>
</html>