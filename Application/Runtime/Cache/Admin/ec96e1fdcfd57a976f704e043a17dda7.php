<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form">
  <div class="layui-form-item">
    <label class="layui-form-label">用户名</label>
    <div class="layui-input-inline">
      <input type="text" name="name" lay-verify="required" placeholder="请输入用户名" autocomplete="off"  id="name" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">性别</label>
    <div class="layui-input-block">
      <input name="sex" value="1" title="男" checked="" type="radio"><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>男</span></div>
      <input name="sex" value="2" title="女" type="radio"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>女</span></div>
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">登录密码</label>
    <div class="layui-input-inline">
      <input type="password" name="password" lay-verify="required" placeholder="请输入密码" autocomplete="off" id="pwd" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">手机号</label>
    <div class="layui-input-inline">
      <input name="mobile" lay-verify="phone" autocomplete="off" placeholder="请输入手机号"  class="layui-input" type="tel">
    </div>
  </div>

  <div class="layui-form-item">

    <div class="layui-inline">
      <label class="layui-form-label">入职日期</label>
      <div class="layui-input-inline">
        <input name="created_at" id="date" lay-verify="date" placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
      </div>
    </div>

  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">工资</label>
    <div class="layui-input-inline">
      <input type="text" name="wages" lay-verify="required" placeholder="请输入工资" autocomplete="off"  id="wages" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">分组选择框</label>
      <div class="layui-input-inline">
        <select name="quiz">
          <option value="">请选择问题</option>
          <optgroup label="城市记忆">
            <option value="你工作的第一个城市">你工作的第一个城市</option>
          </optgroup>
          <optgroup label="学生时代">
            <option value="你的工号">你的工号</option>
            <option value="你最喜欢的老师">你最喜欢的老师</option>
          </optgroup>
        </select>
      </div>
    </div>

  </div>

    <div class="layui-form-item">
      <label class="layui-form-label">选择角色</label>

      <div class="layui-input-block">
        <?php if(is_array($list)): foreach($list as $key=>$v): ?><input name="group_id" value="<?php echo ($v["id"]); ?>" title="<?php echo ($v["title"]); ?>"  type="radio"><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span><?php echo ($v["title"]); ?></span></div><?php endforeach; endif; ?>
      </div>
    </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="user">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>


<script>
layui.use(['form','laydate'], function(){

	var form = layui.form(),
   		 $ = layui.jquery
    laydate = layui.laydate;
	  //监听提交
	  form.on('submit(user)', function(data){
		  
	    var userInfo = data.field;
	    
		var url = "<?php echo U('User/addUser');?>";
		$.post(url,userInfo,function(data){
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