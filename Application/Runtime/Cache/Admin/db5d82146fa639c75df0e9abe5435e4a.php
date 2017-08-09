<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>



	<head>

		<meta charset="UTF-8">

		<title>Table</title>

		<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />

		<link rel="stylesheet" href="/Public/css/global.css" media="all">

		<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">

	</head>



	<body>

		<div class="admin-main">



			<blockquote class="layui-elem-quote">



				<div class="layui-inline">

					<form action="<?php echo U('Work/index');?>" method="get">

						<div class="layui-inline">

							<input  value="<?php echo ($start_time); ?>" name="start_time" class="layui-input" placeholder="开启节日" onclick="layui.laydate({elem: this, festival: true})">

						</div>

						<div class="layui-inline">

							<input value="<?php echo ($end_time); ?>" name="end_time" class="layui-input" placeholder="只能选昨天到明天" onclick="layui.laydate({elem: this, min: laydate.now(-1), max: laydate.now(+1)})">

						</div>

					<input type="submit" class="layui-btn layui-btn-small search_btn"></input>

					</form>

				</div>

				<button  class="layui-btn layui-btn-small add">

					<i class="layui-icon">&#xe608;</i> 添加

				</button>

				<button  class="layui-btn layui-btn-small makeup">

					<i class="layui-icon">&#xe608;</i> 补录

				</button>

			</blockquote>

			<fieldset class="layui-elem-field">

				<legend>工时列表</legend>

				<div class="layui-field-box">

				<table class="layui-table">

					  <thead>

					  <tr>

						  <th>序号</th>

						  <th>项目</th>

						  <th>所用工时</th>

						  <th>完成工作</th>

						  <th>发布时间</th>

						  <th>补录日期</th>



						  <th>操作</th>

					  </tr>

					  </thead>

					  <tbody>

					  <?php if(is_array($work_info)): foreach($work_info as $key=>$vo): ?><tr>

							  <td><?php echo ($vo["id"]); ?></td>

							  <td><?php echo ($vo["project_name"]); ?></td>

							  <td><?php echo ($vo["work_hours"]); ?></td>

							  <td><?php echo ($vo["work_content"]); ?></td>

							  <td><?php echo (date("Y-m-d",$vo["created_time"])); ?></td>

							  <td><?php echo ($vo["additional_recording_time"]); ?></td>

							  <td>

<!--								  <a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>-->

								<!--  <a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal makeup"><i class="layui-icon">&#xe642;</i>补录</a>

								-->  <a  data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del"><i class="layui-icon">&#xe640;</i>删除</a>



							  </td>

						  </tr><?php endforeach; endif; ?>

					  </tbody>

				</table>

				</div>

			</fieldset>

			<div class="admin-table-page">

				<div id="page" class="page">

				<?php echo ($page); ?>

				</div>

			</div>

		</div>

		<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>

		<script type="text/javascript" src="/Public/plugins/my.js"></script>



		<script>

			layui.use(['laypage','layer','form','laydate'], function() {

                var laydate = layui.laydate;

				var laypage = layui.laypage,

					$ = layui.jquery;





					//请求表单

				 $('.add').click(function(){

					var url = "<?php echo U('Work/addWork');?>";



					$.get(url,function(data){

						if(data.status == 'error'){

							layer.msg(data.msg,{icon: 5});

							return;

						}

						layer.open({

							  title:'添加工时',

							  type: 1,

							  skin: 'layui-layer-rim', //加上边框

							  area: ['650px','350px'], //宽高

							  content: data,

						});

					})

				 });

				//编辑用户

				$('.edit').click(function(){

					var user_id = $(this).attr('data');

					var url = "<?php echo U('User/editUser');?>";

					$.get(url,{user_id:user_id},function(data){

						if(data.status == 'error'){

							layer.msg(data.msg,{icon: 5});

							return;

						}

						layer.open({

							  title:'编辑用户',

							  type: 1,

							  skin: 'layui-layer-rim', //加上边框

							  area: ['500px'], //宽高

							  content: data,

						});

					})

				 });

				

				//补录

				$('.makeup').click(function(){



					var url = "<?php echo U('Work/makeupWork');?>";

					$.get(url,function(data){

						if(data.status == 'error'){

							layer.msg(data.msg,{icon: 5});

							return;

						}

						

						layer.open({

							  title:'补录',

							  type: 1,

							  skin: 'layui-layer-rim', //加上边框

							  area: ['650px','350px'], //宽高

							  content: data,

						});

					})

				 });

				

				//删除

				$('.del').click(function(){

					var work_id = $(this).attr('data');

					var url = "<?php echo U('Work/delWork');?>";

					layer.confirm('确定删除吗?', {

						  icon: 3,

						  skin: 'layer-ext-moon',

						  btn: ['确认','取消'] //按钮

						}, function(){

							$.post(url,{work_id:work_id},function(data){

								if(data.status == 'error'){

									  layer.msg(data.msg,{icon: 5});//失败的表情

									  return;

								  }else{

									  layer.msg(data.msg, {

										  icon: 6,//成功的表情

										  time: 2000 //2秒关闭（如果不配置，默认是3秒）

										}, function(){

										   location.reload();

										}); 

								  }	

							})

					  });

				});





				

			});

		</script>



	</body>



</html>