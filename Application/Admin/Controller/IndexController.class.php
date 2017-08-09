<?php
namespace Admin\Controller;

class IndexController extends CommonController {


    public function index()
    {

        $user_info = session('user_info');
        /* @var $admin_auth_group_access_model \Admin\Model\AdminAuthGroupAccessModel */
        $admin_auth_group_access_model = D('AdminAuthGroupAccess');
        $menus = $admin_auth_group_access_model->getUserRules($user_info['id']);
        
        $this->assign('menus', $menus);
        $this->assign('user_info', $user_info);
        $this->display();
    }
    
    public function nav()
    {
        $this->display();
    }
    
    
    public function login()
    {
       $this->display();
    }
    
    public function form()
    {
        $this->display();
    }
    
    
    public function table()
    {
       $this->display();
       
    }
    
    public function main()
    {
        //个人分账 person_split
        //项目统计 project_info
        //公司统计 company_list
        //总工时列表 work_hours
        //工时占比 hours_ratio
        $type = I('get.type','','trim');//1 个人分账  2项目统计  3公司统计  4总工时列表 5工时占比
        $export= I('get.export','','trim');// 1导出操作 0非导出操作

        I('get.cid','','trim')?$where['a.cid'] = I('get.cid','','trim'):'';//公司
        I('get.gid','','trim')?$where['a.gid'] = I('get.gid','','trim'):'';//小组

        //个人分账
        $person_split = D('MemberWork')->getAllWrokMember($where);

        foreach ($person_split as & $w){
            //（员工工资/21*8小时）*项目参与工时＝员工项目成本(人工成本) 项目工时 成本
            if(I('get.finish_time')){
                $finish_time = I('get.finish_time');

                $finish_time = getMonthRange($finish_time);
                $wh_where1['mw.created_time'] = array(array('egt',$finish_time['firstday']),array('elt',$finish_time['lastday'])) ;
                $sp_where['p.finish_time'] = array(array('egt',$finish_time['firstday']),array('elt',$finish_time['lastday'])) ;
            }
            I('get.pid','','trim')?$wh_where1['mw.id'] = I('get.pid','','trim'):'';//项目ID
            $wh_where1['mw.uid'] = $w['id'];
            $split_workhours = D('MemberWork')->getPersonSplitWorkHours($wh_where1);
            $w['split_workhours'] = $split_workhours;
            $w['person_cost'] =round((($w['wages']/176)*$split_workhours),2);//成本
            //项目工时 成本 end
            //分账
            $sp_where['pm.eid'] = $w['id'];
            I('get.pid','','trim')?$sp_where['pm.id'] = I('get.pid','','trim'):'';//项目ID
            $w['split_money'] = D('MemberWork')->getPersonSplit($sp_where);
            unset($w['id']);
            unset($w['wages']);
            //分账end
        }
        //print_r($person_split);
        if($type == 1 && $export){

            //筛选条件
            $title = array('参与者','所属公司','所属小组','工时','人工成本','分账');
            $name = '个人分账';

            echo  exportexcel($person_split,$title,$name);
            die;
        }
        //END


        //项目统计
        //获取当前月的开始时间、结束时间：
        if(I('get.create_time','','trim')){
            $firstday = date('Y-m-01 00:00:00', strtotime(I('get.create_time')));  //本月第一天
            $lastday = date('Y-m-d 23:59:59', strtotime("$firstday +1 month -1 day")); //本月最后一天
            $p_where['create_time'] = array(array('gt',strtotime($firstday)),array('lt',strtotime($lastday))) ;
        }
        /*搜索条件*/
        I('get.cid','','trim')?$p_where['cid'] = I('get.cid','','trim'):'';
        I('get.finance_status','','trim')?$p_where['finance_status'] = I('get.finance_status','','trim'):'';
        I('get.status','','trim')?$p_where['status'] = I('get.status','','trim'):'';
        //获取数据列表
        $project_info =D('Project')->selectAllProject(10,$p_where,1);
        $project_info  = $project_info ['list'];

        foreach ($project_info as & $pv){
            unset($pv['cid']);
            unset($pv['cost']);
            unset($pv['achievements_ratio']);
            unset($pv['status']);
            unset($pv['finance_status']);
            unset($pv['received_payments_type']);
            unset($pv['finish_time']);
            unset($pv['sum_profit']);
            unset($pv['person_cost']);

            $pv['create_time'] = date('Y-m-d', $pv['create_time']);
        }
        //print_r($project_info);

        if($type == 2 && $export){
            //筛选条件

            $title = array('序号','项目名称','合同额','创建时间','财务审核','项目状态','工时合计','总成本合计','绩效合计','盈利率');
            $name = '项目统计';
            echo  exportexcel($project_info,$title,$name);
            exit;

        }
        //项目统计END

        //公司统计

        $company_lists =  D('AdminUser')->findAllCompany();//公司列表

        foreach ($company_lists as & $cv){

            if(I('get.finish_time')){
                $finish_time = I('get.finish_time');
                $finish_time =  getMonthRange($finish_time);
                $cv_where['finish_time'] = array(array('egt',$finish_time['firstday']),array('elt',$finish_time['lastday'])) ;
            }

            $cv_where['cid'] = $cv['id'];
            $r_info = D('Project')->mainCompany($cv_where);
            $cv['sum_money'] =$r_info['sum_money'];
            $cv['person_sum_times'] =$r_info['person_sum_times'];
            $cv['person_cost'] =$r_info['person_cost'];
            $cv['operate_cost'] =$r_info['operate_cost'];
            $cv['sum_ratio'] =$r_info['sum_ratio'];
            $cv['profit_margin'] =$r_info['profit_margin'];
            unset($cv['id']);
        }

        if($type == 3 && $export){
            //筛选条件
            $title = array('公司名称','合同总额','申报工时','人工成本','运营成本','绩效合计','盈利率');
            $name = '公司统计';
            echo  exportexcel($company_lists,$title,$name);
            exit;
        }
        //公司统计END



        //总工时列表 work_hours
        $create_time = I('get.create_time')?I('get.create_time'):'2017';
        $month =  array('1','2','3','4','5','6','7','8','9','10','11','12');//月份
        $work_member5  = D('MemberWork')->getAllWrokMember($where);//获取所有员工列表

        foreach ($work_member5 as & $value){
            $work_hours_list = array();
            foreach ($month as  $v){
                $monthrange = getMonthRange($create_time."-".$v);
                $where5['created_time'] = array(array('egt',$monthrange['firstday']),array('elt',$monthrange['lastday'])) ;
                $where5['uid'] = $value['id'];
                $work_hours  = D('MemberWork')->getMemberWorkHours($where5);
                $value[$v] = $work_hours;
            }

            unset($value['id']);
            unset($value['wages']);
            unset($value['group_name']);
            unset($value['name']);
        }
       // print_r($work_member5);
        if($type == 4 && $export){
            //筛选条件

                $title = array('员工','1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月');
                $name = '总工时统计表';
                echo  exportexcel($work_member5,$title,$name);
                exit;

        }

        //END

        //工时占比 hours_ratio
        if(I('get.finish_time')){
            $finish_time = I('get.finish_time');
            $finish_time =  getMonthRange($finish_time);
            $hr_where['finish_time'] = array(array('egt',$finish_time['firstday']),array('elt',$finish_time['lastday'])) ;
        }
        $hours_ratio = D('Project')->hours_ratio($hr_where);

       // print_r($hours_ratio);
        //end 工时占比 hours_ratio


        $company_list =  D('AdminUser')->findAllCompany();//公司列表
        $project_list = M('project')->field('id,project_name')->select();//项目列表
        $this->assign('company_list',$company_list);
        $this->assign('project_list',$project_list);

        $this->assign('work_member5',$work_member5);
        $this->assign('person_split',$person_split);
        $this->assign('company_lists',$company_lists);
        $this->assign('hours_ratio',$hours_ratio);

        $this->assign('project_info',$project_info);
        $this->display();
    }
    public function upload()
    {
        if(IS_POST){
           $img = $_FILES['file'];
           $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize   = 3145728 ;// 设置附件上传大小
           $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->rootPath  = './Public/'; // 设置附件上传根目录
           $upload->savePath  = 'upload/'; // 设置附件上传（子）目录
           // 上传文件
           $info   =   $upload->uploadOne($img);
          
          
           if(!$info) {// 上传错误提示错误信息
               echo json_encode(array('status' => 'error','msg' => $upload->getError()));
               exit;
           }else{// 上传成功
               
               $imgpath = $info['savepath'].$info['savename'];
               echo json_encode(array('status' => 'success','url'=>'/Public/'.$imgpath));
               exit;
           }
           
        }else{
            $this->display();
        }
        
    }
    //验证码
    public function verify(){
        $Verify = new \Think\Verify();   
        $Verify->codeSet = '0123456789';// 设置验证码字符为纯数字   
        $Verify->length = 4;
        $Verify->imageH = 37;
        $Verify->imageW = 120;
        $Verify->fontSize = 18;
        $Verify->useNoise = true;
        $Verify->useCurve = true;
        $Verify->fontttf = "5.ttf";
        $Verify->bg = array(196,223,246);    
        $Verify->entry();    
    }

}