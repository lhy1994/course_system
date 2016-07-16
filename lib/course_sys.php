<?php
	function numToDay($num)
	{
		switch($num)
		{
			case 0: return '日';
			case 1: return '一';
			case 2: return '二';
			case 3: return '三';
			case 4: return '四';
			case 5: return '五';
			case 6: return '六';
		}
	}
	function numToCourseLabel($num)
	{
		switch($num)
		{
			case 0: return '<span class="label label-danger">必修课</span>';
			case 1: return '<span class="label label-warning">选修课</span>';
			case 2: return '<span class="label label-success">公选课</span>';
		}
	}
?>