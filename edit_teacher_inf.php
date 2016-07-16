<?php
	session_start();
	$admin_num = $_SESSION['admin_num'];
	include('lib\\db_operate.php');
	$teacher_id = $_POST['teacher_id'];
	$teacher = getTeacherInf($teacher_id);
	
	function numToTitle($num)
	{
		switch($num)
		{
			case 0: return '助教';
			case 1: return '讲师';
			case 2: return '副教授';
			case 3: return '教授';
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
		
			function titleToNum(title) {
				if(title == '讲师') return 0;
				else if(title == '讲师') return 1;
				else if(title == '副教授') return 2;
				else if(title == '教授') return 3;
			}
		
			$(document).ready(function() {
				$('input').bind('input', function() {
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
				
				$('input').bind('focus', function() {
					$('.alert').hide(500);
				});
				
				$('#genderText').change(function() {
					$(this).attr('val', 1 - $(this).attr('val'));
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
				
				$('#titleMenu').children().click(function() {
					$('#titleText').html($(this).find('a').text() + '<span class="caret"></span>');
					$('.alert').hide(500);
					$('#save').removeAttr('disabled');
				});
			
				$('#save').click(function() {
					$('.alert').hide(500);
					var parameter = {
						id: <?php echo $teacher_id; ?>,
						name: $('#nameText').val(),
						gender: $('#genderText').attr('val'),
						birthday: $('#birthdayText').val(),
						title: titleToNum($('#titleText').text()),
						salary: $('#salaryText').val(),
						evaluate_num: $('#evaluateNumText').val(),
						score: $('#scoreText').val(),
						country: $('#countryText').val(),
						province: $('#provinceText').val(),
						city: $('#cityText').val(),
						address: $('#addressText').val(),
						post_code: $('#postCodeText').val(),
						phone: $('#phoneText').val()
					};
					var $this = $(this);
					$.post('set_teacher_inf.php', parameter, function() {
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
			<div class="panel-body" id="genePanel">
				<p><span class="text-label"><strong>姓名：</strong></span><input type="text" id="nameText" class="basic-input" autocomplete="off" value="<?php echo $teacher->name; ?>"></p>
				<p><span class="text-label"><strong>教工号：</strong></span><?php echo $teacher->id; ?><span class="label label-info">不可更改</span></p>
				<p><span class="text-label"><strong>性别：</strong></span><input type="checkbox" id="genderText" val="<?php echo $teacher->gender; ?>" <?php if($teacher->gender == 0) echo 'checked'; ?> data-toggle="toggle" data-size="small" data-on="女" data-off="男"></p>
				<p><span class="text-label"><strong>生日：</strong></span><input type="date" id="birthdayText" class="basic-input" autocomplete="off" value="<?php echo $teacher->birthday; ?>"></p>
				<p>
					<div><span class="text-label"><strong>职称：</strong></span>
						<div class="btn-group">
							<button type="button" id="titleText" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo numToTitle($teacher->title); ?><span class="caret"></span></button>
							<ul id="titleMenu" class="dropdown-menu">
								<li><a>助教</a></li>
								<li><a>讲师</a></li>
								<li><a>副教授</a></li>
								<li><a>教授</a></li>
							</ul>
						</div>
					</div>
				</p>
				<p><span class="text-label"><strong>薪水：</strong></span><input type="number" id="salaryText" class="basic-input" autocomplete="off" value="<?php echo $teacher->salary; ?>"></p>
				<p><span class="text-label"><strong>已评价：</strong></span><input type="number" id="evaluateNumText" class="basic-input" autocomplete="off" value="<?php echo $teacher->evaluateNum; ?>"></p>
				<p><span class="text-label"><strong>教评得分：</strong></span><input type="number" id="scoreText" class="basic-input" autocomplete="off" value="<?php echo $teacher->score; ?>"></p>
				
			</div>
		</div>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">联系信息</h3>
			</div>
			<div class="panel-body" id="tissuePanel">
				<p><span class="text-label"><strong>国家：</strong></span><input type="text" id="countryText" class="basic-input" autocomplete="off" value="<?php echo $teacher->country; ?>"></p>
				<p><span class="text-label"><strong>省：</strong></span><input type="text" id="provinceText" class="basic-input" autocomplete="off" value="<?php echo $teacher->province; ?>"></p>
				<p><span class="text-label"><strong>市：</strong></span><input type="text" id="cityText" class="basic-input" autocomplete="off" value="<?php echo $teacher->city; ?>"></p>
				<p><span class="text-label"><strong>详细地址：</strong></span><input type="text" id="addressText" class="basic-input" autocomplete="off" value="<?php echo $teacher->address; ?>"></p>
				<p><span class="text-label"><strong>邮编：</strong></span><input type="text" id="postCodeText" class="basic-input" autocomplete="off" value="<?php echo $teacher->postCode; ?>"></p>
				<p><span class="text-label"><strong>联系电话：</strong></span><input type="text" id="phoneText" class="basic-input" autocomplete="off" value="<?php echo $teacher->phone; ?>"></p>
				<div style="margin-left:auto; margin-right:auto; width:50px"><button type="button" id="save" class="delete-course btn btn-sm btn-primary" disabled="disabled">保存</button></div>
			</div>
		</div>

	</body>
</html>