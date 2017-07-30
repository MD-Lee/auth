<?php if (!defined('THINK_PATH')) exit();?><form class="layui-form" method="post" action="<?php echo U('Project/examineProject');?>">
 <div id="lee">

     <div class="layui-form-item">
         <label class="layui-form-label">单行选择框</label>
         <div class="layui-input-block">
             <select name="interest" lay-filter="aihao">
                 <option value=""></option>
                 <option value="0">写作</option>
                 <option value="1" selected="">阅读</option>
                 <option value="2">游戏</option>
                 <option value="3">音乐</option>
                 <option value="4">旅行</option>
             </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input placeholder="请选择" value="阅读" readonly="" class="layui-input layui-unselect" type="text"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit"><dd lay-value="0" class="">写作</dd><dd lay-value="1" class="layui-this">阅读</dd><dd lay-value="2" class="">游戏</dd><dd lay-value="3" class="">音乐</dd><dd lay-value="4" class="">旅行</dd></dl></div>
         </div>
     </div>

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
<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
<script>
    layui.use('form', function(){
        var form = layui.form();
        form.render('select');
    });
</script>
<script>
  function  lee() {
      var html ='<div class="layui-form-item"><label class="layui-form-label">费用</label><div class="layui-input-inline">'
          +'  <input type="text" name="money_name[]" lay-verify="required" placeholder="请输入费用名" autocomplete="off"  id="money_name[]" class="layui-input">'
          +'<input type="text" name="money[]" lay-verify="required" placeholder="请输入费用额" autocomplete="off"  id="money[]" class="layui-input">'
          +'</div></div>';
  $("#lee").append(html);
  }
</script>