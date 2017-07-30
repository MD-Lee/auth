
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
    var url="/Ajax/getGroup";
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
        var url = "/Ajax/getGroup";
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

    /*导出*/
    $('.export').click(function(){
        var url = "/Ajax/userExport";
        window.location.href="/Ajax/userExport?cid="+cid+"&gid"+fgid;

    });

})



