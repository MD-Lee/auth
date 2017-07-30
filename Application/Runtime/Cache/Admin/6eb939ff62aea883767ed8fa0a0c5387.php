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
					<i class="layui-icon">&#xe608;</i> 添加公司
				</button>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>公司列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>序号</th>
					      <th>公司名称</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  <?php if(is_array($company_info)): foreach($company_info as $k=>$vo): ?><tr>
					      <td><?php echo ($vo['id']); ?></td>
					      <td><?php echo ($vo["name"]); ?>
							  <?php if(is_array($vo["group_list"])): foreach($vo["group_list"] as $key=>$t): echo ($t["group_name"]); ?>
							<a  data="<?php echo ($t["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini groupdel"><i class="layui-icon">&#xe640;</i>删除</a>
							<a data="<?php echo ($t["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal groupedit"><i class="layui-icon">&#xe642;</i>编辑</a><?php endforeach; endif; ?>

						  </td>

					      <td>
							<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>
							<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini group"><i class="layui-icon">&#xe608;</i>添加小组</a>
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
					var url = "<?php echo U('Company/addCompany');?>";
					$.get(url,function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'添加公司',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				//编辑用户
				$('.edit').click(function(){
					var company_id = $(this).attr('data');
					var url = "<?php echo U('Company/editCompany');?>";
					$.get(url,{company_id:company_id},function(data){
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
                //编辑公司小组
                $('.groupedit').click(function(){
                    var group_id = $(this).attr('data');
                    var url = "<?php echo U('Company/editCompanyGroup');?>";
                    $.get(url,{group_id:group_id},function(data){
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
				//添加小组
				$('.group').click(function(){
					var company_id = $(this).attr('data');
					var url = "<?php echo U('Company/addGroup');?>";
					$.get(url,{company_id:company_id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'添加小组',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px','500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//删除
				$('.del').click(function(){
					var company_id = $(this).attr('data');
					var url = "<?php echo U('Company/deleteCompany');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{company_id:company_id},function(data){
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
                //删除
                $('.groupdel').click(function(){
                    var group_id = $(this).attr('data');
                    var url = "<?php echo U('Company/deleteCompanyGroup');?>";
                    layer.confirm('确定删除吗?', {
                        icon: 3,
                        skin: 'layer-ext-moon',
                        btn: ['确认','取消'] //按钮
                    }, function(){
                        $.post(url,{group_id:group_id},function(data){
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