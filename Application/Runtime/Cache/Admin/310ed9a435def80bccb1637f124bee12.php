<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>

<html>



<head>

	<meta charset="UTF-8">

	<title>打印分账单</title>

	<link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />

	<link rel="stylesheet" href="/Public/css/global.css" media="all">

	<link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">

</head>



<body>
<div class="project_con">
    <fieldset class="layui-elem-field">
        <legend><?php echo ($project_info['company_name']); ?></legend>
        <div class="mar_row">
        	<h1 class="projcet_title">项目成本利润核算明细表</h1>
            <div class="search_result">
                <span class="mar_r_10">项目编号：<?php echo (date("Ym-d",$project_info['create_time'])); ?></span>
                <span class="mar_r_10">填表日期：<?php echo (date("Y-m-d",$project_info['create_time'])); ?></span>
            </div>
            <table class="layui-table" cellpadding="0" cellspacing="0">
                <tr>
                    <td>单位名称</td>
                    <td colspan="2"><?php echo ($project_info['company_name']); ?></td>
                    <td>项目负责人</td>
                    <td>王小明</td>
                </tr>
                <tr>
                	<td>项目内容</td>
                	<td colspan="2"><?php echo ($project_info['project_name']); ?></td>
                	<td>合同金额（元）</td>
                	<td><?php echo ($project_info['money']); ?></td>
                </tr>
                <tr>
                	<td rowspan="5">成本费用（元）</td>
                	<td colspan="2">税费</td>
                	<td colspan="2"><?php echo ($project_info['taxation']); ?></td>
                </tr>
                <?php if(is_array($project_info["cost_project_member"])): foreach($project_info["cost_project_member"] as $k=>$vo): ?><tr>
                	<td colspan="2"><?php echo ($k); ?></td>
                	<td colspan="2"><?php echo ($vo); ?></td>
                </tr><?php endforeach; endif; ?>
                <tr>
                	<td colspan="2">费用合计（元）</td>
                	<td colspan="2"><?php echo ($project_info['operate_cost']); ?></td>
                </tr>
                <tr>
                	<td colspan="2">项目人工成本合计（元）</td>
                	<td colspan="2"><?php echo ($project_info['person_cost']); ?></td>
                </tr>
                <tr class="head_row">
                	<td>项目利润</td>
                	<td>利润率</td>
                	<td>业务人员提成（王小明）</td>
                	<td>净利润率</td>
                	<td>分账金额</td>
                </tr>
                <tr>
                	<td><?php echo ($project_info['sum_profit']); ?></td>
                	<td><?php echo ($project_info['profit_margin']); ?></td>
                	<td>111</td>
                	<td>222</td>
                	<td>100.00</td>
                </tr>
            </table>
        </div>
    </fieldset>
</div>

<div class="fz_con" style="display:block;">
    <fieldset class="layui-elem-field">
    
        <legend>分账</legend>
        <div class="mar_row">
            <div class="search_result">
                <span class="mar_r_10">该项目目前总利润：<?php echo ($project_info['sum_profit']); ?></span>
                <span class="mar_r_10">预计盈利率：<?php echo ($project_info['profit_margin']); ?></span>
            </div>
    
            <table class="layui-table" cellpadding="0" cellspacing="0">
    
                <tr class="first_row">
                    <td>项目人员组成</td>
                    <td>姓名</td>
                    <td>分账金额</td>
                    <td>分配率</td>
                    <td>分配金额</td>
                </tr>
                <?php if(is_array($project_info['project_member'])): foreach($project_info['project_member'] as $key=>$v): ?><tr>
                        <td><?php echo ($v['auth_type_name']); ?></td>
                        <td><?php echo ($v['user_name']); ?></td>
                        <td>8373</td>
                        <td><?php echo ($v['member_ratio']); ?>%</td>
                        <td><?php echo ($v['member_ratio_money']); ?></td>
                    </tr><?php endforeach; endif; ?>
                <tr>
                	<td colspan="3">合计</td>
                	<td>100%</td>
                	<td>1600.00</td>
                </tr>
    
            </table>
        </div>
    </fieldset>
</div>

</body>



</html>