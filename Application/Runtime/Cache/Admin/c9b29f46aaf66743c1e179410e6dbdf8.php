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
					<i class="layui-icon">&#xe608;</i> 添加项目
				</button>
			</blockquote>
			<fieldset class="layui-elem-field">
				<legend>项目列表</legend>
				<div class="layui-field-box">
				<table class="layui-table">
					  <thead>
					    <tr>
					      <th>序号</th>
					      <th>项目名称</th>
					      <th>财务审核</th>
					      <th>项目状态</th>
					      <th>创建时间</th>
					      <th>合同金额</th>
					      <th>工时合计</th>
					      <th>人工合计</th>
					      <th>绩效合计</th>
					      <th>盈利率</th>
					      <th>操作</th>
					    </tr> 
					  </thead>
					  <tbody>
					  <?php if(is_array($project_info)): foreach($project_info as $k=>$vo): ?><tr>
					      <td><?php echo ($vo["id"]); ?></td>
					      <td><?php echo ($vo["project_name"]); ?></td>
					      <td><?php echo ($vo["finance_status"]); ?></td>
					      <td><?php echo ($vo["status"]); ?></td>
					      <td><?php echo (date("Y-m-d",$vo["create_time"])); ?></td>
					      <td><?php echo ($vo["money"]); ?></td>
					      <td><?php echo ($vo["sum_time"]); ?></td>
					      <td><?php echo ($vo["sum_per"]); ?></td>
					      <td><?php echo ($vo["sum_achievement"]); ?></td>
					      <td><?php echo ($vo["profit"]); ?></td>
					      <td>

							<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini  examine"><i class="layui-icon">&#xe608;</i>审核</a>
							<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini layui-btn-normal edit"><i class="layui-icon">&#xe642;</i>编辑</a>
							<a  data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-danger layui-btn-mini del"><i class="layui-icon">&#xe640;</i>删除</a>

					      	<a data="<?php echo ($vo["id"]); ?>" class="layui-btn layui-btn-mini member"><i class="layui-icon">&#xe608;</i>成员</a>
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
			layui.use(['element','laypage','layer','form'], function() {
                var element = layui.element();
				var laypage = layui.laypage;
					$ = layui.jquery;
                    layer = layui.layer;
					//请求表单
                //iframe自适应
                $(window).on('resize', function() {
                    var $content = $('.admin-nav-card .layui-tab-content');
                    $content.height($(this).height() - 147);
                    $content.find('iframe').each(function() {
                        $(this).height($content.height());
                    });
                }).resize();

                //添加tab
                var $tabs = $('#admin-tab');
                var $container = $('#admin-tab-container');
				$('.add').click(function () {
                    var $this = $(this);
                    var url = "<?php echo U('Project/addProject');?>";
                    var iframe = '<iframe src="' + url + '"></iframe>';
                    var aHtml = $this.html();

                    var count = 0;
                    var tabIndex;
                    $tabs.find('li').each(function(i, e) {
                        var $cite = $(this).children('cite');
                        alert("3");
                        if($cite.text() === $this.find('cite').text()) {
                            count++;
                            tabIndex = i;
                        };
                    });

                    //tab不存在
                    if(count === 0) {
                        //添加删除样式
                        aHtml += '<i class="layui-icon layui-unselect layui-tab-close">&#x1006;</i>';
                        //添加tab
                        element.tabAdd('admin-tab', {
                            title: aHtml,
                            content: iframe
                        });
                        //iframe 自适应
                        var $content = $('.admin-nav-card .layui-tab-content');

                        $content.find('iframe').each(function() {
                            $(this).height($content.height());
                        });
                        //绑定关闭事件
                        $tabs = $('#admin-tab');
                        var $li = $tabs.find('li');
                        alert($li.length);
                        $li.eq($li.length - 1).children('i.layui-tab-close').on('click', function() {

                            element.tabDelete('admin-tab', $(this).parent('li').index()).init();
                        });
                        //获取焦点
                        element.tabChange('admin-tab', $li.length - 1);

                    } else {
                        //切换tab
                        element.tabChange('admin-tab', tabIndex);
                    }
                });
				/* $('.add').click(function(){
					var url = "<?php echo U('Project/addProject');?>";
					$.get(url,function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'添加项目',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });*/
				//添加项目成员

                $('.member').click(function(){
                    var project_id = $(this).attr('data');
                    var url = "<?php echo U('Project/addProjectMember');?>";
                    $.get(url,{project_id:project_id},function(data){
                        if(data.status == 'error'){
                            layer.msg(data.msg,{icon: 5});
                            return;
                        }
                        layer.open({
                            title:'添加项目成员',
                            type: 1,
                            skin: 'layui-layer-rim', //加上边框
                            area: ['500px'], //宽高
                            content: data,
                        });
                    })
                });
				//编辑项目
				$('.edit').click(function(){
					var project_id = $(this).attr('data');
					var url = "<?php echo U('Project/editProject');?>";
					$.get(url,{project_id:project_id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						layer.open({
							  title:'编辑项目',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px'], //宽高
							  content: data,
						});
					})
				 });
				
				//审核
				$('.examine').click(function(){
                    var project_id = $(this).attr('data');
                    var url = "<?php echo U('Project/examineProject');?>";
                    $.get(url,{project_id:project_id},function(data){
						if(data.status == 'error'){
							layer.msg(data.msg,{icon: 5});
							return;
						}
						
						layer.open({
							  title:'审核',
							  type: 1,
							  skin: 'layui-layer-rim', //加上边框
							  area: ['500px','300px'], //宽高
							  content: data,
						});
					})
				 });
				
				//删除
				$('.del').click(function(){
					var project_id = $(this).attr('data');
					var url = "<?php echo U('Project/deleteProject');?>";
					layer.confirm('确定删除吗?', {
						  icon: 3,
						  skin: 'layer-ext-moon',
						  btn: ['确认','取消'] //按钮
						}, function(){
							$.post(url,{project_id:project_id},function(data){
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