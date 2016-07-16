<?php
	session_start();
	$admin_num = $_SESSION['admin_num'];
	include('lib\\db_operate.php');
	$course_id = $_POST['course_id'];
	$course = getCourseInf($course_id);
	
	function numToCourseType($num)
	{
		switch($num)
		{
			case 0: return '必修课';
			case 1: return '选修课';
			case 2: return '公选课';
		}
	}
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
		
			function courseTypeToNum(course_type)
			{
				if(course_type == '必修课') return 0;
				else if(course_type == '选修课') return 1;
				else if(course_type == '公选课') return 2;
			}
		
			$(document).ready(function() {
				$(document.body).on('input', 'input', function() {
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
				
				$(document.body).on('focus', 'input', function() {
					$('.alert').hide(500);
				});
				
				$('#courseTypeMenu').children().click(function() {
					$('#courseTypeText').html($(this).find('a').text() + '<span class="caret"></span>');
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
				
				$(document.body).on('click', '.delete-detail', function() {
					$(this).parent().parent().parent().remove();
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
				
				$('#newDetail').click(function() {
					$(this).parent().parent().before('<div class="detail panel panel-primary"><div class="panel-heading"><h3 class="panel-title">详细信息</h3></div><div class="panel-body"><p><span class="text-label"><strong>星期：</strong></span><input type="number" class="day-text" class="basic-input" autocomplete="off"></p><p><span class="text-label"><strong>开始课时：</strong></span><input type="number" class="start-hour-text" class="basic-input" autocomplete="off"></p><p><span class="text-label"><strong>持续课时：</strong></span><input type="number" class="hour-text" class="basic-input" autocomplete="off"></p><p><span class="text-label"><strong>教学楼：</strong></span><input type="text" class="building-text" class="basic-input" autocomplete="off"></p><p><span class="text-label"><strong>教室：</strong></span><input type="text" class="room-text" class="basic-input" autocomplete="off"></p><div style="margin-left:auto; margin-right:auto; width:50px"><button type="button" class="delete-detail btn btn-sm btn-danger">删除</button></div></div></div>');
				});
			
				$('#save').click(function() {
					$('.alert').hide(500);
					var details = [];
					$('.detail').each(function() {
						var detail = {
							day: $(this).find('.day-text').val(),
							startHour: $(this).find('.start-hour-text').val(),
							hour: $(this).find('.hour-text').val(),
							building: $(this).find('.building-text').val(),
							room: $(this).find('.room-text').val()
						};
						details.push(detail);
					});
					var parameter = {
						id: <?php echo $course_id; ?>,
						name: $('#nameText').val(),
						teacher_id: $('#teacherIdText').val(),
						type: courseTypeToNum($('#courseTypeText').text()),
						credit: $('#creditText').val(),
						hour: $('#hourText').val(),
						start_week: $('#startWeekText').val(),
						end_week: $('#endWeekText').val(),
						price: $('#priceText').val(),
						details: JSON.stringify(details)
					};
					var $this = $(this);
					$.post('set_course_inf.php', parameter, function() {
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
    
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">基本信息</h3>
			</div>
			<div class="panel-body">
				<p><span class="text-label"><strong>课程名：</strong></span><input type="text" id="nameText" class="basic-input" autocomplete="off" value="<?php echo $course->name; ?>"></p>
				<p><span class="text-label"><strong>id：</strong></span><?php echo $course->id; ?><span class="label label-info">不可更改</span></p>
				<p><span class="text-label"><strong>任课教师id：</strong></span><input type="number" id="teacherIdText" class="basic-input" autocomplete="off" value="<?php echo $course->teacherId; ?>"></p>
				<p>
					<div><span class="text-label"><strong>类型：</strong></span>
						<div class="btn-group">
							<button type="button" id="courseTypeText" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo numToCourseType($course->type); ?><span class="caret"></span></button>
							<ul id="courseTypeMenu" class="dropdown-menu">
								<li><a>必修课</a></li>
								<li><a>选修课</a></li>
								<li><a>公选课</a></li>
							</ul>
						</div>
					</div>
				</p>
				<p><span class="text-label"><strong>学分：</strong></span><input type="number" id="creditText" class="basic-input" autocomplete="off" value="<?php echo $course->credit; ?>"></p>
				<p><span class="text-label"><strong>课时数：</strong></span><input type="number" id="hourText" class="basic-input" autocomplete="off" value="<?php echo $course->hour; ?>"></p>
				<p><span class="text-label"><strong>开始周：</strong></span><input type="number" id="startWeekText" class="basic-input" autocomplete="off" value="<?php echo $course->startWeek; ?>"></p>
				<p><span class="text-label"><strong>结束周：</strong></span><input type="number" id="endWeekText" class="basic-input" autocomplete="off" value="<?php echo $course->endWeek; ?>"></p>
				<p><span class="text-label"><strong>价格：</strong></span><input type="number" id="priceText" class="basic-input" autocomplete="off" value="<?php echo $course->price; ?>"></p>
			</div>
		</div>
			<?php
				foreach($course->courseDetail as $detail)
				{
					echo '
		<div class="detail panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">详细信息</h3>
			</div>
			<div class="panel-body">
				<p><span class="text-label"><strong>星期：</strong></span><input type="number" class="day-text" class="basic-input" autocomplete="off" value="' . $detail->day . '"></p>
				<p><span class="text-label"><strong>开始课时：</strong></span><input type="number" class="start-hour-text" class="basic-input" autocomplete="off" value="' . $detail->startHour . '"></p>
				<p><span class="text-label"><strong>持续课时：</strong></span><input type="number" class="hour-text" class="basic-input" autocomplete="off" value="' . $detail->startHour . '"></p>
				<p><span class="text-label"><strong>教学楼：</strong></span><input type="text" class="building-text" class="basic-input" autocomplete="off" value="' . $detail->building . '"></p>
				<p><span class="text-label"><strong>教室：</strong></span><input type="text" class="room-text" class="basic-input" autocomplete="off" value="' . $detail->room . '"></p>
				<div style="margin-left:auto; margin-right:auto; width:50px">
					<button type="button" class="delete-detail delete-course btn btn-sm btn-danger">删除</button>
				</div>
			</div>
		</div>';
				}
			?>
		<div style="margin-left:auto; margin-right:auto; width:100px">
			<span><button type="button" id="newDetail" class="btn btn-sm btn-success">添加</button></span>
			<span><button type="button" id="save" class="btn btn-sm btn-primary" disabled="disabled">保存</button></span>
		</div>
	</body>
</html>