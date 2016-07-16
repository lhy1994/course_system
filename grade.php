<?php
	session_start();
	$teacher_num = $_SESSION['teacher_num'];
	include('lib\\db_operate.php');
	$teacher = getTeacherInf($teacher_num);
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
				width: 800px;
			}
		</style>		
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="doc/script.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-toggle.js"></script>
		<script src="js/bootstrap-typeahead.js"></script>
		<script src="js/d3.v3.min.js"></script>
		<script type="text/javascript">
			<?php
				$current_courses = getTeacherCurrentCourse($teacher_num);
				$not_evaluated = array();
				foreach($current_courses as $course)
				{
					$total += count(getCourseStudent($course));
					$not_evaluated_students = getCourseNotEvaluateStudent($course);
					$finished -= count($not_evaluated_students);
					$not_evaluated[$course] = array();
					foreach($not_evaluated_students as $student)
						$not_evaluated[$course][$student]=true;
				}
				$finished += $total;
				$percentage = round($finished * 100 / $total);
			?>
			
			var total = <?php echo $total; ?>;
			var finished = <?php echo $finished; ?>;
			
			$(document).ready(function() {
				
				$('.course-tab').first().addClass('active');
				$('.panel').hide();
				$('.panel').first().show();
				
				$('.confirm').bind('click', function() {
					var $this = $(this);
					var status_label = $(this).parent().parent().find('.label');
					var stu_id = $(this).parent().prevAll('th').text();
					var score_text = $(this).parent().parent().find('.score');
					var parameter  = {
						stu_id: stu_id,
						course_id: $(this).parent().parent().parent().parent().parent().parent().attr('courseId'),
						score : score_text.val()
					};
					$.post('set_student_score.php', parameter, function() {
						$this.attr('disabled', 'disabled');
						score_text.attr('disabled', 'disabled');
						status_label.removeClass('label-danger');
						status_label.addClass('label-success');
						status_label.text('已评分');
						finished += 1;
						$('.progress-bar').attr('aria-valuenow', finished.toString());
						$('.progress-bar').css('width', Math.round(finished * 100 / total).toString() + '%');
						$('.progress-bar').text(Math.round(finished * 100 / total).toString() + '%');
					});
				});
				
				$('.course-tab').bind('click', function() {
					$('.active').removeClass('active');
					$(this).addClass('active');
					$('.panel').hide();
					$('#c' + $(this).attr('courseId')).show();
				});
			});
		</script>
	</head>		

	<body>
		
		<?php
			function scoreText($status, $student_id, $course_id)
			{
				if($status)
					return '<input type="number" min="0" max="100" class="score basic-input" autocomplete="off">';
				else
					return '<input type="number" min="0" max="100" class="score basic-input" autocomplete="off" disabled="disabled" value="' . getStudentScore($student_id, $course_id) . '">';
			}
			
			function statusLabel($status)
			{
				if($status)
					return '<span class="label label-danger">未评分</span>';
				else
					return '<span class="label label-success">已评分</span>';
			}
			
			function confirmButton($status)
			{
				if($status)
					return '<button type="button" class="confirm btn btn-sm btn-primary">评分</button>';
				else
					return '<button type="button" class="confirm btn btn-sm btn-primary" disabled="disabled">评分</button>';
			}
			
			include('teacher_header.html');
		?>
			
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $finished; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total; ?>" style="width: <?php echo $percentage; ?>%;">
					<?php echo $percentage; ?>%
				</div>
			</div>
		<?php
			echo '<ul class="nav nav-tabs">';
			foreach($current_courses as $course_id)
			{
				$course = getCourseInf($course_id);
				echo '<li role="presentation" class="course-tab" courseId="' . $course_id . '"><a>' . $course->name . '</a></li>';
			}
			echo '</ul>';
			foreach($current_courses as $course_id)
			{
				echo '
					<div class="panel panel-primary" id="c' . $course_id . '" courseId="' . $course_id . '">
						<div class="panel-heading">
							<h3 class="panel-title">学生列表</h3>
						</div>
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>学号</th>
										<th>姓名</th>
										<th>成绩</th>
										<th>状态</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>';
								
				$students = getCourseStudent($course_id);
				foreach($students as $student_id)
				{
					$student = getStudentInf($student_id);
					echo "
						<tr>
							<th>$student->id</th>
							<td>$student->name</td>
							<td>" . scoreText($not_evaluated[$course_id][$student_id], $student_id, $course_id) . "</td>
							<td>" . statusLabel($not_evaluated[$course_id][$student_id]) . "</td>
							<td>" . confirmButton($not_evaluated[$course_id][$student_id]) . "</td>
						</tr>";
				}
				
				echo '
								</tbody>
							</table>
						</div>
					</div>';
			}
		?>
		<!--ul class="nav nav-tabs">
			<li role="presentation" class="active"><a href="#">Home</a></li>
			<li role="presentation"><a href="#">Profile</a></li>
			<li role="presentation"><a href="#">Messages</a></li>
		</ul-->
	</body>
</html>