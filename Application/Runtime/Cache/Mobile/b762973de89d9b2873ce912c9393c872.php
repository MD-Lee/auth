<?php if (!defined('THINK_PATH')) exit();?><form  method="post" action="<?php echo U('Index/makeupWork');?>">
    <label class="layui-form-label">项目名称</label>
    <select name="pid" >
        <option value="">选择项目</option>
        <?php if(is_array($project_list)): foreach($project_list as $key=>$v): ?><option  value="<?php echo ($v["pid"]); ?>"><?php echo ($v["project_name"]); ?></option><?php endforeach; endif; ?>
    </select>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">补录日期</label>
            <div class="layui-input-inline">
                <input name="additional_recording_time" id="date" lay-verify="date"   placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">
            </div>
        </div>
    </div>

    <label class="layui-form-label">补录原因</label>
    <input type="text" name="additional_recording">
 <div id="lee">
        <input type="text" name="work_hours">小时
        <textarea name="work_content"></textarea>
 </div>


  <div class="layui-form-item">
    <div class="layui-input-block">
<input type="hidden" name="mid" value="<?php echo ($mid); ?>">
        <input type="submit" value="立即提交"class="layui-btn" >
     <!-- <button class="layui-btn" lay-submit lay-filter="group">立即提交</button>-->
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>

<script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
<script>
    layui.use('laydate', function(){

        var laydate = layui.laydate;
            $ = layui.jquery

    });
</script>