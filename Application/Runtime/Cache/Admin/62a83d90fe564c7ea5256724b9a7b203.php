<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>添加项目</title>
    <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="/Public/css/global.css" media="all">
    <link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
    <script src="/Public/plugins/jquery.min.js"></script>
    <script>
        $(function(){
            $(".add_m_btn").click(function(){

                $(".add_member_con").show();

                $(".add_member_box").show();

            });
            $(".edit_m_btn").click(function(){

                $(".add_member_con").show();

                $(".modify_member").show();

            });
        });

    </script>

    <style>
		.layui_con {
			clear: both;
			max-height: auto;
			min-height: auto;
		}
		#myform{ background:#f2f2f2; padding:10px 0;}
        .layui-textarea{ width:300px;}
		.layui-form-item{ line-height:30px; margin-bottom:8px;}
		.layui-form-label{ width:100px; color:#777; padding:7px 15px;}
		.layui-form-item .layui-input-inline{overflow:hidden; width:320px; margin-right:0}
		.layui-input{ display:inline-block; width:150px; float:left; margin:0 6px 0 0;}
    </style>

</head>



<body>
<form id="myform" >
    <div class="layui-form-item">
        <label class="layui-form-label">所属公司：</label>

        <div class="layui-input-block">
          <?php echo ($project_info['company_name']); ?>
        </div>
    </div>
    <div class="layui-form-item">

        <label class="layui-form-label">项目名称：</label>
        <div class="layui-input-block">
          <?php echo ($project_info['project_name']); ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目合同额：</label>

        <div class="layui-input-block">
            <?php echo ($project_info['money']); ?>

        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">项目成员：</label>
        <div class="layui-input-block">
            <textarea readonly="readonly" id="textarea_content" placeholder="请输入内容" class="layui-textarea fl">

             <?php echo ($project_info['show_project_member']); ?>
            </textarea>

            <div class="edt_btns">

                <a class="add_m_btn">添加</a><br/>

                <a class="edit_m_btn" onclick="edt_member()">修改</a>

            </div>

        </div>
    </div>
    <div class="layui_con">
        <div id="lee" class="layui-form-item fl">
    
            <?php if(is_array($project_info['cost_info'])): foreach($project_info['cost_info'] as $k=>$v): ?><div class="layui-form-item">
    
                    <label class="layui-form-label">费用：</label>
    
                    <div class="layui-input-inline">
    
                        <input type="text" value="<?php echo ($k); ?>" name="money_name[]" lay-verify="required" placeholder="请输入费用名" autocomplete="off"  id="money_name[]" class="layui-input">
    
                        <input type="text" value="<?php echo ($v); ?>" name="money[]" lay-verify="required" placeholder="请输入费用额" autocomplete="off"  id="money[]" class="layui-input">
    
                    </div>
    
                </div><?php endforeach; endif; ?>
    
        </div>
		<a class="add_name fl" onclick="lee();">✚</a>
    </div>

    <div class="layui-form-item">

        <label class="layui-form-label">绩效比例设置：</label>

        <div class="layui-input-inline">

            <?php echo ($project_info['achievements_ratio']); ?>

        </div>

    </div>



    

    <input type="hidden" name="project_id" value="<?php echo ($project_info['id']); ?>" id="project_id">

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" id="sub">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<div class="add_member_con">

    <fieldset class="layui-elem-field add_member_box hide">

        <legend>添加成员</legend>

        <div class="mar_row">

            <div class="layui-inline">
                <form >
                    <div class="layui-input-inline">
                        <select class="select_box" name="cid" id="cid">
                            <option value="" selected="selected">请选择公司</option>
                            <?php if(is_array($company)): foreach($company as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>" ><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                        <select class="select_box" name="gid" id="gid">

                            <option value="" selected="selected">请选择成员</option>

                        </select>
                    </div>

                    <input type="hidden" name="fgid" id="fgid" value="">
                    <input type="button" class="layui-btn layui-btn-small search_btn" onclick="select_member()" value="搜索"/>
                </form>
            </div>
            <!--选择-->
            <div class="">
                <table class="layui-table">
                    <colgroup>
                        <col width="50">
                        <col width="150">
                        <col>
                    </colgroup>



                    <thead>



                    <tr>



                        <th style="width:10%"><input  id="selects" type="checkbox"></th>



                        <th style="width:45%">姓名</th>



                        <th style="width:45%">项目分账比例</th>



                    </tr>



                    </thead>



                    <tbody id="check_member">



                    </tbody>



                </table>



                <button  class="layui-btn layui-btn-primary add_member" >添加</button>



            </div>

        </div>

    </fieldset>

    <!--end选择-->



    <!--选中-->

    <fieldset class="layui-elem-field modify_member hide">

        <legend>修改成员</legend>

        <div class="mar_row">



            <table class="layui-table">



                <colgroup>



                    <col width="">



                    <col width="">



                    <col width="">



                    <col>



                </colgroup>



                <thead>



                <tr>



                    <th style="width:10%"><input name=""  type="checkbox"></th>



                    <th style="width:30%">已选成员</th>



                    <th style="width:30%">项目分账比例</th>



                    <th style="width:30%">操作</th>



                </tr>



                </thead>



                <tbody id="add_member">



                </tbody>



            </table>



            <button  class="layui-btn layui-btn-primary check_member">添加</button>



        </div>

</div>

</fieldset>

<!--end选中-->
<div class="fz_con" style="display: block;">
<fieldset class="layui-elem-field">

	<legend>分账</legend>
    <div class="mar_row">
    	<div class="search_result">
            <span class="mar_r_10">该项目目前总利润：<?php echo ($project_info['sum_profit']); ?></span>
            <span class="mar_r_10">预计盈利率：<?php echo ($project_info['profit_margin']); ?></span>
        </div>

        <table class="layui-table" cellpadding="0" cellspacing="0">
        
            <tr class="first_row">
                <td>员工</td>
        
                <td>累计工时</td>
        
                <td>分账比例</td>
        
                <td>预计分账金额</td>
        
            </tr>
        
            <?php if(is_array($project_info['project_member'])): foreach($project_info['project_member'] as $key=>$v): ?><tr>
        
                <td><?php echo ($v['user_name']); ?></td>
        
                <td><?php echo ($v['work_hours']); ?></td>
        
                <td><?php echo ($v['member_ratio']); ?>%</td>
        
                <td><?php echo ($v['member_ratio_money']); ?></td>
        
            </tr><?php endforeach; endif; ?>
        
        </table>
	</div>
</fieldset>
</div>

<script charset="utf-8" type="text/javascript" src="/Public/plugins/layui/layui.js"></script>



<script charset="utf-8" type="text/javascript" src="/Public/plugins/my.js"></script>



<script>

    function  lee() {

        var html ='<div class="layui-form-item"><label class="layui-form-label">费用：</label><div class="layui-input-inline">'

            +'  <input type="text" name="money_name[]" lay-verify="required" placeholder="请输入费用名" autocomplete="off"  id="money_name[]" class="layui-input">'

            +'<input type="text" name="money[]" lay-verify="required" placeholder="请输入费用额" autocomplete="off"  id="money[]" class="layui-input">'

            +'</div><a class="del_name fl" onclick="del_group(this);">▬</a></div>';

        $("#lee").append(html);

    }
	function  del_group(c_this) {

      $(c_this).parent().remove();

  }

</script>



<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->



<script>



    layui.use(['form', 'layedit', 'laydate'], function(){



        var form = layui.form()



            ,layer = layui.layer



            ,layedit = layui.layedit



            ,laydate = layui.laydate;



        var url = "<?php echo U('Project/examineProject');?>";

        $("#sub").click(function(){



            $.ajax({

                type:'post',

                url:url,

                data:$("#myform").serialize(),

                dataType:'json',

                success:function(data){

                    if(data.status == 'error'){

                        layer.msg(data.msg,{icon: 5});//失败的表情

                        return;

                    }else if(data.status == 'success'){

                        layer.msg(data.msg, {

                            icon: 6,//成功的表情

                            time: 2000 //2秒关闭（如果不配置，默认是3秒）

                        }, function(){
                            window.location.href = "<?php echo U('Project/index');?>";
                            //location.reload();

                        });

                    }

                }

            });

            return false;//阻止表单跳转

        });

        //全选



        form.on('checkbox(allChoose)', function(data){



            var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');



            child.each(function(index, item){



                item.checked = data.elem.checked;



            });



            form.render('checkbox');



        });



    });



</script>







</body>



</html>