<?php
namespace Admin\Model;

class AdminUserModel extends BaseModel
{
    protected $tableName = 'admin_user';
    
    /**
     * @description:查询用户
     * @author wuyanwen(2016年11月22日)
     */
    public function findUser($name, $pwd)
    {
        $where = array(
            'user_name' => $name,
            'password' => md5($pwd),
            'status'   => parent::NORMAL_STATUS,
        );
        
        $result = $this->where($where)->find();
        
        return $result;
    }
    
    /**
     * 根据id更新用户登录时间
     * @author luduoliang <luduoliang@imohoo.com> (2016/12/01)
     * @param unknown $id
     */
    public function updateLoginTime($id)
    {
        $where = array(
            'id' => $id,
        );
        $saveData = array(
            'lastlogin_time' => time(),
        );
        return $this->where($where)->save($saveData);
    }
    
    /**
     * @description:每页显示数目
     * @author wuyanwen(2016年12月1日)
     * @param unknown $num
     * @return multitype:unknown string
     */
    public function selectAllUser($num=10,$where='')
    {

        $where['status'] = parent::NORMAL_STATUS;

        $count      = $this->where($where)->count();
        $page       = new \Think\Page($count,$num);
        $show       = $page->show();
        $list       = $this->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        foreach ($list as & $v){
            $v['sex'] = $v['sex']==1 ? '男' : "女" ;
            $v['company'] = M('company')->where('id='.$v['cid'])->getField('name');
            $v['company_group'] = M('company_group')->where('id='.$v['gid'])->getField('group_name');
            $v['auth_type_name'] = M('admin_auth_group_access')->join('admin_auth_group as b on admin_auth_group_access.group_id = b.id')->where('admin_auth_group_access.uid='.$v['id'])->getField('b.title');
        }
        return array('page' => $show , 'list' => $list);
    
    }
    
    /**
     * @description:添加后台用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     * @return boolean
     */
    public function addAdminUser($data)
    {
        $user_id  = $this->add($data);
        $group_id = $data['group_id'];

        //html_entity_decode($string)
        /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
        $admin_auth_group_access_model = D('AdminAuthGroupAccess');

        if(!empty($group_id)){

            //删除原有角色
            $admin_auth_group_access_model->where(array('uid'=>$user_id))->delete();
                $add_data = array(
                    'uid' => $user_id,
                    'group_id' => $group_id,
                );

                $admin_auth_group_access_model->add($add_data);

        }

        return $user_id ? true : false;
    }
    
    /**
     * @description:更新用户信息
     * @author wuyanwen(2016年12月1日)
     * @param unknown $data
     */
    public function editAdminUser($data)
    {
        $where = array(
            'id'    => $data['id'],
        );
        $group_id = $data['group_id'];
        if(!empty($group_id)){
            /* @var $admin_auth_group_model \Admin\Model\AdminAuthGroupModel */
            $admin_auth_group_access_model = D('AdminAuthGroupAccess');
            if($admin_auth_group_access_model->where(array('uid'=>$data['id']))->find()){
                $admin_auth_group_access_model->where(array('uid'=>$data['id']))->setField('group_id', $group_id);
            }else{
                $add_data = array(
                    'uid' => $data['id'],
                    'group_id' => $group_id,
                );

                $admin_auth_group_access_model->add($add_data);
            }

        }

        return $this->where($where)->save($data);

    }
    
    /**
     * @description:删除用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $user_id
     * @return Ambigous <boolean, unknown>
     */
    public function deleteAdminUser($user_id)
    {
        $where = array(
            'id' => $user_id,            
        );
        
        $data = array(
            'status' => parent::DEL_STATUS,
        );
        
        return $this->where($where)->save($data);
    }
    
    
    /**
     * @description:根据id查询用户
     * @author wuyanwen(2016年12月1日)
     * @param unknown $user_id
     */
    public function findAdminUserById($user_id)
    {
        $where = array(
            'id'     => $user_id,
            'status' => parent::NORMAL_STATUS,
        );
        $user_info = $this->where($where)->find();
        $user_info['group_id'] = M('admin_auth_group_access')->where('uid='.$user_id)->getField('group_id');
        return $user_info;
    }
    
    public function findAdminUserByName($user_name)
    {
        $where = array(
            'user_name' => $user_name,
            'status'    => parent::NORMAL_STATUS,
        );
        
        
        return $this->where($where)->find();
    }
    public function findProjectMemberById($project_info)
    {
        $where = array(
            'gid' => $project_info['gid'],
            'cid'    => $project_info['cid'],

        );
        return $this->where($where)->select();
    }
    public function findAdminUserConfirPwd($pwd,$user_id){
        $where =array(
            'id' => $user_id,
            'password' => md5($pwd),
        );
        $result = $this->where($where)->find();

        return $result;
    }


}