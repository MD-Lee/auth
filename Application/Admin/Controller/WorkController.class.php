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
    public function addwork()
    {
        if(IS_POST){
            
            $employee_info = array(
                'name'      => I('post.name','','trim'),
                'sex'      => I('post.sex','','trim'),
                'mobile'      => I('post.mobile','','trim'),
                'wages'      => I('post.wages','','trim'),
                'cid'      => I('post.cid','','trim'),
                'gid'      => I('post.gid','','trim'),
                'auth_type'      => I('post.auth_type','','trim'),
                'password'       => md5(I('post.password','','trim')),
                'created_at' => time(),
            );
            
           if($this->admin_work_model->findAdminemployeeByName($employee_info['employee_name'])){
               $this->ajaxSuccess('该用户已经被占用');
           }
           
           if($this->admin_work_model->addAdminemployee($employee_info)){
               $this->ajaxSuccess('添加成功');
           }else{
              $this->ajaxError('添加失败');
           }
        }else{
            $admin_auth_group_model = D('AdminAuthGroup');
            $data = $admin_auth_group_model->getGroupList();
            $this->assign('list', $data['list']);
            $this->display();
        }
    }
    
    
    /**
     * @description:编辑用户
     * @author wuyanwen(2016年12月1日)
     */
    public function editEmployee()
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
     * @description:删除用户
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteEmployee()
    {
        $employee_id = I('post.employee_id','','intval');
        
        $result = $this->admin_work_model->deleteAdminemployee($employee_id);
        
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}