<?php
	session_start();
	$admin_num = $_SESSION['admin_num'];
	include('lib\\db_operate.php');
	$time = getTime();
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
					$('#courseID').val($(this).parent().prevAll('th').text());
					$('#editReq').submit();
				});
				
				$(document.body).on('click', '.delete', function() {
					var parameter = {
						id: $(this).parent().prevAll('th').text()
					};
					$this = $(this);
					$.post('delete_course_inf.php', parameter, function() {
						$this.parent().parent().remove();
					});
				});
				
				$('input').bind('input', function() {
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
				
				$('input').bind('focus', function() {
					$('.alert').hide(500);
				});
				
				$('#save').click(function() {
					$('.alert').hide(500);
					var parameter = {
						start_time: $('#startTimeText').val(),
						end_time: $('#endTimeText').val()
					};
					var $this = $(this);
					$.post('set_time.php', parameter, function() {
						$('#success').text('成功保存信息');
						$('#success').show(500);
						$this.attr('disabled', 'disabled');
					});
				});
			});
		</script>
	</head>

	<body>
		<?php
			include('admin_header.html');
		?>
		
		<form id="editReq" method="post" action="edit_course_inf.php">
			<input id="courseID" type="hidden" name="course_id" value="">
		</form>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">选课时间</h3>
			</div>
			<div class="panel-body">
				<p><span class="text-label"><strong>开始时间：</strong></span><input type="date" id="startTimeText" class="basic-input" autocomplete="off" value="<?php echo $time->startTime; ?>"></p>
				<p><span class="text-label"><strong>结束时间：</strong></span><input type="date" id="endTimeText" class="basic-input" autocomplete="off" value="<?php echo $time->endTime; ?>"></p>
				<div style="margin-left:auto; margin-right:auto; width:50px"><button type="button" id="save" class="delete-course btn btn-sm btn-primary" disabled="disabled">保存</button></div>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">课程列表</h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th>id</th>
							<th>课程名</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
				<?php
					$courses = getCurrentCourses();
					foreach($courses as $course_id)
					{
						$course = getCourseInf($course_id);
						echo "
						<tr>
							<th>$course->id</th>
							<td>$course->name</td>" . '
							<td><button type="button" class="edit btn btn-sm btn-primary">编辑</button><button type="button" class="delete btn btn-sm btn-danger">删除</button></td>
						</tr>';
					}
				?>
					</tbody>
			</div>
		</div>
		
	</body>
</html>