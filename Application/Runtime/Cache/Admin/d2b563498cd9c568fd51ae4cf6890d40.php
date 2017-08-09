<?php if (!defined('THINK_PATH')) exit();?><style>
.layui-form-item{ margin-bottom:6px;}
.layui-form-label{ padding:8px 15px;}
.layui-input{ line-height:30px; height:30px;}
</style>

<form id="myform">

  <div class="layui-form-item">

    <label class="layui-form-label">用户名</label>

    <div class="layui-input-inline">

      <input type="text" name="user_name" lay-verify="required" placeholder="请输入用户名" value="<?php echo ($user_info["user_name"]); ?>" autocomplete="off"   id="name" class="layui-input">

    </div>

  </div>



  <div class="layui-form-item" pane="">

    <label class="layui-form-label">性别</label>

    <div class="layui-input-block">
	  <div style=" height:30px; line-height:30px;">
          <input name="sex" value="1" <?php if($user_info['sex'] != 2 ): ?>checked=""<?php endif; ?> type="radio">&nbsp;男
    
          <input name="sex" value="2" type="radio" <?php if($user_info['sex'] == 2 ): ?>checked=""<?php endif; ?>>&nbsp;女
      </div>

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

      <input name="mobile" lay-verify="phone"  value="<?php echo ($user_info["mobile"]); ?>"  autocomplete="off" placeholder="请输入手机号"  class="layui-input" type="tel">

    </div>

  </div>



  <div class="layui-form-item">

    <div class="layui-inline">

      <label class="layui-form-label">入职日期</label>

      <div class="layui-input-inline">

        <input name="create_time" id="date" lay-verify="date"  value="<?php echo ($user_info["create_time"]); ?>"  placeholder="yyyy-mm-dd" autocomplete="off" class="layui-input" onclick="layui.laydate({elem: this})" type="text">

      </div>

    </div>

  </div>



  <div class="layui-form-item">

    <label class="layui-form-label">工资</label>

    <div class="layui-input-inline">

      <input type="text" name="wages" lay-verify="required" value="<?php echo ($user_info["wages"]); ?>" placeholder="请输入工资" autocomplete="off"  id="wages" class="layui-input">

    </div>

  </div>
  
  <div class="layui-form-item">

    <label class="layui-form-label">公司</label>

    <div class="layui-input-inline">

      <select class="select_box" name="cid" id="company_id">
          <option value="" selected="selected">请选择公司</option>
          <?php if(is_array($company_list)): foreach($company_list as $key=>$v): ?><option  value="<?php echo ($v["id"]); ?>" <?php if($user_info['cid'] == $v['id']): ?>selected<?php endif; ?>> <?php echo ($v["name"]); ?></option><?php endforeach; endif; ?>
       </select>

    </div>

  </div>
  
  <div class="layui-form-item">

    <label class="layui-form-label">小组</label>

    <div class="layui-input-inline">

      <select class="select_box" name="gid" id="group_id">
      	<option value="" selected="selected">请选择小组</option>
      </select>

    </div>

  </div>

<input type="hidden" name="is_edit" value="<?php echo ($is_edit); ?>">

  <input type="hidden" value="<?php echo ($user_info["id"]); ?>" name="id">

  <input type="hidden" name="fgid" id="fgid" class="fgid" value="<?php echo ($user_info['gid']); ?>">



  <div class="layui-form-item">

    <label class="layui-form-label">选择角色</label>

    <input type="hidden" name="user_id" value="<?php echo ($user_id); ?>" />

    <div class="layui-input-block">
	  <div style=" height:30px; line-height:30px;">
      <?php if(is_array($list)): foreach($list as $key=>$v): ?><input name="group_id" type="radio" <?php if($user_info['group_id'] == $v['id']): ?>checked<?php endif; ?> title="<?php echo ($v["title"]); ?>" value="<?php echo ($v["id"]); ?>" >&nbsp;<?php echo ($v["title"]); ?>&nbsp;<?php endforeach; endif; ?>
      </div>

    </div>

  </div>



  <div class="layui-form-item">

    <div class="layui-input-block">

      <button class="layui-btn" lay-submit id="sub">立即提交</button>

      <button type="reset" class="layui-btn layui-btn-primary">重置</button>

    </div>

  </div>

</form>



<script>

    layui.use(['laypage','layer','form','laydate'], function(){

       // var form = layui.form()

           laydate = layui.laydate,

            $ = layui.jquery;

             $form = $('form');



        var efgid =$(".fgid").val();

        var ecid = $('#company_id').children('option:selected').val();



        if(ecid){

            var url="/Admin/Ajax/getGroup";

            $.get(url,{cid:ecid},function(data){

                var egroup_info = data.group_info;



                var egroupHtml = '<option value="">请选择小组</option>';

                if(egroup_info.length>0){

                    for (var i = 0; i < egroup_info.length; i++) {

                        if(efgid == egroup_info[i].id ){



                            var s = 'selected';

                        }else{

                            var s='';

                        }

                        egroupHtml += '<option '+s+ ' value="' + egroup_info[i].id +'">' + egroup_info[i].group_name + '</option>';

                    }

                }



                $form.find('select[name=gid]').html(egroupHtml)



            })

        }

             /*公司列表获取*/

        $ ('#company_id').change(function () {



            //alert($(this).children('option:selected').val());

            var url = "/Admin/Ajax/getGroup";

            var cid = $(this).children('option:selected').val();

            $.get(url,{cid:cid},function(data){

                var group_info = data.group_info;



                var groupHtml = '<option value="">请选择小组</option>';

                if(group_info.length > 0){



                    for (var i = 0; i < group_info.length; i++) {

                        if(fgid == group_info[i].id ){

                            var s = 'selected';

                        }else{

                            var s='';

                        }

                        groupHtml += '<option '+s+ ' value="' + group_info[i].id +'">' + group_info[i].group_name + '</option>';

                    }



                }

                $form.find('select[name=gid]').html(groupHtml)



            })

        });

        $('#group_id').change(function () {



            var gid = $(this).children('option:selected').val();



            $("#fgid").val(gid);

        });



        /*end*/

        //监听提交

        var url = "<?php echo U('User/addUser');?>";

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

       /* form.on('submit(user)', function(data){



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

        });*/

    });

</script>