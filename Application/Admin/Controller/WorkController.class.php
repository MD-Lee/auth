<?php
namespace Admin\Controller;

class WorkController extends CommonController
{
    protected $work_model;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_work_model \Admin\Model\EmployeeModel */
        $work_model = D('MemberWork');

        $this->work_model = $work_model;
    }
    
    /**
     * @description:工时列表
     * @author wuyanwen(2016年12月1日)
     */

    public function index()
    {
        $user_info = session('user_info');
        $where['uid'] = $user_info['id'];
        I('get.start_time')?$start_time = array('egt',strtotime(I('get.start_time'))):'';
        I('get.end_time')?$end_time = array('elt',strtotime(I('get.end_time')))  :'';
        $start_time? $where['created_time'] =$start_time:'';
        $end_time? $where['created_time'] =$end_time:'';
        if($start_time && $end_time)  $where['created_time'] = array($start_time,$end_time);

        $work_info = $this->work_model->selectAllWrok(10,$where);

        $this->work_model->getLastSql();
        $this->assign('work_info',$work_info['list']);
        $this->assign('page',$work_info['page']);
        $this->assign('start_time',I('get.start_time'));
        $this->assign('end_time', I('get.end_time'));
        $this->display();
    }
    /**
     * @description:添加工时
     * @author wuyanwen(2016年12月1日)
     */
    public function addWork()
    {
        $user_info = session('user_info');
        $uid = $user_info['id'];
        if(IS_POST){
            //Array (
            // [pid] => Array ( [0] => 2 [1] => 2 )
            // [work_hours] => Array ( [0] => 1 [1] => 3 ) [
            //work_content] => Array ( [0] => 去 [1] => 订单 )

            $work_info = array(
                'pid'      => I('post.pid'),
                'work_hours'      => I('post.work_hours'),
                'work_content'      => I('post.work_content'),
                'uid'      => $uid,
                'created_time'      => time(),
            );

           if($this->work_model->addWork($work_info)){
               $this->success('添加成功');
           }else{
              $this->error('添加失败');
           }
        }else{
            $project_member_model = D('ProjectMember');
            $project_list = $project_member_model->getProjectListByUid($uid);


            $this->assign('project_list', $project_list);
            $this->assign('project_lists', json_encode($project_list));
            $this->display();
        }
    }
    public function makeupWork()
    {
        $user_info = session('user_info');
        $uid = $user_info['id'];
        if(IS_POST){
            //Array (
            // [additional_recording_time] => 2017-07-25
            // [additional_recording] => 333
            //[pid] => Array ( [0] => 2 [1] => 2 )
            // [work_hours] => Array ( [0] => 5 )
            // [work_content] => Array ( [0] => 4 )
            // [mid] => 1 )
        $work_info = array(

                'pid'      => I('post.pid'),
                'additional_recording_time'      => I('post.additional_recording_time'),
                'additional_recording'      => I('post.additional_recording'),
                'work_hours'      => I('post.work_hours'),
                'work_content'      => I('post.work_content'),
                'uid'      => $uid,
            );

            if($this->work_model->addMakeupWork($work_info)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $project_member_model = D('ProjectMember');
            $project_list = $project_member_model->getProjectListByUid($uid);
            $this->assign('project_list', $project_list);
            $this->assign('project_lists', json_encode($project_list));
            $this->display();
        }
    }

    
    /**
     * @description:编辑用户
     * @author wuyanwen(2016年12月1日)
     */
    public function editWork()
    {            
        if(IS_POST){
            $employee_info = array(
                'employee_name' => I('post.employee_name','','trim'),
                'id'        => I('post.id','','intval'),
            );
           
           if(I('post.password')){
               $employee_info['password'] = md5(I('post.password','','trim'));
           }

           if($this->admin_work_model->editAdminemployee($employee_info) !== false){
               $this->ajaxSuccess('更新成功');
           }else{
              $this->ajaxError('更新失败');
           }
        }else{
            $employee_id = I('get.employee_id','','intval');
            $employee_info = $this->admin_work_model->findAdminemployeeById($employee_id);
            $this->assign('employee_info',$employee_info);
            $this->display();
        }
    }
    
    
    /**
     * @description:删除工时
     * @author wuyanwen(2016年12月1日)
     */
    public function delWork()
    {
        $work_id = I('post.work_id','','intval');
        
        $result = $this->work_model->deleteWork($work_id);
        
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}