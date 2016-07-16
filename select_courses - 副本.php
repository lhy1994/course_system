<?php
	include('lib\\db_operate.php');
	include('lib\\course_sys.php');
	session_start();
	$student_num = $_SESSION['student_num'];
	$student = getStudentInf($student_num);
	$time_period = getTime();
	$start_time = date_parse($time_period->startTime);
	$end_time = date_parse($time_period->endTime);
	$start_time = mktime($start_time[hour], $start_time[minute], $start_time[second], $start_time[month], $start_time[day], $start_time[year]);
	$end_time = mktime($end_time[hour], $end_time[minute], $end_time[second], $end_time[month], $end_time[day], $end_time[year]);
	$current_time = time();
?>

<?php if($start_time <= $current_time && $current_time <= $end_time): ?>
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
		</style>
		<script src="js/jquery-2.1.1.min.js"></script>
		<script src="doc/script.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-toggle.js"></script>
		<script src="js/bootstrap-typeahead.js"></script>
		<script src="js/d3.v3.min.js"></script>
		<script type="text/javascript">
			
			var total_time = <?php echo $end_time - $start_time; ?>;
			var current_time = <?php echo $current_time - $start_time; ?>;
			
			setInterval(function() {
				current_time++;
				$('.progress-bar').attr('aria-valuenow', current_time.toString());
				$('.progress-bar').css('width', Math.round(current_time * 100 / total_time).toString() + '%');
				$('.progress-bar').text(Math.round(current_time * 100 / total_time).toString() + '%');
			}, 1000);
		
			$(document).ready(function() {
				
				var price = 0;
				var num = 0;
				$('#seletedList').find('.price').each(function() {
					price += parseInt($(this).text());
					++num;
				});
				$('#totalPrice').text(price);
				$('#totalNum').text(num);
				
				$(document.body).on('click', '.add-course', function() {
					var parameter = {
						stu_id: <?php echo $student_num; ?>,
						course_id: $(this).parent().prevAll('th').text()
					};
					var thisHtml = $(this).parent().parent().html();
					var $this = $(this);
					thisHtml = thisHtml.replace(/<button.*button>/, '<button type="button" class="delete-course btn btn-sm btn-primary">退课</button>');
					$.post('add_course.php', parameter, function() {
						$this.attr('disabled', 'disabled');
						$('#seletedList').find('tbody').append('<tr>' + thisHtml + '</thr>');
						var price = 0;
						var num = 0;
						$('#seletedList').find('.price').each(function() {
							price += parseInt($(this).text());
							++num;
						});
						$('#totalPrice').text(price);
						$('#totalNum').text(num);
					});
				});
				
				$(document.body).on('click', '.delete-course', function() {
					var course_id = $(this).parent().prevAll('th').text();
					var parameter = {
						stu_id: <?php echo $student_num; ?>,
						course_id: course_id
					};
					var $this = $(this);
					$.post('delete_course.php', parameter, function() {
						$(this).attr('disabled', 'disabled');
						$this.parent().parent().remove();
						$('#allList').find('tbody').children('tr').each(function() {
							if($(this).children('th').text() == course_id) {
								$(this).find('.add-course').removeAttr('disabled');
								return false;
							}
						});
						var price = 0;
						var num = 0;
						$('#seletedList').find('.price').each(function() {
							price += parseInt($(this).text());
							++num;
						});
						$('#totalPrice').text(price);
						$('#totalNum').text(num);
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
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $current_time - $start_time; ?>" aria-valuemax="<?php echo $end_time - $start_time; ?>" style="width: <?php echo ($current_time - $start_time) * 100 / ($end_time - $start_time); ?>%">
				<span>选课时间已过去<?php echo round(($current_time - $start_time) * 100 / ($end_time - $start_time)); ?>%</span>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">已选课程列表</h3>
			</div>
			<div class="panel-body" id="seletedList">
				<div style="margin:0 auto;">
					<h3>总价格<span class="label label-info"><span id="totalPrice"></span><span id="totalNum" class="badge" style="background-color:white;color:black">4</span></span></h3>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>课程id</th>
							<th>课程名</th>
							<th>类型</th>
							<th>任课老师</th>
							<th>学分</th>
							<th>课时数</th>
							<th>起始周</th>
							<th>结束周</th>
							<th>价格</th>
							<th>详情</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$current_courses = getStudentCurrentCourses($student_num);
							$is_current = array();
							foreach($current_courses as $course_id)
							{
								$is_current[$course_id] =  true;
								$course = getCourseInf($course_id);
								$courseDetail = $course->courseDetail;
								echo "
									<tr>
										<th>$course->id</th>
										<td>$course->name</td>
										<td>" . numToCourseLabel($course->type) . "</td>
										<td>" . getTeacherInf($course->teacherId)->name . "</td>
										<td>$course->credit</td>
										<td>$course->hour</td>
										<td>$course->startWeek</td>
										<td>$course->endWeek</td>
										<td class=\"price\">$course->price</td>
									<td>";
								foreach($courseDetail as $detail)
									echo '周'.numToDay($detail->day) . ": $detail->startHour~" . ($detail->startHour + $detail->hour -1) . "节，$detail->building $detail->room;";
								echo "</td><td>" . '<button type="button" class="delete-course btn btn-sm btn-primary">退课</button>' . "</td></tr>";						
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">全部课程列表</h3>
			</div>
			<div class="panel-body" id="allList">
				<table class="table">
					<thead>
						<tr>
							<th>课程id</th>
							<th>课程名</th>
							<th>类型</th>
							<th>任课老师</th>
							<th>学分</th>
							<th>课时数</th>
							<th>起始周</th>
							<th>结束周</th>
							<th>价格</th>
							<th>详情</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$entire_courses = getCurrentCourses();
							foreach($entire_courses as $course_id)
							{
								$course = getCourseInf($course_id);
								$courseDetail = $course->courseDetail;
								echo "
									<tr>
										<th>$course->id</th>
										<td>$course->name</td>
										<td>" . numToCourseLabel($course->type) . "</td>
										<td>" . getTeacherInf($course->teacherId)->name . "</td>
										<td>$course->credit</td>
										<td>$course->hour</td>
										<td>$course->startWeek</td>
										<td>$course->endWeek</td>
										<td class=\"price\">$course->price</td>
									<td>";
								foreach($courseDetail as $detail)
									echo '周'.numToDay($detail->day) . ": $detail->startHour~" . ($detail->startHour + $detail->hour -1) . "节，$detail->building $detail->room;";
								if($is_current[$course_id])
									echo "</td><td>" . '<button type="button" class="add-course btn btn-sm btn-primary" disabled="disabled">选课</button>' . "</td></tr>";
								else
									echo "</td><td>" . '<button type="button" class="add-course btn btn-sm btn-primary">选课</button>' . "</td></tr>";						
							}
						?>
					</tbody>
				</table>
			</div>
		</div>

	</body>
</html>
<?php elseif($current_time < $start_time): ?>
<!DOCTYPE html>
<html>
	<head>
		<title>还未开始选课</title>
		<link href="css/font.css"  rel="stylesheet">
        <link href="css/documentation.css"  rel="stylesheet">
        <link href="css/default.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="css/theme.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-toggle.css" rel="stylesheet">
		<link href="main-page.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/jquery.classycountdown.css" />
		<script src="js/jquery-2.1.1.min.js"></script>
        <script src="js/jquery.knob.js"></script>
        <script src="js/jquery.throttle.js"></script>
        <script src="js/jquery.classycountdown.js"></script>
		<script src="doc/script.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-toggle.js"></script>
		<script src="js/bootstrap-typeahead.js"></script>
		<script src="js/d3.v3.min.js"></script>
        <style>
            .ClassyCountdownDemo { margin:0 auto 30px auto; max-width:800px; width:calc(100%); padding:30px; display:block }
		</style>
		<script type="text/javascript">
			$(document).ready(function() {
				$('#countdown').ClassyCountdown({
					end: <?php echo $start_time; ?>,
					now: <?php echo $current_time; ?>,
					labels: true,
					style: {
						element: "",
						textResponsive: .5,
						days: {
							gauge: {
								thickness: .01,
								bgColor: "rgba(0,0,0,0.05)",
								fgColor: "#1abc9c"
							},
							textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#34495e;'
						},
						hours: {
							gauge: {
								thickness: .01,
								bgColor: "rgba(0,0,0,0.05)",
								fgColor: "#2980b9"
							},
							textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#34495e;'
						},
						minutes: {
							gauge: {
								thickness: .01,
								bgColor: "rgba(0,0,0,0.05)",
								fgColor: "#8e44ad"
							},
							textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#34495e;'
						},
						seconds: {
							gauge: {
								thickness: .01,
								bgColor: "rgba(0,0,0,0.05)",
								fgColor: "#f39c12"
							},
							textCSS: 'font-family:\'Open Sans\'; font-size:25px; font-weight:300; color:#34495e;'
						}

					},
					onEndCallback: function() {
						document.location.reload();
					}
				});
			});
		</script>
	</head>
	
	<body>
		<?php
			include('student_header.html');
		?>
		<div id="countdown" class="ClassyCountdownDemo"></div>
	</body>

</html>
<?php else: ?>
<!DOCTYPE html>
<html>
	<head>
		<title>选课时间已过</title>
		<link href="css/font.css"  rel="stylesheet">
        <link href="css/documentation.css"  rel="stylesheet">
        <link href="css/default.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet">
		<link href="css/theme.css" rel="stylesheet">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-toggle.css" rel="stylesheet">
		<link href="main-page.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/jquery.classycountdown.css" />
		<script src="js/jquery-2.1.1.min.js"></script>
        <script src="js/jquery.knob.js"></script>
        <script src="js/jquery.throttle.js"></script>
        <script src="js/jquery.classycountdown.js"></script>
		<script src="doc/script.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/bootstrap-toggle.js"></script>
		<script src="js/bootstrap-typeahead.js"></script>
		<script src="js/d3.v3.min.js"></script>
	</head>
	<body>
		<?php
			include('student_header.html');
		?>
		<h1>Oops,选课时间已过</h1>
	</body>
</html>
<?php endif; ?>