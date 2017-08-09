<?php
namespace Admin\Controller;

class ProjectController extends CommonController
{
    protected $project_model;
    protected $admin_user_model;

    protected $company_model;
    protected $company_group_model;
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_Project_model \Admin\Model\AdminProjectModel */
        $project_model = D('Project');

        $this->project_model = $project_model;

        $admin_user_model = D('AdminUser');

        $this->admin_user_model = $admin_user_model;
        $company_model = D('Company');
        $company_group_model = D('CompanyGroup');

        $this->company_model = $company_model;
        $this->company_group_model = $company_group_model;
    }
    
    /**
     * @description:项目列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {

        //获取当前月的开始时间、结束时间：
        if(I('get.create_time','','trim')){
            $firstday = date('Y-m-01 00:00:00', strtotime(I('get.create_time')));  //本月第一天
            $lastday = date('Y-m-d 23:59:59', strtotime("$firstday +1 month -1 day")); //本月最后一天
            $where['create_time'] = array(array('gt',strtotime($firstday)),array('lt',strtotime($lastday))) ;
            $this->assign('create_time',date('Y-m-d',$where['create_time']) );
        }
        /*搜索条件*/
        I('get.cid','','trim')?$where['cid'] = I('get.cid','','trim'):'';
        I('get.finance_status','','trim')?$where['finance_status'] = I('get.finance_status','','trim'):'';
        I('get.status','','trim')?$where['status'] = I('get.status','','trim'):'';
        //获取数据列表
        $project_info = $this->project_model->selectAllProject(10,$where);
        $create_time = I('get.create_time','','trim')?strtotime(I('get.create_time','','trim')):time();

        $company_list =  $this->admin_user_model->findAllCompany();
        $this->assign('company_list',$company_list);
        $this->assign('project_info',$project_info['list']);
        $this->assign('page',$project_info['page']);
        $this->assign('cid',$where['cid'] );
        $this->assign('finance_status',$where['finance_status'] );
        $this->assign('status',$where['status'] );

        $this->display();
    }

    
    /**
     * @description:添加项目，
     * @author wuyanwen(2016年12月1日)
     */
    public function addProject()
    {

        if(IS_POST){
            $checkmember = session('checkmember');
            $project_id = I('post.project_id','','intval')?I('post.project_id','','intval'):'';

            $project_info = array(
                'checkmember'       => $checkmember,
                'project_name'      => I('post.project_name','','trim'),
                'money'       => I('post.money','','trim'),
                'cid'       => I('post.cid','','trim'),
                'project_id'       => $project_id,
                'create_time' => time(),
            );

            if(empty($project_id)){

                if($this->project_model->findProjectByName($project_info['project_name'])){
                    $this->ajaxError('该项目已添加');
                }

            }
            $result = $this->project_model->addProject($project_info);

           if(!$result['error']){
               $this->ajaxSuccess($result['content']);
           }else{
              $this->ajaxError($result['content']);
           }
        }else{
            session('checkmember',null);
            session('first_member',null);
            print_r(session('first_member'));
            $company = $this->company_model->getAllCompany();
            $project_id = I('get.project_id','','intval');
            $project_info = '';
            if($project_id){
                $project_info = $this->project_model->findProjectById($project_id);
            }


           // print_r($project_info);
            $this->assign('project_info',$project_info);

            $this->assign('company',$company);
            $this->display();
        }
    }
    /**
     * @description:添加项目成员
     * @author wuyanwen(2016年12月1日)
     */
    public function addProjectMember()
    {
        if(IS_POST){
            //Array (
            // [pid] => 1
            // [project_name] => 项目名称
            // [money] => 3 )
            // Array ( [company_member] =>
            // Array ( [0] => Array ( [id] => 17 [user_name] => wuyawnen )
            //          [1] => Array ( [id] => 19 [user_name] => admin2 ) )
            // [member_ratio_value] => Array ( [0] => 2 [1] => 3 [2] => ) )

            $checkmember = session('checkmember');
            $project_info = array(

                'checkmember'       => $checkmember,
                'pid'       => I('post.pid','','trim'),
                'money'       => I('post.money','','trim'),
                'create_time'       => time(),
                'project_name'       => I('post.project_name','','trim'),

            );
            if($this->project_model->findProjectByName($project_info['project_name'])){
                $this->error('该项目已添加');
            }
            if($this->project_model->addProjectMember($project_info)){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $project_id = I('get.project_id','','intval');
            $project_info = $this->project_model->findProjectById($project_id);


            $this->assign('project_id',$project_id);
            $this->display();
        }
    }
    
    /**
     * @description:编辑用户
     * @author wuyanwen(2016年12月1日)
     */
    public function editProject()
    {            
        if(IS_POST){
            $project_info = array(
                'project_name'      => I('post.project_name','','trim'),
                'money'       => I('post.money','','trim'),
                'gid'       => I('post.gid','','trim'),
                'cid'       => I('post.cid','','trim'),
                'id'       => I('post.id','','trim'),
            );
            if($this->project_model->editProject($project_info) !== false){
               $this->ajaxSuccess('更新成功');
           }else{
              $this->ajaxError('更新失败');
           }
        }else{
            $project_id = I('get.project_id','','intval');
            $project_info = $this->project_model->findProjectById($project_id);

            $this->assign('project_info',$project_info);
            $this->display();
        }
    }
    /**
     * @description:项目审核
     * @author wuyanwen(2016年12月1日)
     */
    public function examineProject()
    {
        if(IS_POST){
            $checkmember = session('checkmember');
            $cost = serialize(array_combine(I('post.money_name'),I('post.money')));
            $project_info = array(
                'cost'       =>  $cost,
                'checkmember'       => $checkmember,
                'id'       => I('post.project_id','','trim'),
                'status'       => 1,
            );

            if($this->project_model->editProject($project_info) !== false){

                $this->ajaxSuccess('审核成功');
            }else{

                $this->ajaxError('审核失败');
            }
        }else{
            session('checkmember',null);
            session('first_member',null);
            $project_id = I('get.project_id','','intval');
            $project_info = $this->project_model->findProjectById($project_id);
            $project_info['cost_info'] = unserialize( $project_info['cost']);
            $company = $this->company_model->getAllCompany();
            $this->assign('company',$company);
            $this->assign('project_info',$project_info);

            $this->display();
        }
    }

    
    
    /**
     * @description:删除项目
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteProject()
    {
        $project_id = I('post.project_id','','intval');
        
        $result = $this->project_model->deleteProject($project_id);
        
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}