<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>



	<head>

		<meta charset="UTF-8">

		<title></title>

		<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />

		<link rel="stylesheet" href="/Public/css/main.css" />
        <script type="text/javascript" src="/Public/plugins/jquery-1.11.3.min.js"></script>
		<script>
            $(function(){
                $('.member_ul li').click(function () {
                    $(".member_info").css("display","none");
                    $('.member_ul li').children('a').removeClass("current");
                    //display current 
                    $(".member_info").eq($(".member_ul li").index($(this))).css("display","block");
                    $(this).children().addClass("current");
                        });	
                });
            
        </script>
	</head>



	<body>
    	<ul class="member_ul">
        	<li><a class="current" href="javascript:void();">个人分账</a></li>
        	<li><a href="javascript:void();">项目统计</a></li>
        	<li><a href="javascript:void();">公司统计</a></li>
        	<li><a href="javascript:void();">总工时统计表</a></li>
        </ul>
        <div class="member_info" style="display:block;">
        	<blockquote class="layui-elem-quote" style="overflow:hidden;">
				<div class="layui-inline fl">

					<form action="" method="get" id="person_split">

                        <div class="layui-input-inline">
                            <span>年份:</span>
                            <div class="layui-input-inline">
                                <input name="finish_time" id="date" lay-verify="date"   placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
                            </div>

                            <div class="layui-input-inline">

                                <select class="select_box" name="cid" id="cid">

                                    <option value="" selected="selected">请选择公司</option>

                                    <?php if(is_array($company_list)): foreach($company_list as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>" ><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>

                                </select>

                                <select class="select_box" name="gid" id="gid">
                                    <option value="" selected="selected">请选择小组</option>

                                </select>
                                <input type="hidden" name="fgid" id="fgid" value="<?php echo ($gid); ?>">
                            </div>
                            <div class="layui-input-inline">

                                <select class="select_box" name="pid" >

                                    <option value="" selected="selected">项目</option>

                                    <?php if(is_array($project_list)): foreach($project_list as $key=>$p): ?><option  value="<?php echo ($p["id"]); ?>" <?php if($cid == $v['id']): ?>selected<?php endif; ?>><?php echo ($p["project_name"]); ?></option><?php endforeach; endif; ?>

                                </select>


                            </div>
                        </div>
						<input type="submit" class="layui-btn layui-btn-small search_btn" value="搜索"></input>

					</form>

				</div>

                <div class="fr">

                    <button class="layui-btn layui-btn-small person_split" style="margin:0;">导出</button>
				</div>

			</blockquote>
            <table class="layui-table">
            	<thead>
                  <tr>
                      <th>参与人</th>

                      <th>所属公司</th>

                      <th>所属小组</th>

                      <th>工时</th>

                      <th>人工成本</th>

                      <th>分账</th>
                  </tr>
                </thead>
                <?php if(is_array($person_split)): foreach($person_split as $key=>$ps): ?><tr>
                      <td><?php echo ($ps["user_name"]); ?></td>
                      <td><?php echo ($ps["name"]); ?></td>
                      <td><?php echo ($ps["group_name"]); ?></td>


                      <td><?php echo ($ps["split_workhours"]); ?></td>
                      <td><?php echo ($ps["person_cost"]); ?></td>
                      <td><?php echo ($ps["split_money"]); ?></td>
                  </tr><?php endforeach; endif; ?>


            </table>
        </div><!--/个人分账-->


        <div class="member_info">
       		<blockquote class="layui-elem-quote" style="overflow:hidden;">
				<div class="layui-inline fl">

					<form action="" method="get" id="project_info">

                        <div class="layui-input-inline">
                            <span>年份:</span>
                            <div class="layui-input-inline">
                                <input name="create_time"  lay-verify="date"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
                            </div>

                            <div class="layui-input-inline">
                                <input name="create_time" id="date" lay-verify="date"  value="<?php echo ($create_time); ?>"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
                            </div>
                            <select class="select_box" name="cid" id="cid">
                                <option value="" selected="selected">请选择公司</option>
                                <?php if(is_array($company_list)): foreach($company_list as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>" <?php if($cid == $v['id']): ?>selected<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                            </select>
                            <select class="select_box" name="finance_status">
                                <option value="" selected="selected">请选择财务审核状态</option>
                                <option  value="0" >未审核</option>
                                <option  value="1" >审核通过</option>
                                <option  value="3" >审核未通过</option>
                                <option  value="2" >完工</option>
                            </select>
                            <select class="select_box" name="status">
                                <option value="" selected="selected">请选择项目状态</option>
                                <option  value="0" >进行中</option>
                                <option  value="1" >已完工</option>
                            </select>

                        </div>
						<input type="submit" class="layui-btn layui-btn-small search_btn" value="筛选"></input>

					</form>

				</div>

                <div class="fr">

                    <button class="layui-btn layui-btn-small project_info" style="margin:0;">导出</button>
				</div>

			</blockquote>
            <div class="search_result">
            	<span class="mar_r_10">项目状态：已完工</span>  <span class="mar_r_10">总工时：3.5</span> <span class="mar_r_10">总成本：2000.00</span> 
                <span class="mar_r_10">总利润：200.00</span>  <span class="mar_r_10">总绩效：200.00</span> <span class="mar_r_10">盈利率：200%</span>
            </div>
            <table class="layui-table">
            	<thead>
                  <tr>
                      <th style="width:30px;">序号</th>
                      <th>项目名称</th>
                      <th>合同额</th>
                      <th>创建时间</th>
                      <th>财务审核</th>
                      <th>项目状体</th>
                      <th>工时合计</th>
                      <th>总成本合计</th>
                      <th>绩效合计</th>
                      <th>盈利率</th>

                  </tr>
                </thead>
                <?php if(is_array($project_info)): foreach($project_info as $key=>$pv): ?><tr>
                      <td><?php echo ($pv["id"]); ?></td>
                      <td><?php echo ($pv["project_name"]); ?></td>
                      <td><?php echo ($pv["money"]); ?></td>
                      <td><?php echo ($pv["create_time"]); ?></td>
                      <td><?php echo ($pv["finance_status_name"]); ?></td>
                      <td><?php echo ($pv["status_name"]); ?></td>
                      <td><?php echo ($pv["sum_work_hours"]); ?></td>
                      <td><?php echo ($pv["sum_cost"]); ?></td>
                      <td><?php echo ($pv["sum_ratio"]); ?></td>
                      <td><?php echo ($pv["profit_margin"]); ?></td>
                  </tr><?php endforeach; endif; ?>

            </table> 
        </div><!--/项目统计-->
        <div class="member_info">
        <blockquote class="layui-elem-quote" style="overflow:hidden;">
				<div class="layui-inline fl">

					<form action="" method="get" id="company_lists">

						<div class="layui-input-inline">
							<span>月份:</span>
                            <div class="layui-input-inline">
                                <input name="finish_time"  lay-verify="date"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
                            </div>


                        </div>
						<input type="submit" class="layui-btn layui-btn-small search_btn" value="筛选"></input>

					</form>

				</div>

                <div class="fr">

                    <button class="layui-btn layui-btn-small company_lists" style="margin:0;">导出</button>
				</div>

			</blockquote>
            <table class="layui-table">
            	<thead>
                  <tr>
                      <th>公司名称</th>
                      <th>合同总额</th>

                      <th>申报工时</th>

                      <th>人工成本</th>
                      <th>运营成本</th>
                      <th>绩效合计</th>
                      <th>盈利率</th>

                  </tr>
                </thead>
                <?php if(is_array($company_lists)): foreach($company_lists as $key=>$cl): ?><tr>
                      <td><?php echo ($cl["name"]); ?></td>
                      <td><?php echo ($cl["sum_money"]); ?></td>
                      <td><?php echo ($cl["person_sum_times"]); ?></td>
                      <td><?php echo ($cl["person_cost"]); ?></td>
                      <td><?php echo ($cl["operate_cost"]); ?></td>
                      <td><?php echo ($cl["sum_ratio"]); ?></td>
                      <td><?php echo ($cl["profit_margin"]); ?></td>
                  </tr><?php endforeach; endif; ?>

            </table> 
        	
        </div><!--公司统计-->
        <div class="member_info">
        <blockquote class="layui-elem-quote" style="overflow:hidden;">
				<div class="layui-inline fl">

					<form  method="get" id="work_hours">

						<div class="layui-input-inline">
							<span>年份:</span>
                            <div class="layui-input-inline">
                                <input name="create_time" id="date" lay-verify="date"    placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
                            </div>

                            <div class="layui-input-inline">

                                <select class="select_box" name="cid" id="cid">

                                    <option value="" selected="selected">请选择公司</option>

                                    <?php if(is_array($company_list)): foreach($company_list as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>

                                </select>

                                <select class="select_box" name="gid" id="gid">
                                    <option value="" selected="selected">请选择小组</option>

                                </select>
                                <input type="hidden" name="fgid" id="fgid" value="<?php echo ($gid); ?>">
                            </div>

						</div>
						<input type="submit" class="layui-btn layui-btn-small search_btn" value="搜索"></input>

					</form>

				</div>

                <div class="fr">

                    <button  class="layui-btn layui-btn-small work_hours" style="margin:0;">导出</button>
				</div>

			</blockquote>
            <table class="layui-table">
            	<thead>
                  <tr>
                      <th>员工</th>
                      <th>1月</th>
                      <th>2月</th>
                      <th>3月</th>
                      <th>4月</th>
                      <th>5月</th>
                      <th>6月</th>
                      <th>7月</th>
                      <th>8月</th>
                      <th>9月</th>
                      <th>10月</th>
                      <th>11月</th>
                      <th>12月</th>
                  </tr>
                </thead>
                <?php if(is_array($work_member5)): foreach($work_member5 as $key=>$v): ?><tr>
                      <td><?php echo ($v["user_name"]); ?></td>
                      <td><?php echo ($v["1"]); ?></td>
                      <td><?php echo ($v["2"]); ?></td>
                      <td><?php echo ($v["3"]); ?></td>
                      <td><?php echo ($v["4"]); ?></td>
                      <td><?php echo ($v["5"]); ?></td>
                      <td><?php echo ($v["6"]); ?></td>
                      <td><?php echo ($v["7"]); ?></td>
                      <td><?php echo ($v["8"]); ?></td>
                      <td><?php echo ($v["9"]); ?></td>
                      <td><?php echo ($v["10"]); ?></td>
                      <td><?php echo ($v["11"]); ?></td>
                      <td><?php echo ($v["12"]); ?></td>
                  </tr><?php endforeach; endif; ?>

            </table> 
        	
        </div><!--总工时统计表-->
        
        <div class="proportion">
        	<h2 class="p_title">工时占比</h2>
            <div class="rollBox">
                <div class="LeftBotton" onmousedown="ISL_GoUp()" onmouseup="ISL_StopUp()"
                onmouseout="ISL_StopUp()">
                </div>
                <div class="Cont" id="ISL_Cont">
                    <div class="ScrCont">
                        <div id="List1">
                            <!-- 列表 begin -->
                            <div class="pic">1月份工时占比</div>
                            <div class="pic">2月份工时占比</div>
                            <div class="pic">3月份工时占比</div>
                            <div class="pic">4月份工时占比</div>
                            <div class="pic">5月份工时占比</div>
                            <div class="pic">6月份工时占比</div>
                            <div class="pic">7月份工时占比</div>
                            <div class="pic">8月份工时占比</div>
                            <!-- 列表 end -->
                        </div>
                        <div id="lee" style="width: 600px;height:400px;border: 1px">

                        </div>
                    </div>
                </div>
                <div class="RightBotton" onmousedown="ISL_GoDown()" onmouseup="ISL_StopDown()"
     onmouseout="ISL_StopDown()">
                </div>
            </div>
        </div>
        
        <script type="text/javascript" src="/Public/plugins/popul.js"></script>
        </div><!--工时占比-->
        <script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
        <script type="text/javascript" src="/Public/plugins/my.js"></script>
        <script type="text/javascript" src="/Public/plugins/echarts-all.js"></script>
        <script>


            $(".person_split").click(function(){

                window.location.href="/Admin/Index/main?type=1&export=1&"+ $("#person_split").serialize();

            });


            $(".project_info").click(function(){
                window.location.href="/Admin/Index/main?type=2&export=1&"+ $("#project_info").serialize();
            });
            $(".company_lists").click(function(){
                window.location.href="/Admin/Index/main?type=3&export=1&"+ $("#company_lists").serialize();
            });
            $(".work_hours").click(function(){
                window.location.href="/Admin/Index/main?type=4&export=1&"+ $("#work_hours").serialize();
            });



        </script>

        <script>

            layui.use(['laydate'], function() {
                laydate = layui.laydate;

            });
        </script>

        <script type="text/javascript">
            // 基于准备好的dom，初始化echarts实例
            var myChart = echarts.init(document.getElementById('lee'));

            // 指定图表的配置项和数据
            option = {

                tooltip : {
                    trigger: 'axis'
                },

                toolbox: {
                    show : true,
                    feature : {
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : <?php echo ($hours_ratio['project_name']); ?>,
                    }
                ],
                yAxis : [
                    {
                        type : 'value'

                    }
                ],
                series : [
                    {
                        name:'工时占比',
                        type:'bar',
                        data:<?php echo ($hours_ratio['hours_ratio']); ?>,

                    },
                    {
                        name:'利润率',
                        type:'bar',
                        data:<?php echo ($hours_ratio['profit_margin']); ?>,

                    }
                ]
            };


            // 使用刚指定的配置项和数据显示图表。
            myChart.setOption(option);
        </script>
	</body>



</html>