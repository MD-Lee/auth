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

			<blockquote class="layui-elem-quote" style="overflow:hidden;">
            	<div class="layui-inline fl">

                    <form action="<?php echo U('Project/index');?>" method="get">
    
                        <div class="layui-input-inline">
							<input name="create_time" id="date" lay-verify="date"  value="<?php echo ($create_time); ?>"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
						 </div>
                        <select class="select_box" name="cid" id="cid">
                            <option value="" selected="selected">请选择公司</option>
                            <?php if(is_array($company_list)): foreach($company_list as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>" <?php if($cid == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        <select class="select_box" name="finance_status">
                            <option value="" selected="selected">请选择财务审核状态</option>
                            <option  value="0" <?php if($finance_status == 0): ?>selected<?php endif; ?>>未审核</option>
                            <option  value="0" <?php if($finance_status == 1): ?>selected<?php endif; ?>>审核通过</option>
                            <option  value="1" <?php if($finance_status == 3): ?>selected<?php endif; ?>>审核未通过</option>
                            <option  value="2" <?php if($finance_status == 2): ?>selected<?php endif; ?>>完工</option>
                        </select>
                        <select class="select_box" name="status">
                            <option value="" selected="selected">请选择项目状态</option>
                            <option  value="0" <?php if($status == 0): ?>selected<?php endif; ?>>进行中</option>
                            <option  value="1" <?php if($status == 1): ?>selected<?php endif; ?>>已完工</option>
                        </select>
                        <input type="submit" class="layui-btn layui-btn-small search_btn"></input>
                    </form>
    
                </div>
				<div class="fr">
				<button  class="layui-btn layui-btn-small add">

					<i class="layui-icon">&#xe608;</i> 添加项目

				</button>
                </div>

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

					      <th>总成本合计</th>

					      <th>人工合计</th>

					      <th>绩效合计</th>

					      <th>总利润</th>

					      <th>盈利率</th>

					      <th>操作</th>

					    </tr> 

					  </thead>

					  <tbody>

					  <?php if(is_array($project_info)): foreach($project_info as $k=>$vo): ?><tr>

					      <td><?php echo ($vo["id"]); ?></td>

					      <td><?php echo ($vo["project_name"]); ?></td>

					      <td><?php echo ($vo["finance_status_name"]); ?></td>

					      <td><?php echo ($vo["status_name"]); ?></td>

					      <td><?php echo (date("Y-m-d",$vo["create_time"])); ?></td>

					      <td><?php echo ($vo["money"]); ?></td>

					      <td><?php echo ($vo["sum_work_hours"]); ?></td>

					      <td><?php echo ($vo["sum_cost"]); ?></td>

					      <td><?php echo ($vo["person_cost"]); ?></td>

					      <td><?php echo ($vo["sum_ratio"]); ?></td>

					      <td><?php echo ($vo["sum_profit"]); ?></td>

					      <td><?php echo ($vo["profit_margin"]); ?></td>

					      <td>



							  <?php if($vo["finance_status"] == 1): ?><!-- <a data="<?php echo ($vo["id"]); ?>"  id="lee" data-url="<?php echo U('Project/addProject');?>" class="layui-btn layui-btn-mini  examine"><i class="layui-icon">&#xe608;</i>审核</a>-->
								  <a   id="lee" href="<?php echo U('Project/examineProject',array('project_id'=>$vo['id']));?>" class="layui-btn layui-btn-mini"><i class="layui-icon">&#xe608;</i>审核</a>

							   <?php else: ?>
									<i class="layui-icon" style="color: silver">&#xe608;</i>审核<?php endif; ?>

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

			layui.use(['element','laypage','layer','form','laydate'], function() {
                laydate = layui.laydate;
                var element = layui.element();

				var laypage = layui.laypage;

					$ = layui.jquery;

                    layer = layui.layer;




					//请求表单
				$('.add').click(function(){

					var url = "<?php echo U('Project/addProject');?>";

					window.location.href=url;

				 });

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

                    var url = "/Admin/Project/addProject?project_id="+project_id;
                    window.location.href=url;

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