
var $form;
var form;
var $;
layui.config({
    base : "/layui/layui.js"
}).use(['form','layer','upload','laydate'],function(){
    form = layui.form();
    var layer = parent.layer === undefined ? layui.layer : parent.layer;
    $ = layui.jquery;
    $form = $('form');
    var url="/Admin/Ajax/getGroup";
    var cid = $('#cid').children('option:selected').val();
    var fgid =$("#fgid").val();

    if(cid){
        $.get(url,{cid:cid},function(data){
            var group_info = data.group_info;
            var groupHtml = '<option value="">请选择小组</option>';
            if(group_info.length>0){
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
    }

    $('#cid').change(function () {

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
    $('#gid').change(function () {

        var gid = $(this).children('option:selected').val();

        $("#fgid").val(gid);
    });

    /*导出*/
    $('.export').click(function(){
        var url = "/Admin/Ajax/userExport";
        window.location.href="/Admin/Ajax/userExport?cid="+cid+"&gid"+fgid;

    });
    //成员全选
    $("#selects").click(function() {
        if ($(this).is(':checked')) {
            $("input[name=eid]").each(function() {
                $(this).attr("checked", true);
            });
        } else {
            $("input[name=eid]").each(function() {
                $(this).attr("checked", false);
            });
        }
    });
    //得到选中的值，ajax操作使用
    $(".add_member").click(function() {

        var text="";
        var member_ratio_value="";
        $("input[name=eid]").each(function() {
            if ($(this).is(':checked')) {
                text += $(this).val()+",";//小组成员ID
                member_ratio_value += $('#member_ratio'+$(this).val()).val()+",";//小组成员分成比例

            }
        });
        var cl = $("input[name='eid']:checked").length;

       if(cl<=0){
           alert("没有选中值");
       }else{
           var url = "/Admin/Ajax/addCompanyMember";
           var project_id = $("#project_id").val();

           $.get(url,{text:text,member_ratio_value:member_ratio_value,project_id:project_id},function(data){
               var company_member = data.company_member;
               var member_info = data.member_ratio_value;
               var  Htmls = '';
               if(company_member.length > 0){

                   for (var i = 0; i < company_member.length; i++) {

                       Htmls += '<tr><td><input  id="ceid" name="ceid" value="'+company_member[i].id+'"  type="checkbox"></td><td>'+company_member[i].user_name+'</td>'

                           +'<td><input type="text" value="'+member_info[i]+'" id="cmember_ratio'+company_member[i].id+'" name="cmember_ratio[]">%</td>'
                           +'<td><a>删除</a></td>'
                           +'</tr>';
                   }


               }

               $("#add_member").html(Htmls);
               $(".modify_member").show();

           });
       }
    });



//提交最终得到选中的值，ajax操作使用
    $(".check_member").click(function() {
        var ctext="";
        var cmember_ratio_value="";
        $("input[name=ceid]").each(function() {
            if ($(this).is(':checked')) {
                ctext += $(this).val()+",";
                cmember_ratio_value += $('#cmember_ratio'+$(this).val()).val()+",";
            }
        });
        var ccl = $("input[name='ceid']:checked").length;

        if(ccl<=0){
            alert("没有选中值");
        }else{

            var url = "/Admin/Ajax/checkCompanyMember";
            $.get(url,{ctext:ctext,cmember_ratio_value:cmember_ratio_value},function(data){
                var ccompany_member = data.company_member;
                var cmember_info = data.member_ratio_value;
                var  cHtmls = '';
                if(ccompany_member.length > 0){
                    for (var i = 0; i < ccompany_member.length; i++) {
                        cHtmls += ccompany_member[i].user_name+'  '+cmember_info[i]+'%'+'\n';
                    }
                }

                $("#textarea_content").html(cHtmls);
                $(".modify_member").hide();
                $(".add_member_con").hide();
            });
        }
    });

})
//获取公司小组下的成员
function select_member() {

    var cid = $('#cid').children('option:selected').val();
    var fgid =$("#fgid").val();
    var url = "/Admin/Ajax/getCompanyMember";
    $.get(url,{cid:cid,'gid':fgid},function(data){
        var member_info = data.member_info;
        var  Html = '';
        if(member_info.length > 0){

            for (var i = 0; i < member_info.length; i++) {

                Html += '<tr><td><input  id="eid" name="eid" value="'+member_info[i].id+'"  type="checkbox"></td><td>'+member_info[i].user_name+'</td>'

                    +'<td><input type="text" value="0" id="member_ratio'+member_info[i].id+'" name="member_ratio[]">%</td>'
                    +'</tr>';
            }


        }
        $("#check_member").html(Html);

    })
};
//修改选中的成员
function edt_member() {
    var url = "/Admin/Ajax/addCompanyMember";
    var project_id = $("#project_id").val();
alert(project_id);

    $.get(url,{type:1,project_id:project_id},function(data){
        var company_member = data.company_member;
        var member_info = data.member_ratio_value;
        var  Htmls = '';
        if(company_member.length > 0){

            for (var i = 0; i < company_member.length; i++) {

                Htmls += '<tr><td><input  id="ceid" name="ceid" value="'+company_member[i].id+'"  type="checkbox"></td><td>'+company_member[i].user_name+'</td>'

                    +'<td><input type="text" value="'+member_info[i]+'" id="cmember_ratio'+company_member[i].id+'" name="cmember_ratio[]">%</td>'
                    +'<td><a>删除</a></td>'
                    +'</tr>';
            }


        }
        $("#add_member").html(Htmls);

        $(".add_member_box").hide();
    });

}






