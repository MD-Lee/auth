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

<form  method="post" action="<?php echo U('Index/makeupWork');?>">
<div id="lee" class="add_box">
	<div class="layui_row">
    	<label class="layui-form-label">项目名称：</label>
         <select class="layui_select" name="pid" >
            <option value="">选择项目</option>
            <?php if(is_array($project_list)): foreach($project_list as $key=>$v): ?><option  value="<?php echo ($v["pid"]); ?>"><?php echo ($v["project_name"]); ?></option><?php endforeach; endif; ?>
        </select>
    </div>
    <div class="layui_row">
    	<label class="layui-form-label">补录日期：</label>
        <input name="additional_recording_time" id="date" lay-verify="date"   placeholder="yyyy-mm-dd" autocomplete="off" class="layui_input" onclick="layui.laydate({elem: this})" type="text">
    </div>
    <div class="layui_row">
    	<label class="layui-form-label">补录原因：</label>
		<input class="layui_input" type="text" name="additional_recording">
    </div>
    <div class="layui_row">
    	<label class="layui-form-label">所用工时：</label>
		<input class="layui_input"type="text" name="work_hours">小时
    </div>
    <div class="layui_row">
    	<label class="layui-form-label">完成工作：</label><br/>
		<div class="mar_lr"><textarea class="layui_area" name="work_content"></textarea></div>
    </div>
</div>


 <div class="layui-form-item">
 	<input type="submit" value="立即提交"class="layui-btn2" >
 </div>


</form>



<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>

<script>

    layui.use('laydate', function(){



        var laydate = layui.laydate;

            $ = layui.jquery



    });

</script>

</body>

</html>