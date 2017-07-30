<?php
namespace Admin\Controller;

class CompanyController extends CommonController
{
    protected $company_model;
    protected $company_group_model;

    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $company_model = D('Company');
        $company_group_model = D('CompanyGroup');

        $this->company_model = $company_model;
        $this->company_group_model = $company_group_model;
    }
    
    /**
     * @description:公司列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {

        $company_info = $this->company_model->selectAllCompany();
        $company_info = $this->company_group_model->getAllCompanyGroupById($company_info);
        $this->assign('company_info',$company_info['list']);
        $this->assign('page',$company_info['page']);
        $this->display();
    }

    /**
     * @description:添加公司
     * @author wuyanwen(2016年12月1日)
     */
    public function addCompany()
    {
        if(IS_POST){
            
            $company_info = array(
                'name'      => I('post.name','','trim'),
            );
            
           if($this->company_model->findCompanyByName($company_info['name'])){
               $this->ajaxSuccess('该公司已添加');
           }
           
           if($this->company_model->addCompany($company_info)){
               $this->ajaxSuccess('添加成功');
           }else{
              $this->ajaxError('添加失败');
           }
        }else{
            $this->display();
        }
    }
    
    
    /**
     * @description:编辑公司
     * @author wuyanwen(2016年12月1日)
     */
    public function editCompany()
    {            
        if(IS_POST){
            $company_info = array(
                'name' => I('post.name','','trim'),
                'id' => I('post.id','','trim'),
            );
           if($this->company_model->editCompany($company_info) !== false){
               $this->ajaxSuccess('更新成功');
           }else{
              $this->ajaxError('更新失败');
           }
        }else{
            $company_id = I('get.company_id','','intval');
            $company_info = $this->company_model->findCompanyById($company_id);
            $this->assign('company_info',$company_info);
            $this->display();
        }
    }
    
    
    /**
     * @description:删除公司(及该公司的小组)
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteCompany()
    {
        $company_id = I('post.company_id','','intval');
        
        $result = $this->company_model->deleteCompany($company_id);
        
        if($result){
            $r = $this->company_group_model->findCompanyGroupById($company_id);
            if($r)$this->company_group_model->deleteCompanyGroup($company_id);
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }

    /**
     * @description:添加公司小组
     * @author wuyanwen(2016年12月1日)
     */
    public function addGroup()
    {
        if(IS_POST){

            $group_info = array(
                'cid'      => I('post.company_id','','trim'),
                'group_name'      => I('post.group_name'),

            );
            if($this->company_group_model->findCompanyGroupByName($group_info)){
                $this->ajaxSuccess('该公司小组已添加');
            }

            if($this->company_group_model->addCompanyGroup($group_info)){
                $this->ajaxSuccess('添加成功');
            }else{
                $this->ajaxError('添加失败');
            }
        }else{
            $company_id = I('get.company_id','','intval');
            $this->assign('company_id',$company_id);
            $this->display();
        }
    }
    /**
     * @description:编辑公司小组
     * @author wuyanwen(2016年12月1日)
     */
    public function editCompanyGroup()
    {
        if(IS_POST){
            $group_info = array(
                'group_name' => I('post.group_name','','trim'),
                'id' => I('post.group_id','','trim'),
            );
            if($this->company_group_model->editCompanyGroup($group_info) !== false){
                $this->ajaxSuccess('更新成功');
            }else{
                $this->ajaxError('更新失败');
            }
        }else{
            $group_id = I('get.group_id','','intval');
            $company_group_info = $this->company_group_model->findCompanyGroupById($group_id);
            $this->assign('company_group_info',$company_group_info);
            $this->display();
        }
    }
    /**
     * @description:删除小组)
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteCompanyGroup()
    {
        $group_id = I('post.group_id','','intval');

        $result = $this->company_group_model->deleteCompanyGroup($group_id);

        if($result){

            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }


}