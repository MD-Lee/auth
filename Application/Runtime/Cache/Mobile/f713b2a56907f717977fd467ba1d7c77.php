<?php if (!defined('THINK_PATH')) exit();?><form  method="post" action="<?php echo U('Index/addWork');?>">
 <div id="lee">

         <label class="layui-form-label">项目名称</label>
             <select name="pid" >
                 <option value="">选择项目</option>
                 <?php if(is_array($project_list)): foreach($project_list as $key=>$v): ?><option  value="<?php echo ($v["pid"]); ?>"><?php echo ($v["project_name"]); ?></option><?php endforeach; endif; ?>
             </select>
        <input type="text" name="work_hours">小时
        <textarea name="work_content"></textarea>

 </div>


  <div class="layui-form-item">
    <div class="layui-input-block">

        <input type="submit" value="立即提交"class="layui-btn" >
     <!-- <button class="layui-btn" lay-submit lay-filter="group">立即提交</button>-->
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>

<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
<script>
    layui.use(['jquery', 'layer','form'], function(){
        var form = layui.form();
        var $ = layui.jquery //重点处
            ,layer = layui.layer;
       //form.render('select');
        //后面就跟你平时使用jQuery一样

    });

</script>