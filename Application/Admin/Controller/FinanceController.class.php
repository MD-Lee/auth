<?php
namespace Admin\Controller;

class FinanceController extends CommonController
{
    protected $project_model;
    protected $finance_model;

    protected $admin_user_model;

    protected $company_model;

    protected $company_group_model;
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_Project_model \Admin\Model\AdminProjectModel */
        $project_model = D('Project');
        $finance_model = D('Finance');


        $this->project_model = $project_model;

        $admin_user_model = D('AdminUser');

        $this->admin_user_model = $admin_user_model;
        $company_model = D('Company');
        $company_group_model = D('CompanyGroup');

        $this->company_model = $company_model;
        $this->finance_model = $finance_model;

        $this->company_group_model = $company_group_model;
    }

    /**
     * @description:项目列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
        I('get.cid','','trim')?$where['cid'] = I('get.cid','','trim'):'';
        I('get.finance_status','','trim')?$where['finance_status'] = I('get.finance_status','','trim'):'';
        I('get.status','','trim')?$where['status'] = I('get.status','','trim'):'';

        $project_info = $this->project_model->selectAllProject(10,$where);
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
     * @description:项目审核
     * @author wuyanwen(2016年12月1日)
     */
    public function examineProject()
    {
        if(IS_POST){

            $cost = serialize(array_combine(I('post.money_name'),I('post.money')));
            $project_info = array(
                'cost'       =>  $cost,
                'finance_status'=>I('get.finance_status'),
                'id'       => I('post.project_id','','trim'),
            );

            if($this->finance_model->editProject($project_info) !== false){
                //$this->success('新增成功', 'Project/index');
                 $this->ajaxSuccess('审核成功');
            }else{
               // $this->success('更新失败', 'Project/index');
                  $this->ajaxError('审核失败');
            }
        }else{
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
     * @description:分账单
     * @author wuyanwen(2016年12月1日)
     */
    public function splitProject(){
        if(IS_POST){

            $cost = serialize(array_combine(I('post.money_name'),I('post.money')));
            $project_info = array(
                'cost'       =>  $cost,
                'finance_status'=>2,
                'id'       => I('post.project_id','','trim'),
                'received_payments_type'       => I('post.received_payments_type','','trim'),
                'achievements_ratio'       => I('post.achievements_ratio','','trim'),
                'finish_time'       =>time(),
            );

            if($this->finance_model->editProject($project_info) !== false){
                //$this->success('新增成功', 'Project/index');
                $this->ajaxSuccess('审核成功');
            }else{
                // $this->success('更新失败', 'Project/index');
                $this->ajaxError('审核失败');
            }
        }else{
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
     * @description:打印分账单
     * @author wuyanwen(2016年12月1日)
     */
    public function sprintProject(){

        $project_id = I('get.project_id','','intval');
        $project_info = $this->project_model->findProjectById($project_id);
        $project_info['cost_info'] = unserialize( $project_info['cost']);
        $company = $this->company_model->getAllCompany();
        $this->assign('company',$company);
        $this->assign('project_info',$project_info);

        $this->display();

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