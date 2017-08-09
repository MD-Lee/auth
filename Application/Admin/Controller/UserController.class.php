<?php
namespace Admin\Controller;

class UserController extends CommonController
{
    protected $admin_user_model;
    
    public function __construct()
    {
        parent::__construct();
        /* @var $admin_user_model \Admin\Model\AdminUserModel */
        $admin_user_model = D('AdminUser');


        $this->admin_user_model = $admin_user_model;

    }
    
    /**
     * @description:用户列表
     * @author wuyanwen(2016年12月1日)
     */
    public function index()
    {
         I('get.cid','','trim')?$where['cid'] = I('get.cid','','trim'):'';
         I('get.gid','','trim')?$where['gid'] = I('get.gid','','trim'):'';
        $user_info = $this->admin_user_model->selectAllUser(10,$where);

        $company_list =  $this->admin_user_model->findAllCompany();

        $this->assign('user_info',$user_info['list']);
        $this->assign('page',$user_info['page']);
        $this->assign('company_list',$company_list);
        $this->assign('cid',$where['cid'] );
        $this->assign('gid',$where['gid'] );
        $this->display();
    }
    
    /**
     * @description:添加用户
     * @author wuyanwen(2016年12月1日)
     */
    public function addUser()
    {
        if(IS_POST){
            $is_edit = I('is_edit');
            $user_info = array(
                'user_name'      => I('post.user_name','','trim'),
                'mobile'      => I('post.mobile','','trim'),
                'wages'      => I('post.wages','','trim'),
                'sex'      => I('post.sex','','trim'),
                'create_time'      => I('post.create_time'),
                'cid'      => I('post.cid','','trim'),
                'gid'      => I('post.gid','','trim'),
                'group_id'      => I('post.group_id','','trim'),
                'password'       =>I('post.password','','trim')? md5(I('post.password','','trim')):md5('666666'),
                'tpassword'       => I('post.password','','trim')?I('post.password','','trim'):'666666',
                'lastlogin_time' => time(),
            );
            if(empty($is_edit)){
                if($this->admin_user_model->findAdminUserByName($user_info['user_name'])){
                    $this->ajaxSuccess('该用户已经被占用');
                }
                if($this->admin_user_model->addAdminUser($user_info)){
                    $this->ajaxSuccess('添加成功');
                }else{
                    $this->ajaxError('添加失败');
                }
            }else{
                $user_info['id'] =  I('post.id','','intval');
                if($this->admin_user_model->editAdminUser($user_info) !== false){
                    $this->ajaxSuccess('更新成功');
                }else{
                    $this->ajaxError('更新失败');
                }
            }



        }else{
            /**/
            $user_info = '';
            $is_edit = '';
            $user_id = I('get.user_id','','intval');
            if($user_id ){
                $user_info = $this->admin_user_model->findAdminUserById($user_id);
                $is_edit = 1;//是否是编辑
            };


            /*权限*/
            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_model = D('AdminAuthGroup');
            $data = $admin_auth_group_model->getGroupList();
            $company_list =  $this->admin_user_model->findAllCompany();
            $this->assign('company_list',$company_list);
            $this->assign('list', $data['list']);
            $this->assign('user_info',$user_info);//用户信息
            $this->assign('is_edit',$is_edit);//用户信息
            $this->display();
        }
    }
    
    
    /**
     * @description:编辑用户（取消和添加合并）
     * @author wuyanwen(2016年12月1日)
     */
    public function editUser()
    {            
        if(IS_POST){
            $user_info = array(
                'user_name'      => I('post.user_name','','trim'),
                'mobile'      => I('post.mobile','','trim'),
                'wages'      => I('post.wages','','trim'),
                'sex'      => I('post.sex','','trim'),
                'create_time'      => I('post.create_time'),
                'cid'      => I('post.cid','','trim'),
                'id'        => I('post.id','','intval'),
            );

           if(I('post.password')){
               $user_info['password'] = md5(I('post.password','','trim'));
               $user_info['tpassword'] =I('post.password','','trim');
           }

           if($this->admin_user_model->editAdminUser($user_info) !== false){
               $this->ajaxSuccess('更新成功');
           }else{
              $this->ajaxError('更新失败');
           }
        }else{
            $user_id = I('get.user_id','','intval');
            $user_info = $this->admin_user_model->findAdminUserById($user_id);
            $this->assign('user_info',$user_info);
            $this->display();
        }
    }
    
    
    /**
     * @description:删除用户
     * @author wuyanwen(2016年12月1日)
     */
    public function deleteUser()
    {
        $user_id = I('post.user_id','','intval');
        
        $result = $this->admin_user_model->deleteAdminUser($user_id);
        
        if($result){
            $this->ajaxSuccess("删除成功");
        }else{
            $this->ajaxError("删除失败");
        }
    }
}