<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>



<html>

	<head>

		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>绩效系统后台登录</title>
        
        <link rel="stylesheet" href="/Public/css/reset.css" media="all">
        <link rel="stylesheet" href="/Public/css/layout.css" media="all">
	</head>



	<body class="beg-login-bg">
    	

		<div class="beg-login-box">

			<header>

				<h1>登录</h1>

			</header>

			<div class="beg-login-main">

				<form class="layui-form">
                	<section class="login_box">
                        <div class="user_row">
                            <label class="txt_label">账号</label>
                            <input class="txtbox" type="text" name="userName" id="name" autocomplete="off" placeholder="输入账号名" >
                        </div>	
                        <div class="user_row">
                            <label class="txt_label">密码</label>
                            <input class="txtbox" type="password" name="password" id="pwd" autocomplete="off" placeholder="输入密码">
                        </div>
                        <div class="user_row">
                            <input type="test" name="captcha" id="captcha" autocomplete="off" placeholder="输入验证码" class="layui_input" style="width:50%;display:inline" >		
                            <span style="float:right;"><img id="code_img" src="<?php echo U('Login/verify');?>" onclick="this.src = this.src+'?'+Math.random()"/></span>   
                        </div>
                    </section>
                    <div class="button_row">
                        <input class="signIn_btn login" type="button"  onclick="return false;" value="确认登录"/>
                    </div>

				</form>

			</div>

		</div>

		<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>

		<script>

			layui.use(['layer'], function() {

				var layer = layui.layer,

					$ = layui.jquery



					$('.login').click(function(){

						var name = $('#name').val();

						var pwd  = $('#pwd').val();

						var captcha = $('#captcha').val();

						if(name.length < 1){

							

							layer.tips('请输入用户名', '#name');return;

						}

						

						if(pwd.length < 1){

							layer.tips('请输入密码', '#pwd');return;

						}

						if(captcha.length < 1){

							layer.tips('请输入验证码', '#captcha');return;

						}

						var url = "<?php echo U('Login/doLogin');?>";

						$.post(url,{name:name,pwd:pwd,captcha:captcha},function(data){

							if(data.status){

								$('#code_img').click();

								layer.msg(data.msg);	

							}else{

								window.location.href="<?php echo U('Index/index');?>";

							}

						})

					})

			});

			

			

		</script>

	</body>



</html>