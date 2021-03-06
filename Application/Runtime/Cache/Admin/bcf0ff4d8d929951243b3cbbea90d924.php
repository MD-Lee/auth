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
			overflow-y:;
		}
		#myform{ padding:10px 0; height:310px; overflow-y:auto;}
        .layui-textarea{ width:300px;}
		.layui-form-item{ line-height:30px; margin-bottom:8px;}
		.layui-form-label{ width:100px; color:#777; padding:7px 15px;}
		.layui-form-item .layui-input-inline{overflow:hidden; width:320px; margin-right:0}
		.layui-input{ display:inline-block; width:150px; float:left; margin:0 6px 0 0;}
		.layui-input-block{ line-height:36px;}
    </style>
</head>

<body>





<form id="myform" >



    <div class="layui-form-item">

        <label class="layui-form-label">所属公司</label>

        <div class="layui-input-block">

            <?php echo ($project_info['company_name']); ?>

        </div>

    </div>



    <div class="layui-form-item">

        <label class="layui-form-label">项目名称</label>

        <div class="layui-input-block">

            <?php echo ($project_info['project_name']); ?>

        </div>

    </div>



    <div class="layui-form-item">

        <label class="layui-form-label">项目合同额</label>

        <div class="layui-input-block">

            <?php echo ($project_info['money']); ?>
        </div>

    </div>

    <div class="layui-form-item">

        <label class="layui-form-label">项目成员</label>

        <div class="layui-input-block">

            <textarea readonly id="textarea_content" placeholder="请输入内容" class="layui-textarea fl">
             <?php echo ($project_info['show_project_member']); ?>
            </textarea>
        </div>

    </div>



    <div class="layui_con">
        <div id="lee" class="fl">
            <?php if(is_array($project_info['cost_info'])): foreach($project_info['cost_info'] as $k=>$v): ?><div class="layui-form-item">
                    <label class="layui-form-label">费用</label>
                    <div class="layui-input-inline">
                        <input type="text" value="<?php echo ($k); ?>" name="money_name[]" lay-verify="required" placeholder="请输入费用名" autocomplete="off"  id="money_name[]" class="layui-input">
                        <input type="text" value="<?php echo ($v); ?>" name="money[]" lay-verify="required" placeholder="请输入费用额" autocomplete="off"  id="money[]" class="layui-input">
                    </div>
                </div><?php endforeach; endif; ?>
        </div>
        <a class="add_name fl" onclick="lee();">✚</a>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">绩效比例设置</label>
        <div class="layui-input-inline">
           <input class="layui-input" type="text" readonly name="achievements_ratio" value="<?php echo ($project_info['achievements_ratio']); ?>%"/>
        </div>
    </div>
    
    <input type="hidden" name="project_id" value="<?php echo ($project_info['id']); ?>" id="project_id">
    <div class="layui-form-item">
        <label class="layui-form-label">&nbsp;</label>
        <div class="layui-input-block">
            <a class="layui-btn"   onclick="sub(1)" >审核通过</a>
            <a class="layui-btn"  onclick="sub(3)">审核不通过</a>
        </div>

    </div>

</form>



</fieldset>
<!--end选中-->

<script charset="utf-8" type="text/javascript" src="/Public/plugins/layui/layui.js"></script>

<script charset="utf-8" type="text/javascript" src="/Public/plugins/my.js"></script>

<script>
    function  lee() {
        var html ='<div class="layui-form-item"><label class="layui-form-label">费用</label><div class="layui-input-inline">'
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

        var url = "<?php echo U('Finance/examineProject');?>";

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
                            location.reload();
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
<script>

    function  sub(finance_status) {
        var url = '/Admin/Finance/examineProject?finance_status='+finance_status;
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
                        location.reload();
                    });
                }
            }
        });
    }
</script>


</body>

</html>