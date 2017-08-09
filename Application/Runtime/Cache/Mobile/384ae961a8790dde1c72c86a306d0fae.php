<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<title>工时详情</title>

		<meta name="renderer" content="webkit">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<meta name="apple-mobile-web-app-capable" content="yes">

		<meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/Public/css/reset.css" media="all">
        <link rel="stylesheet" href="/Public/css/layout.css" media="all">
	</head>



<body>

	<ul class="bl_detail">
        <?php if($work_info_detail['type'] == 1): ?><li><span class="work_txt">补录日期：</span><?php echo (date("Y-m-d",$work_info_detail["additional_recording_time"])); ?></li>
            
            <li><span class="work_txt">补录原因：</span><?php echo ($work_info_detail["additional_recording"]); ?></li><?php endif; ?>

		<li><span class="work_txt">项目名称：</span><?php echo ($work_info_detail["project_name"]); ?></li>

		<li><span class="work_txt">所用工时：</span><?php echo ($work_info_detail["work_hours"]); ?>&nbsp;小时</li>

		<li><span class="work_txt">完成工作：</span><?php echo ($work_info_detail["work_content"]); ?></li>
     </ul>
        
	
    <footer class="foot_con">
    <div style="height:50px; background:none;"></div>
    <div class="footer">
        <a class="modify_gs" href="javascript:void();">修改工时</a>
    </div>
</footer>
</body>



</html>