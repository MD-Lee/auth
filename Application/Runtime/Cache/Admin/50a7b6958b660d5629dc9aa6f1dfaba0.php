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
				<button  class="layui-btn layui-btn-small add">
					<i class="layui-icon">&#xe608;</i> 添加用户
				</button>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>员工列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>序号</th>
					      <th>姓名</th>
					      <th>性别</th>
					      <th>入职时间</th>
					      <th>工资</th>
					      <th>所属公司</th>
					      <th>所属小组</th>
					      <th>权限</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  <?php if(is_array($employee_info)): foreach($employee_info as $k=>$vo): ?><tr>
					      <td><?php echo ($vo["id"]); ?></td>
					      <td><?php echo ($vo["name"]); ?></td>
					      <td><?php echo ($vo["sex"]); ?></td>
					      <td><?php echo (date("Y-m-d H:i:s",$vo["created_at"])); ?></td>
							<td><?php echo ($vo["wages"]); ?></td>
							<td><?php echo ($vo["company"]); ?></td>
							<td><?php echo ($vo["company_group"]); ?></td>
							<td><?php echo ($vo["auth_type_name"]); ?></td>
					      <td>
							<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>
							<a  data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del"><i class="layui-icon">&#xe640;</i>删除</a>

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
		<script>
			layui.use(['laypage','layer','form'], function() {
				var laypage = layui.laypage,
					$ = layui.jquery
					//请求表单
				 $('.add').click(function(){
					var url = "<?php echo U('Employee/addEmployee');?>";
					$.get(url,function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'添加用户',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				//编辑用户
				$('.edit').click(function(){
					var employee_id = $(this).attr('data');
					var url = "<?php echo U('Employee/editEmployee');?>";
					$.get(url,{employee_id:employee_id},function(data){
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
				

				
				//删除
				$('.del').click(function(){
					var employee_id = $(this).attr('data');
					var url = "<?php echo U('Employee/deleteEmployee');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{employee_id:employee_id},function(data){
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
				})
				
			});
		</script>
	</body>

</html>