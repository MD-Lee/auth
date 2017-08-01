<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Table</title>
  <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all" />
  <link rel="stylesheet" href="/Public/css/global.css" media="all">
  <link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
</head>
<body>


<form class="layui-form" action="/Project/addProjectMember" method="post">

  <div class="layui-form-item">
    <label class="layui-form-label">所属公司</label>
    <div class="layui-input-block">
      <select name="cid" lay-filter="aihao">
        <option value=""></option>
        <?php if(is_array($company)): foreach($company as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
      </select>
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">项目名称</label>
    <div class="layui-input-block">
      <input name="project_name" lay-verify="title" autocomplete="off" placeholder="请输入项目名称" class="layui-input" type="text">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">项目合同额</label>
    <div class="layui-input-block">
      <input name="money" lay-verify="title" autocomplete="off" placeholder="请输入项目合同额" class="layui-input" type="text">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">项目成员 <a>添加</a><a onclick="edt_member()">修改</a></label>
    <div class="layui-input-block">
      <textarea id="textarea_content" placeholder="请输入内容" class="layui-textarea"></textarea>
    </div>
  </div>

  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
</form>

<div class="layui-inline">
  <form >
    <div class="layui-input-inline">
      <select name="cid" id="cid">
        <option value="" selected="selected">请选择公司</option>
        <?php if(is_array($company)): foreach($company as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>" ><?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
      </select>
      <select name="gid" id="gid">
      </select>
    </div>
    <input type="hidden" name="fgid" id="fgid" value="">
    <input type="button" class="layui-btn layui-btn-small search_btn" onclick="select_member()"></input>
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
      <th><input  id="selects" type="checkbox"></th>
      <th>姓名</th>
      <th>项目分账比例</th>
    </tr>
    </thead>
    <tbody id="check_member">
    </tbody>
  </table>
  <button  class="layui-btn layui-btn-primary add_member" >添加</button>
</div>
<!--end选择-->
<!--选中-->
<div class="">
  <table class="layui-table">
    <colgroup>
      <col width="50">
      <col width="50">
      <col width="150">
      <col>
    </colgroup>
    <thead>
    <tr>
      <th><input name=""  type="checkbox"></th>
      <th>已选成员</th>
      <th>项目分账比例</th>
      <th>操作</th>
    </tr>
    </thead>
    <tbody id="add_member">
    </tbody>
  </table>
  <button  class="layui-btn layui-btn-primary check_member">添加</button>
</div>
<!--end选中-->
<script charset="utf-8" type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
  <script charset="utf-8" type="text/javascript" src="/Public/plugins/my.js"></script>
  <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
  <script>
      layui.use(['form', 'layedit', 'laydate'], function(){
          var form = layui.form()
              ,layer = layui.layer
              ,layedit = layui.layedit
              ,laydate = layui.laydate;
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