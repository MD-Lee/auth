<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>系统设置</title>
	<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
	<link rel="stylesheet" href="/Public/css/global.css" media="all">
	<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
</head>

<body>
<div class="admin-main">
	<form class="layui-form">
		<div class="layui-form-item">
			<label class="layui-form-label">税费设置：税费＝合同额
			</label>
			<div class="layui-input-inline">
				<input type="text" name="info" value="<?php echo ($config_info); ?>" lay-verify="required" placeholder="请输入计算公式" autocomplete="off"  id="info" class="layui-input">
			</div>
		</div>

		<div class="layui-form-item">
			<div class="layui-input-block">
				<button class="layui-btn" lay-submit lay-filter="config">立即提交</button>
				<button type="reset" class="layui-btn layui-btn-primary">重置</button>
			</div>
		</div>
	</form>

</div>
<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>

<script>
    layui.use('form', function(){
        var form = layui.form(),
            $ = layui.jquery
        //监听提交
        form.on('submit(config)', function(data){

            var configInfo = data.field;

            var url = "<?php echo U('Config/index');?>";
            $.post(url,configInfo,function(data){
                if(data.status == 'error'){
                    layer.msg(data.msg,{icon: 5});//失败的表情
                    return;
                }else if(data.status == 'success'){
                    layer.msg(data.msg, {
                        icon: 6,//成功的表情
                        time: 2000 //2秒关闭（如果不配置，默认是3秒）
                    }, function(){
                        location.reload();
                    });
                }
            })

            return false;//阻止表单跳转
        });
    });
</script>
</body>

</html>