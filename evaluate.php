<?php
	include('lib\\db_operate.php');
	include('lib\\course_sys.php');
	session_start();
	$student_num = $_SESSION['student_num'];
	$student = getStudentInf($student_num);
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
				$current_courses = getStudentCurrentCourses($student_num);
				$not_evaluate_courses = getNotEvaluateCourse($student_num);
				$total = count($current_courses);
				$finished = count($current_courses) - count($not_evaluate_courses);
				$percentage = round($finished * 100 / $total);
			?>
			
			var total = <?php echo $total; ?>;
			var finished = <?php echo $finished; ?>;
			
			$(document).ready(function() {
				$('.confirm').bind('click', function() {
					var $this = $(this);
					var status_label = $(this).parent().parent().find('.label');
					var course_id = $(this).parent().prevAll('th').text();
					var score_text = $(this).parent().parent().find('.score');
					var parameter  = {
						stu_id: <?php echo $student_num; ?>,
						course_id: course_id,
						score : score_text.val()
					};
					$.post('set_teacher_score.php', parameter, function() {
						$this.attr('disabled', 'disabled');
						score_text.attr('disabled', 'disabled');
						status_label.removeClass('label-danger');
						status_label.addClass('label-success');
						status_label.text('已评价');
						finished += 1;
						$('.progress-bar').attr('aria-valuenow', finished.toString());
						$('.progress-bar').css('width', Math.round(finished * 100 / total).toString() + '%');
						$('.progress-bar').text(Math.round(finished * 100 / total).toString() + '%');
					});
				});
			});
		</script>
	</head>

	<body>
	
		<?php
			include('student_header.html');
		?>
		
		<div class="progress">
			<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $finished; ?>" aria-valuemin="0" aria-valuemax="<?php echo $total; ?>" style="width: <?php echo $percentage; ?>%;">
				<?php echo $percentage; ?>%
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">教评列表</h3>
			</div>
			<div class="panel-body" id="seletedList">
				<table class="table">
					<thead>
						<tr>
							<th>课程id</th>
							<th>课程名</th>
							<th>任课老师</th>
							<th>评分</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
							function scoreText($status, $course_id)
							{
								global $student_num;
								if($status)
									return '<input type="number" min="0" max="100" class="score basic-input" autocomplete="off">';
								else
									return '<input type="number" min="0" max="100" class="score basic-input" autocomplete="off" disabled="disabled" value="' . getTeacherScore($student_num, $course_id) . '">';
							}
							
							function statusLabel($status)
							{
								if($status)
									return '<span class="label label-danger">未评价</span>';
								else
									return '<span class="label label-success">已评价</span>';
							}
							
							function confirmButton($status)
							{
								if($status)
									return '<button type="button" class="confirm btn btn-sm btn-primary">评价</button>';
								else
									return '<button type="button" class="confirm btn btn-sm btn-primary" disabled="disabled">评价</button>';
							}
							
							$not_evaluated = array();
							foreach($not_evaluate_courses as $course_id)
							{
								$not_evaluated[$course_id] = true;
							}
							foreach($current_courses as $course_id)
							{
								$course = getCourseInf($course_id);
								$courseDetail = $course->courseDetail;
								echo "
									<tr>
										<th>$course->id</th>
										<td>$course->name</td>
										<td>" . getTeacherInf($course->teacherId)->name . "</td>
										<td>" . scoreText($not_evaluated[$course_id], $course_id) . "</td>
										<td>" . statusLabel($not_evaluated[$course_id]) . "</td>
										<td>" . confirmButton($not_evaluated[$course_id]) . "</td>
									</tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>

	</body>
</html>