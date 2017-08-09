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
        <link rel="stylesheet" href="/Public/css/reset.css" media="all">
        <link rel="stylesheet" href="/Public/css/layout.css" media="all">
        <link rel="stylesheet" href="/Public/css/dropload.css" media="all">
	</head>



<body>
<article class="khfxWarp">
    <ul class="wk_time_list khfxPane">
    <?php if(is_array($work_info)): foreach($work_info as $key=>$vo): ?><li class="animated fadeInRight">
        	<div class="bl_sign">补录</div>
            <h2 class="work_title"><a href="<?php echo U('Index/detailWork',array('id'=>$vo['id']));?>"><?php echo ($vo["project_name"]); ?>奥迪车展项目场地策划</a></h2>
    
            <div class="work_item"><span class="work_txt">所用工时:</span><?php echo ($vo["work_hours"]); ?></div>
    
            <div class="work_item"><span class="work_txt">完成工作:</span><?php echo ($vo["work_content"]); ?></div>
    
            <div class="work_time"><?php echo (date("Y-m-d",$vo["created_time"])); ?></div>
       </li><?php endforeach; endif; ?>
    </ul>
</article> 

<footer class="foot_con">
    <div style="height:50px;"></div>
    <div class="footer">
        <a class="bl_btn" href="<?php echo U('Index/makeupWork');?>">补录工时</a>
        <a class="addgs_btn" href="<?php echo U('Index/addWork');?>">添加工时</a>
    </div>
</footer>
    

<script src="/Public/plugins/jquery-2.2.3.min.js"></script>
<script src="/Public/plugins/dropload.js"></script>
<script src="/Public/plugins/khData.js"></script>
</body>

</html>