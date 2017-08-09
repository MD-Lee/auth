<?php if (!defined('THINK_PATH')) exit();?><style>
.layui-layer-content{ position:relative;}
.m_reason{ width:80px; display:inline-block; height:32px; line-height:32px; margin:0 0 0 6px;}
.w_hours{ width:80px; display:inline-block; height:32px; line-height:32px; margin:0 0 0 6px;}
.w_content{ width:200px; height:50px; margin:0 0 0 6px; padding:6px;}
.layui-form-item{ width:550px;}
.layui_con{ min-height:220px; max-height:220px;}
</style>
<form  method="post" action="<?php echo U('Work/makeupWork');?>">
	<div class="layui_con">
        <div class="layui-form-item">
            <label class="layui-form-label">入职日期</label>
    
            <div class="layui-input-inline">
    
                <input name="additional_recording_time" id="date" lay-verify="date"   placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
    
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">补录原因</label>
            <input class="layui-input m_reason" type="text" name="additional_recording">
        </div>
        
        <div id="lee" class="fl">
            <div class="layui-form-item">
                <label class="layui-form-label fl">项目名称</label>
        
                <select class="select_box fl" name="pid[]" >
        
                    <option value="">选择项目</option>
        
                    <?php if(is_array($project_list)): foreach($project_list as $key=>$v): ?><option  value="<?php echo ($v["pid"]); ?>"><?php echo ($v["project_name"]); ?></option><?php endforeach; endif; ?>
        
                </select>
                
        		<div class="fl"><input class="w_hours layui-input" type="text" name="work_hours[]">&nbsp;小时</div>
                <textarea  class="w_content fl" name="work_content[]"></textarea>
            </div>
        </div>
        <a class="add_name fl" onclick="lee();">✚</a>
    </div>

    <div class="layui-input-block inputbox" style="bottom:30px;">
		<input type="hidden" name="mid" value="<?php echo ($mid); ?>">

        <input type="submit" value="立即提交"class="layui-btn" >

     	<!-- <button class="layui-btn" lay-submit lay-filter="group">立即提交</button>-->

      	<button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>

</form>





<script>

    layui.use('laydate', function(){



        var laydate = layui.laydate;

            $ = layui.jquery



    });

</script>

<script>

    function  lee() {
        var project_list = <?php echo ($project_lists); ?>;
		
        var html = '';

        for(var i=0;i<project_list.length;i++){

            html +=' <option  value="'+project_list[i].pid+'">'+project_list[i].project_name+'</option>';

        }

        var lasthtml ='<div class="layui-form-item"><label class="layui-form-label fl">项目名称</label><select class="select_box fl" name="pid[]" ><option value="">选择项目</option>'

            +html+' </select><div class="fl"><input class="w_hours layui-input" type="text" name="work_hours[]">&nbsp;小时</div><textarea class="w_content fl" name="work_content[]"></textarea><a class="del_name fl" onclick="del_group(this);">▬</a></div>';



        $("#lee").append(lasthtml);

    }

	function  del_group(c_this) {

      $(c_this).parent().remove();

  }
</script>