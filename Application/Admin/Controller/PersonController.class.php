<?php
namespace Admin\Controller;
use Think\Controller;
class PersonController extends Controller
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
     * @description:修改密码
     * @author wuyanwen(2016年12月1日)
     */
    public function changePwd()
    {
        $user_info = session('user_info');
        if(IS_POST){

            $newPwd     = I('post.newPwd','','trim');
            $oldPwd      = I('post.oldPwd','','trim');
            $confirmPwd      = I('post.confirmPwd','','trim');

            if($newPwd !=$confirmPwd || empty($newPwd) ||empty($oldPwd) ||empty($confirmPwd)){
                $this->ajaxReturn(array('status'=>error,'msg'=>'请正确输入信息或者新密码不能和旧密码相同！'));
            }
            if(!$this->admin_user_model->findAdminUserConfirPwd($oldPwd,$user_info['id'])){
                $this->ajaxReturn(array('status'=>error,'msg'=>'原密码不正确！'));
            }
            $user_info['password'] = md5($newPwd);
            $user_info['reset'] = 1;
            if($this->admin_user_model->editAdminUser($user_info)){
                $this->ajaxReturn(array('status'=>success,'msg'=>'修改成功！'));

            }else{
                $this->ajaxReturn(array('status'=>error,'msg'=>'修改失败！'));

            }

        }else{


            $this->assign('user_info',$user_info);

            $this->display('User:changePwd');
        }

    }
    
    /**
     * @description:添加用户
     * @author wuyanwen(2016年12月1日)
     */
    public function addUser()
    {
        if(IS_POST){
            
            $user_info = array(
                'user_name'      => I('post.user_name','','trim'),
                'mobile'      => I('post.mobile','','trim'),
                'wages'      => I('post.wages','','trim'),
                'sex'      => I('post.sex','','trim'),
                'create_time'      => I('post.create_time'),
                'cid'      => I('post.cid','','trim'),
                'password'       => md5(I('post.password','','trim')),
                'lastlogin_time' => time(),
            );
            
           if($this->admin_user_model->findAdminUserByName($user_info['user_name'])){
               $this->ajaxSuccess('该用户已经被占用');
           }

           if($this->admin_user_model->addAdminUser($user_info)){
               $this->ajaxSuccess('添加成功');
           }else{
              $this->ajaxError('添加失败');
           }
        }else{
            $this->display();
        }
    }
    
    
    /**
     * @description:编辑用户
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