<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
    <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/Public/css/global.css" media="all">
    <link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
</head>

<body>
<div class="admin-main">
    <form class="layui-form">

        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input value="<?php echo ($user_info['user_name']); ?>" disabled="" class="layui-input layui-disabled" type="text">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">旧密码</label>
            <div class="layui-input-block">
                <input value="" name="oldPwd" placeholder="请输入旧密码" lay-verify="required|oldPwd" class="layui-input pwd layui-form-danger" type="password">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">新密码</label>
            <div class="layui-input-block">
                <input value="" name="newPwd"  placeholder="请输入新密码" lay-verify="required|newPwd" id="oldPwd" class="layui-input pwd" type="password">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认密码</label>
            <div class="layui-input-block">
                <input value=""  name="confirmPwd" placeholder="请确认密码" lay-verify="required|confirmPwd" class="layui-input pwd" type="password">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="changePwd">立即修改</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
<script>
    layui.use(['laypage','layer','form'], function() {
        var form = layui.form()
            $ = layui.jquery
        //监听提交
        form.on('submit(changePwd)', function(data){

            var userInfo = data.field;

            var url = "<?php echo U('Person/changePwd');?>";
            $.post(url,userInfo,function(data){
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
        })

    });
</script>
</body>

</html>