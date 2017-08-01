<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>

	<head>
		<meta charset="utf-8">
		<title>工时</title>
		<meta name="renderer" content="webkit">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">

	</head>

	<body>
	<?php if(is_array($work_info)): foreach($work_info as $key=>$vo): ?><a href="<?php echo U('Index/addWork',array('id'=>$vo['id']));?>"><?php echo ($vo["project_name"]); ?></a>
		所用工时:<?php echo ($vo["work_hours"]); ?>
		完成工作:<?php echo ($vo["work_content"]); ?>
		<?php echo (date("Y-m-d",$vo["created_time"])); endforeach; endif; ?>
	</body>

</html>