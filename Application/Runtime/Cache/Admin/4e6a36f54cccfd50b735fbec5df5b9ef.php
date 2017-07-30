<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form" method="post" action="<?php echo U('Project/examineProject');?>">
 <div id="lee">
<?php if(is_array($cost_info)): foreach($cost_info as $k=>$v): ?><div class="layui-form-item">
    <label class="layui-form-label">费用</label>
    <div class="layui-input-inline">
      <input type="text" value="<?php echo ($k); ?>" name="money_name[]" lay-verify="required" placeholder="请输入费用名" autocomplete="off"  id="money_name[]" class="layui-input">
      <input type="text" value="<?php echo ($v); ?>" name="money[]" lay-verify="required" placeholder="请输入费用额" autocomplete="off"  id="money[]" class="layui-input">
    </div>
  </div><?php endforeach; endif; ?>
 </div>
    <div class="layui-form-item">
        <label class="layui-form-label">绩效比例设置</label>
        <div class="layui-input-inline">
            <input type="text" value="<?php echo ($achievements_ratio); ?>" name="achievements_ratio" lay-verify="required" placeholder="请输入绩效比例设置" autocomplete="off"  id="achievements_ratio" class="layui-input">
        </div>
    </div>
  <a onclick="lee();">+</a>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <input type="hidden" value="<?php echo ($project_id); ?>" name="project_id">
        <input type="submit" value="立即提交"class="layui-btn" >
     <!-- <button class="layui-btn" lay-submit lay-filter="group">立即提交</button>-->
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>
<script type="text/javascript" src="/Public/plugins/jquery.min.js"></script>
<script>
  function  lee() {
      var html ='<div class="layui-form-item"><label class="layui-form-label">费用</label><div class="layui-input-inline">'
          +'  <input type="text" name="money_name[]" lay-verify="required" placeholder="请输入费用名" autocomplete="off"  id="money_name[]" class="layui-input">'
          +'<input type="text" name="money[]" lay-verify="required" placeholder="请输入费用额" autocomplete="off"  id="money[]" class="layui-input">'
          +'</div></div>';
  $("#lee").append(html);
  }
</script>
<script>
layui.use('form', function(){
	var form = layui.form(),
   		 $ = layui.jquery
	  //监听提交
	  form.on('submit(group)', function(data){
		  
	    var costInfo = data.field;
	    
		var url = "<?php echo U('Project/examineProject');?>";
		$.post(url,costInfo,function(data){
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