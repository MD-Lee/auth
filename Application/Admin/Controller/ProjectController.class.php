<?php
namespace Admin\Controller;

class ProjectController extends CommonController
{
    protected $project_model;
    protected $admin_user_model;
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_Project_model \Admin\Model\AdminProjectModel */
        $project_model = D('Project');

        $this->project_model = $project_model;

        $admin_user_model = D('AdminUser');

        $this->admin_user_model = $admin_user_model;
    }
    
    /**
     * @description:项目列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        $project_info = $this->project_model->selectAllProject();
        print_r($project_info);
        $this->assign('project_info',$project_info['list']);
        $this->assign('page',$project_info['page']);
        $this->display();
    }

    
    /**
     * @description:添加项目，
     * @author wuyanwen(2016年12月1日)
     */
    public function addProject()
    {
        if(IS_POST){
            
            $project_info = array(
                'project_name'      => I('post.project_name','','trim'),
                'money'       => I('post.money','','trim'),
                'gid'       => I('post.gid','','trim'),
                'cid'       => I('post.cid','','trim'),
                'create_time' => time(),
            );

           if($this->project_model->findProjectByName($project_info['project_name'])){
               $this->ajaxSuccess('该用户已经被占用');
           }

           if($this->project_model->addProject($project_info)){
               $this->ajaxSuccess('添加成功');
           }else{
              $this->ajaxError('添加失败');
           }
        }else{
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

            $project_info = array(
                'eid'      => I('post.eid'),
                'member_ratio'       => I('post.member_ratio'),
                'pid'       => I('post.pid','','trim'),

            );

            if($this->project_model->addProjectMember($project_info)){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }
        }else{
            $project_id = I('get.project_id','','intval');
            $project_info = $this->project_model->findProjectById($project_id);
            $member_info =   $this->admin_user_model->findProjectMemberById($project_info);
            $this->assign('member_info',$member_info);
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

            $cost = serialize(array_combine(I('post.money_name'),I('post.money')));
            $project_info = array(
                'cost'       =>  $cost,

                'id'       => I('post.project_id','','trim'),
                'achievements_ratio'       => I('post.achievements_ratio','','trim'),
            );

            if($this->project_model->editProject($project_info) !== false){
                $this->success('新增成功', 'Project/index');
               // $this->ajaxSuccess('更新成功');
            }else{
                $this->success('更新失败', 'Project/index');
              //  $this->ajaxError('更新失败');
            }
        }else{
            $project_id = I('get.project_id','','intval');
            $project_info = $this->project_model->findProjectById($project_id);
            $cost_info = unserialize( $project_info['cost']);
            $this->assign('cost_info',$cost_info);
            $this->assign('project_id',$project_id);
            $this->assign('achievements_ratio',$project_info['achievements_ratio']);
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