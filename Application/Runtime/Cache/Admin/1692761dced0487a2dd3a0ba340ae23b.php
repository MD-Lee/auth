<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">小组名称</label>
    <div class="layui-input-inline">
      <input type="text" name="group_name" lay-verify="required" placeholder="小组名称" id="name" value="<?php echo ($company_group_info["group_name"]); ?>"class="layui-input">
    </div>
  </div>

  <input type="hidden" value="<?php echo ($company_group_info["id"]); ?>" name="group_id">
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="group">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script>
layui.use('form', function(){
	var form = layui.form(),
   		 $ = layui.jquery
	  //监听提交
	  form.on('submit(group)', function(data){
	    var groupInfo = data.field;
		var url = "<?php echo U('Company/editCompanyGroup');?>";
		$.post(url,groupInfo,function(data){
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
		})
		
	    return false;//阻止表单跳转
	  });
	});
</script>